<?php

namespace App\Models\Catalogos;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CatEntrega extends Model
{
    use HasFactory;

    protected $table = 'catEntrega';

    public $timestamps = false;

    protected $fillable = [
        'entrega',
        'activo',
    ];
}
