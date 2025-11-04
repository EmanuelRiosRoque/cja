<?php

namespace App\Livewire\Sesion\Coordinador;

use Livewire\Component;
use App\Models\User;
use App\Models\Sesion;
use App\Models\TemaAsignado;

class Asignar extends Component
{
    public $sesion;
    public $temas = [];
    public $temasSeleccionados = [];
    public $usuarioId;
    public $selectAll = false;
    public $todosAsignados = false; // 🔹 NUEVA variable de control

    public function mount()
    {
        if (!$this->sesion) {
            abort(404, 'Sesión no encontrada');
        }

        $this->cargarTemas();
    }

    /**
     * 🔄 Refresca la lista de temas desde la sesión
     */
    public function cargarTemas()
    {
        $this->temas = $this->sesion->temas()
            ->with(['presentadores.ponencia', 'estatus'])
            ->orderBy('numero_tema')
            ->get();

        // 🔹 Verificamos si todos los temas ya están asignados
        $this->todosAsignados = $this->temas->every(fn ($tema) => $tema->estatus_id == 2);
    }

    public function updatedSelectAll($value)
    {
        // Solo selecciona los temas que no estén asignados
        $this->temasSeleccionados = $value
            ? $this->temas->where('estatus_id', '!=', 2)->pluck('id')->toArray()
            : [];
    }

    public function asignarTemas()
    {
        if (empty($this->temasSeleccionados)) {
            session()->flash('error', 'Debes seleccionar al menos un tema no asignado.');
            return;
        }

        if (!$this->usuarioId) {
            session()->flash('error', 'Selecciona un usuario para asignar los temas.');
            return;
        }

        $usuario = User::find($this->usuarioId);

        $temas = $this->sesion->temas()
            ->whereIn('id', $this->temasSeleccionados)
            ->where('estatus_id', '!=', 2)
            ->get(['id', 'numero_tema', 'descripcion', 'estatus_id']);

        if ($temas->isEmpty()) {
            session()->flash('error', 'Todos los temas seleccionados ya fueron asignados.');
            return;
        }

        foreach ($temas as $tema) {
            $yaAsignado = TemaAsignado::where('user_id', $usuario->id)
                ->where('tema_id', $tema->id)
                ->exists();

            if (!$yaAsignado) {
                TemaAsignado::create([
                    'user_id' => $usuario->id,
                    'tema_id' => $tema->id,
                ]);

                $tema->estatus_id = 2;
                $tema->save();
            }
        }

        // 🔄 Refrescar lista de temas
        $this->cargarTemas();

        // 🔹 Limpiar selección
        $this->temasSeleccionados = [];
        $this->selectAll = false;

        session()->flash('success', 'Temas asignados correctamente y estatus actualizado.');
    }

    public function render()
    {
        $ponenciaId = $this->temas
            ->pluck('presentadores')
            ->flatten()
            ->pluck('ponencia_id')
            ->filter()
            ->first();

        $usuarios = collect();

        if ($ponenciaId) {
            $usuarios = User::where('ponencia_id', $ponenciaId)
                ->role(['Coordinador', 'Integrador', 'Pleno'])
                ->orderBy('name')
                ->get();
        }

        return view('livewire.sesion.coordinador.asignar', [
            'usuarios' => $usuarios,
        ]);
    }
}
