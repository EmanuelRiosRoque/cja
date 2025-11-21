<?php

namespace App\Livewire\Oficialia;

use App\Models\Oficialia\Solicitud;
use App\Traits\Tablas\ModalesActionsTrait;
use Livewire\Component;

class Turnos extends Component
{
    use ModalesActionsTrait;

    public bool $modalCancelar = false;
    public bool $modalEditarRegistro = false;
    public bool $modalEditarTurno = false;
    public bool $modalDocumentos = false;

    public $turnoSeleccionado;
    public $solicitudIdCancelar;
    public $solicitudIdEditarTurno;

    public $documentoActual = null;

    // Campos del formulario
    public $tipo_procedencia; 
    public $area_procedencia; 
    public $entrega;
    public $no_oficio;
    public $promovente; 
    public $tipo;
    public $turno; 
    public $anexos;
    public $descripcion; 
    public $descripcion_anexos;
    public $documentos;
    public $solicitudes = [];

    public function mount() {
        $this->solicitudes = Solicitud::where('fk_estatus', '!=', 4)->get();
    }

    public function render()
    {
        return view('livewire.oficialia.turnos');
    }
}
