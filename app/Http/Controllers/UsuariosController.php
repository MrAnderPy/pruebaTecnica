<?php

namespace App\Http\Controllers;

use App\Models\Usuarios;
use App\src\usuariosRepositorios;
use App\src\usuariosServicios;
use Illuminate\Http\Request;

class UsuariosController extends Controller
{
    private $usuariosRepositorios;
    private $usuariosServicios;

    public function __construct(usuariosRepositorios $usuariosRepositorios, usuariosServicios $usuariosServicios)
    {
        $this->usuariosRepositorios = $usuariosRepositorios;
        $this->usuariosServicios = $usuariosServicios;
    }

    public function index()
    {
        $usuarios = $this->usuariosRepositorios->getAllUsuarios();
        return response()->json($usuarios);
    }

    public function store(Request $request)
    {
        try {
            $usuarios = $this->usuariosRepositorios->getAllUsuarios();
            $areas = $this->usuariosRepositorios->getAllAreas();
            $this->usuariosServicios->validarUsuario($request);
            $this->usuariosServicios->validarArea($request->area_id, $areas);
            $this->usuariosServicios->validarClave($request->password);
            $usuarioGenerado = $this->usuariosServicios->generarUsuario($request->nombre, $request->apellido, $usuarios);
            $usuarioCreado = $this->usuariosRepositorios->guardarUsuario($request, $usuarioGenerado);
            return response()->json([
                'message' => 'Usuario generado con éxito',
                'usuario' => $usuarioCreado
            ]);
        } catch (\Throwable $th) {
            return response()->json(['error' => $th->getMessage()], 422);
        }
    }

    public function show($id) {
        try {
            $usuario = $this->usuariosRepositorios->buscarUsuarioPorId($id);
            if (!$usuario) {
                return response()->json([
                    'error' => 'Usuario no encontrado'
                ], 404);
            }
            return response()->json([
                'usuario' => $usuario
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'error' => $th->getMessage()
            ], 422);
        }
    }

    public function update(Request $request, $id)
    {
        try {
            $areas = $this->usuariosRepositorios->getAllAreas();
            $this->usuariosServicios->validarUsuario($request);
            $this->usuariosServicios->validarArea($request->area_id, $areas);
            $this->usuariosServicios->validarClave($request->password);

            $usuarioExistente = $this->usuariosRepositorios->buscarUsuarioPorId($id);
            $usuarios = $this->usuariosRepositorios->getAllUsuarios();
            if (
                $request->nombre !== $usuarioExistente->nombre ||
                $request->apellido !== $usuarioExistente->apellido) 
                {
                $usuarioGenerado = $this->usuariosServicios->generarUsuario(
                    $request->nombre,
                    $request->apellido,
                    $usuarios->where('id', '!=', $id) 
                );
                $request->merge(['usuario' => $usuarioGenerado]);
            }
           
            $usuarioActualizado = $this->usuariosRepositorios->actualizarUsuario($request, $id);
    
            return response()->json([
                'message' => 'Usuario actualizado con éxito',
                'usuario' => $usuarioActualizado
            ]);
        } catch (\Throwable $th) {
            return response()->json(['error' => $th->getMessage()], 422);
        }
    }
    

    public function delete($id){
        try {
            $eliminar = $this->usuariosRepositorios->eliminarUsuario($id);
            if ($eliminar) {
                return response()->json([
                    'message' => 'Usuario eliminado con éxito',
                ]);
            }
            else {
                return response()->json([
                    'message' => 'Usuario no encontrado',
                ], 404);
            }
        } catch (\Throwable $th) {
            return response()->json([
                'error' => $th->getMessage()
            ], 422);
        }
    }

}
