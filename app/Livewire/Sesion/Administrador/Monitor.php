<?php

namespace App\Livewire\Sesion\Administrador;

use Livewire\Component;

class Monitor extends Component
{
    public $sesion;
    public $temas = [];

    public function mount($sesion) {
         $this->temas = $sesion->temas()
            ->with('presentadores')
            ->orderBy('numero_tema')
            ->get();
    }

    public function render()
    {
        return view('livewire.sesion.administrador.monitor');
    }
}
