<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Receso extends Model
{
    use HasFactory;

    protected $table = 'recesos';

    public $timestamps = false;

    protected $fillable = [
        'hora_inicio',
        'hora_fin',
        'fechaAlta',
        'fechaModificacion',
        'fk_sesion',
    ];

    public function sesion()
    {
        return $this->belongsTo(Sesion::class, 'fk_sesion');
    }
}
