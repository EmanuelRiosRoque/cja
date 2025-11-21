<?php

namespace App\Models;

use App\Models\Catalogos\CatEstatus;
use Illuminate\Database\Eloquent\Model;

class Tema extends Model
{
    protected $table = 'temas';

    public $timestamps = false;

    protected $fillable = [
        'numeroTema',
        'descripcion',
        'prioridad',
        'esAdicional',
        'fk_sesion',
        'fk_estatus',
    ];

    public function sesion()
    {
        return $this->belongsTo(Sesion::class, 'fk_sesion', 'id');
    }

    public function estatus()
    {
        return $this->belongsTo(CatEstatus::class, 'fk_estatus', 'id');
    }

    public function documentos()
    {
        return $this->hasMany(Documento::class, 'fk_tema', 'id');
    }

    public function presentadores()
    {
        return $this->belongsToMany(
            Presentador::class,
            'presentador_tema',   
            'fk_tema',            
            'fk_presentador'      
        )->withPivot('esPrincipal', 'fechaAlta', 'fechaModificacion');
    }

    public function getTieneMultiplesPresentadoresAttribute(): bool
    {
        return $this->presentadores()->count() > 1;
    }

    public function asignaciones()
{
    return $this->hasMany(TemaAsignado::class, 'fk_tema');
}

}
