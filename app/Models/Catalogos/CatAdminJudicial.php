<?php

namespace App\Models\Catalogos;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CatAdminJudicial extends Model
{
    use HasFactory;

    protected $table = 'catAdminJudicial';

    public $timestamps = false;

    protected $fillable = [
        'nombre',
        'activo',
    ];
}
