<?php

namespace App\Models\Catalogos;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CatAreaTurno extends Model
{
    use HasFactory;

    protected $table = 'catAreaTurno';

    public $timestamps = false;

    protected $fillable = [
        'areaTurno',
        'activo',
    ];
}
