<?php

namespace App\Models\Catalogos;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CatTipoDoc extends Model
{
    use HasFactory;

    protected $table = 'catTipoDoc';

    public $timestamps = false; 

    protected $fillable = [
        'tipoDoc',
        'activo',
    ];

}
