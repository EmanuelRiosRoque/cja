<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Sesion;

class SesionTemas extends Component
{
    /** @var \App\Models\Sesion */
    public $sesion;

    public $temas = [];

    public function mount($sesion)
    {
        $this->sesion = $sesion;

        $this->temas = $sesion->temas()
            ->with('presentadores')
            ->orderBy('numero_tema')
            ->get();
    }


    public function render()
    {
        return view('livewire.sesion-temas', [
            'temas' => $this->temas,
        ]);
    }
}
