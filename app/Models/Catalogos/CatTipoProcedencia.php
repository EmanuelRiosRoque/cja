<?php

namespace App\Models\Catalogos;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CatTipoProcedencia extends Model
{
    use HasFactory;

    protected $table = 'catTipoProcedencia';

    public $timestamps = false; 

    protected $fillable = [
        'tipoProcedencia',
        'activo',
    ];

}
