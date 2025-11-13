<?php

namespace App\Models\Catalogos;

use Illuminate\Database\Eloquent\Model;

class CatCaracterSesion extends Model
{
    protected $table = 'catCaracteresSesion';

    public $timestamps = false;

    protected $fillable = [
        'nombre', 
        'activo'
    ];
}
