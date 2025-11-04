<?php

namespace App\Livewire\Oficialia;

use Livewire\Component;

class RegistroDocumento extends Component
{


    public bool $mostrarModalConfirmacion = false;
    public bool $mostrarModalExito = false;

    public function realizarRegistro()
    {
        // Cierra el primer modal
        $this->mostrarModalConfirmacion = false;

        // (Opcional) validaciones y guardado
        // $this->validate([...]);
        // Modelo::create([...]);

        // Muestra el modal de éxito
        $this->mostrarModalExito = true;
    }

    public function cerrarModalExito()
    {
        $this->mostrarModalExito = false;

        // Redirigir a otra vista
        // return redirect()->route('oficialia.turnos'); 
    }

    public function render()
    {
        return view('livewire.oficialia.registro-documento');
    }
}
