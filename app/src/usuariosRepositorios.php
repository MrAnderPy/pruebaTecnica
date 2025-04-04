<?php

namespace App\src;

use App\Models\Area;
use App\Models\Usuarios;

class usuariosRepositorios
{
    public function getAllUsuarios()
    {
        return Usuarios::all();
    }
    public function getAllAreas()
    {
        return Area::all();
    }
}