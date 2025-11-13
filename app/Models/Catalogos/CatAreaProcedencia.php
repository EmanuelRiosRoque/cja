<?php

namespace App\Models\Catalogos;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CatAreaProcedencia extends Model
{
    use HasFactory;

    protected $table = 'catAreaProcedencia';

    public $timestamps = false;

    protected $fillable = [
        'areaProcedencia',
        'activo',
    ];
}
