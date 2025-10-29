<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Receso extends Model
{
    use HasFactory;

    protected $fillable = [
        'sesion_id',
        'hora_inicio',
        'hora_fin',
    ];

    public function sesion()
    {
        return $this->belongsTo(Sesion::class);
    }
}
