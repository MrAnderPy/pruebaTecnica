<?php

namespace App\src;

class usuariosServicios
{
    private $usuariosRepositorios;

    public function __construct(usuariosRepositorios $usuariosRepositorios)
    {
        $this->usuariosRepositorios = $usuariosRepositorios;
    }

    public function validarUsuario($request)
    {
      
        $messages = [
            'nombre.required' => 'El nombre es obligatorio',
            'apellido.required' => 'El apellido es obligatorio',
            'cedula.required' => 'La cédula es obligatoria',
            'email.required' => 'El correo electrónico es obligatorio',
            'password.required' => 'La contraseña es obligatoria',
            'area_id.required' => 'El área es obligatoria',
            'email.email' => 'El correo electrónico no es válido'
        ];
        return $request->validate([
            'nombre' => 'required',
            'apellido' => 'required', 
            'cedula' => 'required',
            'email' => 'required|email',
            'password' => 'required',
            'area_id' => 'required'
        ], $messages);
    }
    public function validarArea($id_area, $areas)
    {
        $areas = $areas->pluck('id')->toArray();
        if (!in_array($id_area, $areas)) {
            throw new \Exception('El área no existe');
        }else{
            return true;
        }
    }

    public function validarClave($password){
        if (strlen($password) < 8) {
            throw new \Exception('La contraseña debe tener al menos 8 caracteres');
        }
        //expresiones regulares
        if (!preg_match('/[A-Z]/', $password)) {
            throw new \Exception('La contraseña debe contener al menos una letra mayúscula');
        }
        
        if (!preg_match('/[a-z]/', $password)) {
            throw new \Exception('La contraseña debe contener al menos una letra minúscula');
        }
        
        if (!preg_match('/[0-9]/', $password)) {
            throw new \Exception('La contraseña debe contener al menos un número');
        }
        
        if (!preg_match('/[!@#$%^&*(),.?":{}|<>]/', $password)) {
            throw new \Exception('La contraseña debe contener al menos un carácter especial');
        }
        return true;
    }

    public function generarUsuario($nombre, $apellido, $usuarios){
        $usuarios = $usuarios->pluck('usuario')->toArray();
        $usuarioLimpio = strtolower(substr($nombre, 0, 1) . $apellido);
        $usuario = $usuarioLimpio;
        $contador = 1;
        while(in_array($usuario, $usuarios)){
            $usuario = $usuarioLimpio . $contador;
            $contador ++;
        }
        return $usuario;
    }
}
