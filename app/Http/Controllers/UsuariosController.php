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
            $usuarios = $this->usuariosServicios->validarUsuario($request);
            $areas = $this->usuariosRepositorios->getAllAreas();
            $this->usuariosServicios->validarArea($request->area_id, $areas);
            $this->usuariosServicios->validarClave($request->password);
            $this->usuariosServicios->generarUsuario($request->nombre, $request->apellido);
            return response()->json($usuarios);
        } catch (\Throwable $th) {
            return response()->json(['error' => $th->getMessage()], 422);
        }
      
    }



}
