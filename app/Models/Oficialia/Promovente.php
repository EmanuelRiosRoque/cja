<?php

namespace App\Models\Oficialia;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Promovente extends Model
{
    use HasFactory;

    protected $table = 'promovente';

    public $timestamps = false;

    protected $fillable = [
        'nombre',
        'aPaterno',
        'aMaterno',
        'fechaAlta',
        'usuarioAlta',
        'usuarioModificacion',
        'fk_solicitud',
        'fk_areaProcedencia', 
    ];
}
