<?php

namespace App\Models\Oficialia;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Catalogos\CatEntrega;
use App\Models\Catalogos\CatTipoProcedencia;
use App\Models\Catalogos\CatAreaTurno;
use App\Models\Catalogos\CatEstatus;
use App\Models\Catalogos\CatAnexo;
use App\Models\Catalogos\CatTipoDoc;
use Illuminate\Database\Eloquent\Casts\Attribute;

class Solicitud extends Model
{
    use HasFactory;

    protected $table = 'solicitud';

    public $timestamps = false;

    protected $fillable = [
        'folio',
        'fechaRecepcion',
        'numOficio',
        'descripcion',
        'descripcionAnexos',
        'fechaAlta',
        'usuarioAlta',
        'usuarioModificacion',
        // 'areaExterna',
        'fk_entrega',
        'fk_tipoProcedencia',
        'fk_areaTurno',
        'fk_tipoDoc',
        'fk_estatus',
        'fk_anexo',
    ];

    // Relaciones
    public function entrega()
    {
        return $this->belongsTo(CatEntrega::class, 'fk_entrega');
    }

    public function tipoProcedencia()
    {
        return $this->belongsTo(CatTipoProcedencia::class, 'fk_tipoProcedencia');
    }

    public function areaTurno()
    {
        return $this->belongsTo(CatAreaTurno::class, 'fk_areaTurno');
    }

    public function tipoDocumento()
    {
        return $this->belongsTo(CatTipoDoc::class, 'fk_tipoDoc');
    }

    public function estatus()
    {
        return $this->belongsTo(CatEstatus::class, 'fk_estatus');
    }

    public function tipoDoc()
    {
        return $this->belongsTo(CatTipoDoc::class, 'fk_tipoDoc');
    }

    public function anexo()
    {
        return $this->belongsTo(CatAnexo::class, 'fk_anexo');
    }

    public function promoventes()
    {
        return $this->hasMany(Promovente::class, 'fk_solicitud');
    }


    protected function promoventesNombres(): Attribute
    {
        return Attribute::get(function () {
            // Si no hay promoventes, devolvemos guion
            if ($this->promoventes->isEmpty()) {
                return '—';
            }

            // Tomamos el accessor nombre_completo del modelo Promovente
            return $this->promoventes
                ->pluck('nombre_completo')
                ->join(', ');
        });
    }


    protected function promoventesAreas(): Attribute
    {
        return Attribute::get(function () {

            // Si la solicitud no tiene promoventes
            if ($this->promoventes->isEmpty()) {
                return '—';
            }

            // 1 Buscar áreas internas (CATÁLOGO)
            $areasInternas = $this->promoventes
                ->filter(fn ($p) => $p->fk_areaProcedencia) // solo internos
                ->map(fn ($p) => optional($p->areaProcedencia)->areaProcedencia)
                ->filter()
                ->unique()
                ->values();

            // Si hay áreas internas → devolverlas
            if ($areasInternas->isNotEmpty()) {
                return $areasInternas->join(', ');
            }

            // 2 SI NO HAY ÁREAS INTERNAS → usar áreas externas
            $areasExternas = $this->promoventes
                ->map(fn ($p) => $p->areaExterna)
                ->filter()
                ->unique()
                ->values();

            return $areasExternas->isNotEmpty()
                ? $areasExternas->join(', ')
                : '—';
        });
    }


}
