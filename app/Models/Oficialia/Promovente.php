<?php

namespace App\Models\Oficialia;

use App\Models\Catalogos\CatAreaProcedencia;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Promovente extends Model
{
    use HasFactory;

    protected $table = 'promovente';

    public $timestamps = false;

    protected $fillable = [
        'nombre',
        'aPaterno',
        'aMaterno',
        'fechaAlta',
        'usuarioAlta',
        'areaExterna',
        'usuarioModificacion',
        'fk_solicitud',
        'fk_areaProcedencia', 
    ];

    public function areaProcedencia()
    {
        return $this->belongsTo(CatAreaProcedencia::class, 'fk_areaProcedencia');
    }


    protected function nombreCompleto(): Attribute
    {
        return Attribute::get(fn () =>
            trim("{$this->nombre} {$this->aPaterno} {$this->aMaterno}")
        );
    }

    protected function areaProcedenciaNombre(): Attribute
    {
        return Attribute::get(function () {
            return $this->areaProcedencia->areaProcedencia ?? '—';
        });
    }
    

}
