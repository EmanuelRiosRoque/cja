<?php

namespace App\Livewire;

use App\Models\Sesion;
use Livewire\Component;

class SesionList extends Component
{
    public $sesiones = [];
    
    public function mount(){
        $this->sesiones = Sesion::withExists('temas')->get(); // $s->temas_exists -> bool
    }

    public function render()
    {
        return view('livewire.sesion-list');
    }
}
