<?php

namespace App\Livewire\Sesion;

use Livewire\Component;

class Ponencia extends Component
{

    public $sesion;
    
    public function render()
    {
        return view('livewire.sesion.ponencia');
    }
}
