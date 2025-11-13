<?php

namespace App\Models\Catalogos;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class CatSede extends Model
{
    use HasFactory;

    protected $table = 'catSedes';

    public $timestamps = false; 

    protected $fillable = [
        'nombre',
        'activo',
        'fechaAlta',
        'fechaModificacion',
    ];
}
