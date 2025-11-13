<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Documento extends Model
{
    protected $table = 'documentos';

    protected $fillable = [
        'nombre',
        'idGlobal',
        'rutaGlobal',
        'tipoArchivo',
        'fechaAlta',
        'fechaModificacion',
        'fk_solicitud',
        'fk_tema'
    ];

    public $timestamps = false; // si tu tabla no tiene created_at y updated_at
}
