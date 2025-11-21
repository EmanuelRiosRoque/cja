<?php

namespace App\Models;

use App\Models\Catalogos\CatCaracterSesion;
use App\Models\Catalogos\CatEstatus;
use App\Models\Catalogos\CatSede;
use App\Models\Catalogos\CatTipoSesion;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sesion extends Model
{
    use HasFactory;

    protected $table = 'sesiones';

    public $timestamps = false;

    protected $fillable = [
        'folio',
        'forma_captura',
        'fecha_programada',
        'hora_programada',
        'hora_termino',
        'fechaAlta',
        'fechaModificacion',
        'fk_sede',
        'fk_tipo_sesion',
        'fk_estatus',
        'fk_caracter'
    ];

    public function recesos()
    {
        return $this->hasMany(Receso::class, 'fk_sesion');
    }

    public function sede()
    {
        return $this->belongsTo(CatSede::class);
    }

    public function estatus()
    {
        return $this->belongsTo(CatEstatus::class);
    }

    public function tipoSesion()
    {
        return $this->belongsTo(CatTipoSesion::class);
    }

    public function caracter()
    {
        return $this->belongsTo(CatCaracterSesion::class, 'fk_caracter', 'id');
    }

    public function temas()
    {
        return $this->hasMany(Tema::class, 'fk_sesion', 'id');
    }



    protected static function booted()
    {
        /**
         * ---------------------------------------------------------------------
         * Evento: created
         * ---------------------------------------------------------------------
         * Se ejecuta inmediatamente después de que se inserta un nuevo registro
         * en la base de datos.
         *
         * En este caso, genera un número de folio automáticamente basado en el
         * ID del registro y el año actual.
         *
         * Ejemplo de resultado:  "01/2025", "02/2025", etc.
         */
        static::created(function ($sesion) {
            // Obtener el año actual (ej. "2025")
            $anio = now()->format('Y');
            // Convertir el ID en número con ceros a la izquierda (ej: 01, 02, 03...)
            $numero = str_pad($sesion->id, 2, '0', STR_PAD_LEFT);
            // Formar el folio final
            $sesion->folio = "{$numero}/{$anio}";
            $sesion->saveQuietly();
        });
    }
}
