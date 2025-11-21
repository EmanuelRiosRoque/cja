<?php

namespace App\Models\Catalogos;

use App\Models\Sesion;
use Illuminate\Database\Eloquent\Model;

class CatCaracterSesion extends Model
{
    protected $table = 'catCaracteresSesion';

    public $timestamps = false;

    protected $fillable = [
        'nombre', 
        'activo'
    ];

    public function sesiones()
    {
        return $this->hasMany(Sesion::class, 'fk_caracter', 'id');
    }

}
