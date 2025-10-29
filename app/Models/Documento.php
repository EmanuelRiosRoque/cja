<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Documento extends Model
{
    use HasFactory;

    protected $table = 'documentos';

    protected $fillable = [
        'tema_id',
        'nombre',
        'url',
        'idGlobal',
        'tipo',
    ];

    public function tema()
    {
        return $this->belongsTo(Tema::class);
    }
}
