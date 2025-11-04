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
        $this->ponenciaUser = $user->ponencia?->id;

        $this->sesiones = Sesion::withCount('temas')
            ->with(['temas.presentadores.ponencia'])
            ->when($user->hasRole('Integrador'), function ($query) use ($user) {
                // 🔹 Si el usuario es Integrador → solo mostrar sesiones con temas asignados a él
                $query->whereHas('temas.asignaciones', function ($sub) use ($user) {
                    $sub->where('user_id', $user->id);
                });
            })
            ->when(!$user->hasRole('Integrador') && $this->ponenciaUser, function ($query) use ($user) {
                // 🔹 Si NO es integrador pero tiene ponencia → mostrar sesiones por su ponencia
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
