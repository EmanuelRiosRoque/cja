<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sesion extends Model
{
    use HasFactory;

    protected $table = 'sesiones';

    protected $fillable = [
        'forma_captura',
        'sede_id',
        'folio',
        'tipo_sesion_id',
        'caracter_id',
        'fecha_programada',
        'hora_programada',
        'hora_termino',
    ];

    public function sede()
    {
        return $this->belongsTo(Sede::class);
    }

    public function tipoSesion()
    {
        return $this->belongsTo(TipoSesion::class);
    }

    public function caracter()
    {
        return $this->belongsTo(CaracterSesion::class);
    }

    public function temas()
    {
        return $this->hasMany(Tema::class);
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
