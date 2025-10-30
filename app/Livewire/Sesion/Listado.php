<?php

namespace App\Livewire\Sesion;

use App\Models\Sesion;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class Listado extends Component
{
    public $sesiones = [];
    public $ponenciaUser;

    public function mount()
    {
        $user = Auth::user();

        // Evita error si no tiene ponencia
        $this->ponenciaUser = $user->ponencia?->id;

        // Consulta dinámica con contador de temas
        $this->sesiones = Sesion::withCount('temas') // 👈 agrega contador de temas
            ->with(['temas.presentadores.ponencia'])
            ->when($this->ponenciaUser, function ($query) use ($user) {
                $query->whereHas('temas.presentadores', function ($sub) use ($user) {
                    $sub->where('ponencia_id', $user->ponencia_id);
                });
            })
            ->get();
    }

    public function render()
    {
        return view('livewire.sesion.listado');
    }
}
