<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CaracterSesion extends Model
{
    protected $table = 'caracteres_sesion';
    protected $fillable = ['nombre', 'activo'];
}
