<?php

namespace App\Livewire\Sesion\Pleno;

use App\Traits\Tablas\ModalesActionsTrait;
use Livewire\Component;

class Asignados extends Component
{
    use ModalesActionsTrait;

    public $solicitudes;
    public bool $modalCancelar = false;
    public bool $modalEditarRegistro = false;
    public bool $modalEditarTurno = false;
    public bool $modalDocumentos = false;

    public $turnoSeleccionado;
    public $solicitudIdCancelar;
    public $solicitudIdEditarTurno;
    public $documentoActual = null;

    

    public function render()
    {
        return view('livewire.sesion.pleno.asignados');
    }
}
