<?php

namespace App\Models;

use App\Models\Catalogos\CatAdminJudicial;
use Illuminate\Database\Eloquent\Model;

class Presentador extends Model
{
    protected $table = 'presentadores';

    public $timestamps = false;

    protected $fillable = [
        'nombre',
        'cargo',
    ];

    public function temas()
    {
        return $this->belongsToMany(Tema::class, 'presentador_tema')
                    ->withPivot('es_principal')
                    ->withTimestamps();
    }
    
    public function getNombreConCargoAttribute()
    {
        return $this->cargo
            ? "{$this->nombre} ({$this->cargo})"
            : $this->nombre;
    }

    public function adminJudicial() {
        return $this->belongsTo(CatAdminJudicial::class);
    }

}
