<?php

namespace App\src;

use App\Models\Area;
use App\Models\Usuarios;

class usuariosRepositorios
{
    public function getAllUsuarios()
    {
        return Usuarios::select('usuarios.*', 'a.nombre_area')->join('area as a', 'a.id', '=', 'usuarios.area_id')->get();
    }
    public function getAllAreas()
    {
        return Area::all();
    }
    public function guardarUsuario($request, $usuarioGenerado){
        return Usuarios::create([
            'nombre' => $request->nombre,
            'apellido' => $request->apellido,
            'cedula' => $request->cedula,
            'password' => bcrypt($request->password),
            'email' => $request->email,
            'area_id' => $request->area_id,
            'usuario' => $usuarioGenerado
        ]);
    }

    public function buscarUsuarioPorId($id){
        return Usuarios::select('usuarios.*', 'a.nombre_area')
            ->join('area as a', 'a.id', '=', 'usuarios.area_id')
            ->where('usuarios.id', $id)
            ->first();
    }

    public function actualizarUsuario($request, $id){
        $usuario = Usuarios::find($id);
        if($usuario) {
            $usuario->update([
                'nombre' => $request->nombre,
                'apellido' => $request->apellido,
                'cedula' => $request->cedula,
                'password' => bcrypt($request->password),
                'email' => $request->email,
                'area_id' => $request->area_id,
                'usuario' => $request->usuario ?? $usuario->usuario,
            ]);
            return $usuario;
        }
        return null;
    }
    public function eliminarusuario($id){
        $usuario = Usuarios::find($id);
        if($usuario) {
            $usuario->delete();
            return true;
        }
        return false;
    }
    
}