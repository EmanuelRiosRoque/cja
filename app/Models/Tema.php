<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tema extends Model
{
    protected $table = 'temas';

    protected $fillable = [
        'sesion_id',
        'numero_tema',
        'descripcion',
        'prioridad',
        'es_asunto_adicional',
    ];

    public function sesion()
    {
        return $this->belongsTo(Sesion::class);
    }

    public function estatus()
    {
        return $this->belongsTo(Estatus::class);
    }

    public function documentos()
    {
        return $this->hasMany(Documento::class, 'tema_id');
    }
    
    public function presentadores()
    {
        return $this->belongsToMany(Presentador::class, 'presentador_tema')
                    ->withPivot('es_principal')
                    ->withTimestamps();
    }

    public function getTieneMultiplesPresentadoresAttribute(): bool
    {
        return $this->presentadores()->count() > 1;
    }
}
