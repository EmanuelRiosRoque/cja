<?php

namespace App\Livewire\Oficialia;

use Livewire\Component;
use App\Models\Oficialia\Solicitud;
use App\Models\Catalogos\CatEntrega;
use App\Models\Catalogos\CatTipoDoc;
use App\Models\Catalogos\CatAreaTurno;
use App\Models\Catalogos\CatAnexo;
use App\Models\Catalogos\CatTipoProcedencia;
use App\Models\Catalogos\CatAreaProcedencia;
use App\Models\Oficialia\Promovente;
use Illuminate\Support\Carbon;

class RegistroDocumento extends Component
{

    public $idSolicitud;
    public $modoEdicion;

    public $catEntregas = [];
    public $catTipoDocs = [];
    public $catTurnos = [];
    public $catAnexos = [];
    public $catProcedencias = [];
    public $catAreaProcedencias = [];

    public $fecha_recepcion;
    public $tipo_entrega;
    public $tipo;
    public $no_oficio;
    public $turno;
    public $descripcion;
    public $anexos;
    public $descripcion_anexos;

    public $nombre;
    public $paterno;
    public $materno;

    public $promoventes = [];

    public $tipo_procedencia;
    public $area_procedencia_text;
    public $area_procedencia;

    public bool $mostrarModalConfirmacion = false;

    protected $rules = [
        'fecha_recepcion' => 'required|date',
        'tipo_entrega' => 'required|integer',
        'tipo' => 'required|integer',
        'no_oficio' => 'required|string|max:255',
        'turno' => 'required|integer',
        'descripcion' => 'required|string|max:1000',
        'anexos' => 'required|integer',
        'descripcion_anexos' => 'nullable|string|max:500',
        'tipo_procedencia' => 'required|integer',
        'area_procedencia' => 'nullable|string|max:255',
        'area_procedencia_text' => 'nullable|string|max:255',
    ];

   public function mount($idSolicitud = null)
{
    $this->catEntregas = CatEntrega::where('activo', 1)->get();
    $this->catTipoDocs = CatTipoDoc::where('activo', 1)->get();
    $this->catTurnos = CatAreaTurno::where('activo', 1)->get();
    $this->catAnexos = CatAnexo::where('activo', 1)->get();
    $this->catProcedencias = CatTipoProcedencia::where('activo', 1)->get();
    $this->catAreaProcedencias = CatAreaProcedencia::where('activo', 1)->get();

    if ($idSolicitud) {
        $this->modoEdicion = true;   

        $solicitud = Solicitud::with('promoventes')->find($idSolicitud);

        if ($solicitud) {
            $this->idSolicitud = $idSolicitud;

            $this->fecha_recepcion = $solicitud->fechaRecepcion
                ? Carbon::parse($solicitud->fechaRecepcion)->format('Y-m-d')
                : null;

            $this->tipo_entrega       = $solicitud->fk_entrega;
            $this->tipo               = $solicitud->fk_tipoDoc;
            $this->no_oficio          = $solicitud->numOficio;
            $this->turno              = $solicitud->fk_areaTurno;
            $this->descripcion        = $solicitud->descripcion;
            $this->anexos             = $solicitud->fk_anexo;
            $this->descripcion_anexos = $solicitud->descripcionAnexos;
            $this->tipo_procedencia   = $solicitud->fk_tipoProcedencia;

            if ($solicitud->fk_tipoProcedencia == 2) {
                $this->area_procedencia_text = $solicitud->areaExterna;
            } else {
                $this->area_procedencia = $solicitud->areaExterna;
            }

            $this->promoventes = $solicitud->promoventes->map(function ($p) {
                return [
                    'nombre'      => $p->nombre,
                    'paterno'     => $p->aPaterno,
                    'materno'     => $p->aMaterno,
                    'area_id'     => $p->fk_areaProcedencia,
                    'area_nombre' => $p->areaExterna,
                ];
            })->toArray();
        }
    }
}

public function actualizarRegistro()
{
    $this->validate();

    $solicitud = Solicitud::find($this->idSolicitud);

    if (!$solicitud) return;

    $areaExterna = $this->tipo_procedencia == 2
        ? $this->area_procedencia_text
        : $this->area_procedencia;

    $solicitud->update([
        'fechaRecepcion' => $this->fecha_recepcion,
        'numOficio' => $this->no_oficio,
        'descripcion' => $this->descripcion,
        'descripcionAnexos' => $this->descripcion_anexos,
        'fk_entrega' => $this->tipo_entrega,
        'fk_tipoDoc' => $this->tipo,
        'fk_areaTurno' => $this->turno,
        'fk_tipoProcedencia' => $this->tipo_procedencia,
        'areaExterna' => $areaExterna,
        'fk_anexo' => $this->anexos,
        'usuarioModificacion' => auth()->id() ?? 1,
    ]);

    Promovente::where('fk_solicitud', $solicitud->id)->delete();

    foreach ($this->promoventes as $item) {
        Promovente::create([
            'nombre'              => $item['nombre'],
            'aPaterno'            => $item['paterno'],
            'aMaterno'            => $item['materno'],
            'areaExterna'         => $item['area_nombre'],
            'fk_areaProcedencia'  => $item['area_id'],
            'fk_solicitud'        => $solicitud->id,
            'fechaAlta'           => Carbon::now(),
            'usuarioAlta'         => auth()->id() ?? 1,
            'usuarioModificacion' => auth()->id() ?? 1,
        ]);
    }
        $this->mostrarModalConfirmacion = false;
        $this->mount();
        $this->dispatch('form-enviado');
    session()->flash('success', 'La solicitud fue actualizada correctamente.');
}



    public function realizarRegistro()
    {
        $this->validate();

        $areaExterna = $this->tipo_procedencia == 2
            ? $this->area_procedencia_text
            : $this->area_procedencia;

        // 1 Crear solicitud
        $solicitud = Solicitud::create([
            'folio' => 'TEMP-' . time(),
            'fechaRecepcion' => $this->fecha_recepcion,
            'numOficio' => $this->no_oficio,
            'descripcion' => $this->descripcion,
            'descripcionAnexos' => $this->descripcion_anexos,
            'fechaAlta' => Carbon::now(),
            'usuarioAlta' => auth()->id() ?? 1,
            'usuarioModificacion' => auth()->id() ?? 1,
            'areaExterna' => $areaExterna,
            'fk_entrega' => $this->tipo_entrega,
            'fk_tipoProcedencia' => $this->tipo_procedencia,
            'fk_areaTurno' => $this->turno,
            'fk_tipoDoc' => $this->tipo,
            'fk_estatus' => 1,
            'fk_anexo' => $this->anexos,
        ]);

        // 2 Insertar promoventes
        if (!empty($this->promoventes)) {
            foreach ($this->promoventes as $item) {

                if (
                    !empty($item['nombre']) ||
                    !empty($item['paterno']) ||
                    !empty($item['materno'])
                ) {
                    Promovente::create([
                        'nombre'              => $item['nombre'] ?? null,
                        'aPaterno'            => $item['paterno'] ?? null,
                        'aMaterno'            => $item['materno'] ?? null,
                        'areaExterna'         => $item['area_nombre'] ?? null,
                        'fechaAlta'           => Carbon::now(),
                        'usuarioAlta'         => auth()->id() ?? 1,
                        'usuarioModificacion' => auth()->id() ?? 1,
                        'fk_solicitud'        => $solicitud->id,
                        'fk_areaProcedencia'  => $item['area_id'] ?? null, // ← ID REAL
                    ]);
                }
            }
        }

        // 3 Limpiar campos
        $this->reset([
            'fecha_recepcion',
            'tipo_entrega',
            'tipo',
            'no_oficio',
            'turno',
            'descripcion',
            'anexos',
            'descripcion_anexos',
            'tipo_procedencia',
            'area_procedencia_text',
            'area_procedencia',
            'nombre',
            'paterno',
            'materno',
            'promoventes',
        ]);

        $this->mostrarModalConfirmacion = false;
        $this->mount();
        $this->dispatch('form-enviado');

        session()->flash('success', 'El registro se realizó correctamente.');
    }

    public function agregarPromovente()
    {
        $this->validate([
            'nombre' => 'required|string',
            'paterno' => 'required|string',
            'materno' => 'nullable|string',

            'tipo_procedencia' => 'required',
            'area_procedencia' => 'required_if:tipo_procedencia,1,3',
            'area_procedencia_text' => 'required_if:tipo_procedencia,2',
        ]);

        // Si es interno → hay ID
        // Si es externo → no hay ID
        $areaId = null;
        $areaNombre = null;

        if ($this->tipo_procedencia == 2) {
            // Externa
            $areaNombre = $this->area_procedencia_text;
        } else {
            // Interna
            $areaId = $this->area_procedencia;
            $areaNombre = optional(
                $this->catAreaProcedencias->firstWhere('id', $this->area_procedencia)
            )->areaProcedencia;
        }

        $this->promoventes[] = [
            'nombre' => $this->nombre,
            'paterno' => $this->paterno,
            'materno' => $this->materno,
            'area_id' => $areaId,         // ← Se envía al insert
            'area_nombre' => $areaNombre, // ← Para mostrar en la tabla
        ];

        $this->reset(['nombre', 'paterno', 'materno', 'area_procedencia', 'area_procedencia_text']);
    }

    public function eliminarPromovente($index)
    {
        unset($this->promoventes[$index]);
        $this->promoventes = array_values($this->promoventes);
    }

    public function render()
    {
        return view('livewire.oficialia.registro-documento');
    }
}
