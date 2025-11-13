<?php

namespace App\Models\Catalogos;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CatAnexo extends Model
{
    use HasFactory;

    protected $table = 'catAnexo';

    public $timestamps = false;

    protected $fillable = [
        'anexo',
        'activo',
    ];
}
