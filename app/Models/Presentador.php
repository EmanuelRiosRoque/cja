<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Presentador extends Model
{
    protected $table = 'presentadores';

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

}
