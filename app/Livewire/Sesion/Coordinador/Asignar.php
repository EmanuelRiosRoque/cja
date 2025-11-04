<?php

namespace App\Livewire\Sesion\Coordinador;

use Livewire\Component;
use App\Models\User;
use App\Models\Sesion;

class Asignar extends Component
{
    public $sesion;
    public $temas = [];
    public $temasSeleccionados = [];
    public $usuarioId;
    public $selectAll = false;

    public function mount()
    {
        if (!$this->sesion) {
            abort(404, 'Sesión no encontrada');
        }

        $this->temas = $this->sesion->temas()
            ->with(['presentadores.ponencia'])
            ->orderBy('numero_tema')
            ->get();
    }

    public function updatedSelectAll($value)
    {
        $this->temasSeleccionados = $value
            ? $this->temas->pluck('id')->toArray()
            : [];
    }

   public function asignarTemas()
{
    if (empty($this->temasSeleccionados)) {
        session()->flash('error', 'Debes seleccionar al menos un tema.');
        return;
    }

    if (!$this->usuarioId) {
        session()->flash('error', 'Selecciona un usuario para asignar los temas.');
        return;
    }

    // 🔹 Obtenemos los temas seleccionados y el usuario elegido
    $temas = $this->sesion->temas()
        ->whereIn('id', $this->temasSeleccionados)
        ->get(['id', 'numero_tema', 'descripcion']);

    $usuario = \App\Models\User::find($this->usuarioId, ['id', 'name', 'email']);

    // 🔹 Mostramos la información en pantalla
    dd([
        'usuario_asignado' => $usuario,
        'temas_seleccionados' => $temas,
    ]);
}


    public function render()
    {
        // 🔹 Buscar una ponencia válida desde los presentadores de los temas
        $ponenciaId = $this->temas
            ->pluck('presentadores')
            ->flatten()
            ->pluck('ponencia_id')
            ->filter()
            ->first();
        

        // 🔹 Si hay una ponencia, filtramos usuarios con ese ponencia_id y rol
        $usuarios = collect();

        if ($ponenciaId) {
            $usuarios = User::where('ponencia_id', $ponenciaId)
                ->role(['Coordinador', 'Integrador'])
                ->orderBy('name')
                ->get();
        }

        return view('livewire.sesion.coordinador.asignar', [
            'usuarios' => $usuarios,
        ]);
    }
}
