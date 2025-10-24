<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TipoSesion extends Model
{
    protected $table = 'tipos_sesion';
    protected $fillable = ['nombre', 'activo',];
}
