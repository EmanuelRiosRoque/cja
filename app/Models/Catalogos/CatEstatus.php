<?php

namespace App\Models\Catalogos;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CatEstatus extends Model
{
    use HasFactory;

    protected $table = 'catEstatus';

    public $timestamps = false;

    protected $fillable = [
        'estatus',
        'activo',
    ];

}
