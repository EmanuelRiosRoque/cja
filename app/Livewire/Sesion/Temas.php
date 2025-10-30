<?php

namespace App\Livewire\Sesion;

use Livewire\Component;
use App\Models\Sesion;

class Temas extends Component
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
        return view('livewire.sesion.temas', [
            'temas' => $this->temas,
        ]);
    }
}
