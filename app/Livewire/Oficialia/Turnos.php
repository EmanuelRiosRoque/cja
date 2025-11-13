<?php

namespace App\Livewire\Oficialia;

use Livewire\Component;

class Turnos extends Component
{
    public bool $modalCancelar = false;
    public bool $modalEditarRegistro = false;

    public bool $modalEditarTurno = false;
    public $turnoSeleccionado;

    // Campos del formulario
    public 
        $tipo_procedencia, 
        $area_procedencia, 
        $entrega;

    public 
        $no_oficio,
        $promovente, 
        $tipo;

    public 
        $turno, 
        $anexos, 
        $descripcion, 
        $descripcion_anexos;

    public function abrirModalCancelar()
    {
        $this->modalCancelar = true;
    }

    public function confirmarCancelar()
    {
        // Aquí iría tu lógica de cancelación
        session()->flash('message', 'Registro cancelado correctamente.');
        $this->modalCancelar = false;
    }

    public function abrirModalEditarRegistro()
    {
        $this->reset(['tipo_procedencia', 'area_procedencia', 'entrega', 'no_oficio', 'promovente', 'tipo', 'turno', 'anexos', 'descripcion', 'descripcion_anexos']);
        $this->modalEditarRegistro = true;
    }

    public function abrirModalEditarTurno()
    {
        $this->reset('turnoSeleccionado');
        $this->modalEditarTurno = true;
    }

    public function confirmarEditarTurno()
    {
        session()->flash('message', "El turno fue actualizado correctamente a: {$this->turnoSeleccionado}.");
        $this->modalEditarTurno = false;
    }


    public function confirmarEditarRegistro()
    {
        session()->flash('message', 'El registro fue editado correctamente.');
        $this->modalEditarRegistro = false;
    }
    public function render()
    {
        return view('livewire.oficialia.turnos');
    }
}
