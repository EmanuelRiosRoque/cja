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
        'areaExterna',
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

    public function anexo()
    {
        return $this->belongsTo(CatAnexo::class, 'fk_anexo');
    }
}
