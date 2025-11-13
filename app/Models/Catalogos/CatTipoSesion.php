<?php

namespace App\Models\Catalogos;

use Illuminate\Database\Eloquent\Model;

class CatTipoSesion extends Model
{
    protected $table = 'catTiposSesion';
    
    public $timestamps = false;

    protected $fillable = ['nombre', 'activo'];
}
