<?php

namespace App\Livewire\Wizards\Steps;

use Livewire\Attributes\Modelable;
use Livewire\Component;

class BasicInfo extends Component
{
    #[Modelable]
    public array $form = [
        'modalidad'   => '',      // 'linea' | 'presencial'
        'materia'     => '',      // 'civil' | 'mercantil' | 'familiar'
        'canalizado'  => null,    // '0' | '1'
        'institucion' => null,    // string|null
        'ticket'      => null,    // int|null
        'attachments' => [],      // si usas dropzone modelable aquí
        // si aún necesitas estos por compatibilidad, puedes dejarlos vacíos:
        // 'subject'  => '',
        // 'type'     => '',
    ];

    public function render()
    {
        return view('livewire.wizards.steps.basic-info');
    }
}
