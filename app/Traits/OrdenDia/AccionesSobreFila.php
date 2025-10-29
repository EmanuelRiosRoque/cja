<?php

namespace App\Traits\OrdenDia;

use App\Models\Tema;
use Illuminate\Support\Facades\DB;

trait AccionesSobreFila
{
   public function editar($id): void
    {
        $tema = Tema::with('presentadores')->findOrFail($id);

        $this->editando_id = $tema->id;
        $this->numero_tema = $tema->numero_tema; // congelado en edición
        $this->descripcion = $tema->descripcion;
        $this->prioridad = $tema->prioridad;

        $this->es_asunto_adicional = $tema->es_asunto_adicional ? '1' : '0';

        $ids = $tema->presentadores->pluck('id')->toArray();
        $this->presentadoresSeleccionados = !empty($ids) ? array_values($ids) : [''];
    }

    public function eliminar($id): void
    {
        $tema = Tema::findOrFail($id);
        $tema->delete();

        $this->cargarTemas();
        // Después de borrar, recalcula el siguiente número por el grupo actual
        $this->recalcNumeroTema();

        session()->flash('success', 'Tema eliminado.');
    }

    public function moverArriba(int $id): void
    {
        $tema = Tema::findOrFail($id);

        // vecino inmediatamente anterior dentro del mismo grupo
        $vecino = Tema::where('sesion_id', $tema->sesion_id)
            ->where('es_asunto_adicional', $tema->es_asunto_adicional)
            ->where('numero_tema', '<', $tema->numero_tema)
            ->orderBy('numero_tema', 'desc')
            ->first();

        if (!$vecino) return;

        DB::transaction(function () use ($tema, $vecino) {
            $a = $tema->numero_tema;
            $b = $vecino->numero_tema;

            $tema->update(['numero_tema' => $b]);
            $vecino->update(['numero_tema' => $a]);
        });

        $this->cargarTemas();
    }

    public function moverAbajo(int $id): void
    {
        $tema = Tema::findOrFail($id);

        // vecino inmediatamente siguiente dentro del mismo grupo
        $vecino = Tema::where('sesion_id', $tema->sesion_id)
            ->where('es_asunto_adicional', $tema->es_asunto_adicional)
            ->where('numero_tema', '>', $tema->numero_tema)
            ->orderBy('numero_tema', 'asc')
            ->first();

        if (!$vecino) return;

        DB::transaction(function () use ($tema, $vecino) {
            $a = $tema->numero_tema;
            $b = $vecino->numero_tema;

            $tema->update(['numero_tema' => $b]);
            $vecino->update(['numero_tema' => $a]);
        });

        $this->cargarTemas();
    }
}