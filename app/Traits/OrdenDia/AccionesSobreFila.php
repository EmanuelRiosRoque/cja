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
        $this->numero_tema = $tema->numeroTema; // correcto
        $this->descripcion = $tema->descripcion;
        $this->prioridad = $tema->prioridad;

        $this->es_asunto_adicional = $tema->esAdicional ? '1' : '0';

        $ids = $tema->presentadores->pluck('id')->toArray();
        $this->presentadoresSeleccionados = !empty($ids) ? array_values($ids) : [''];
    }

    public function eliminar($id): void
    {
        $tema = Tema::findOrFail($id);

        // 1. Eliminar relaciones del pivot presentador_tema
        $tema->presentadores()->detach();

        // 2. Eliminar documentos relacionados
        if (method_exists($tema, 'documentos')) {
            $tema->documentos()->delete();
        }

        // 3. Eliminar el tema
        $tema->delete();

        // 4. Refrescar
        $this->cargarTemas();
        $this->recalcNumeroTema();

        session()->flash('success', 'Tema eliminado.');
    }

    public function moverArriba(int $id): void
    {
        $tema = Tema::findOrFail($id);

        $vecino = Tema::where('fk_sesion', $tema->fk_sesion)
            ->where('esAdicional', $tema->esAdicional)
            ->where('numeroTema', '<', $tema->numeroTema)
            ->orderBy('numeroTema', 'desc')
            ->first();

        if (!$vecino) return;

        DB::transaction(function () use ($tema, $vecino) {
            $a = $tema->numeroTema;
            $b = $vecino->numeroTema;

            $tema->update(['numeroTema' => $b]);
            $vecino->update(['numeroTema' => $a]);
        });

        $this->cargarTemas();
    }

    public function moverAbajo(int $id): void
    {
        $tema = Tema::findOrFail($id);

        $vecino = Tema::where('fk_sesion', $tema->fk_sesion)
            ->where('esAdicional', $tema->esAdicional)
            ->where('numeroTema', '>', $tema->numeroTema)
            ->orderBy('numeroTema', 'asc')
            ->first();

        if (!$vecino) return;

        DB::transaction(function () use ($tema, $vecino) {
            $a = $tema->numeroTema;
            $b = $vecino->numeroTema;

            $tema->update(['numeroTema' => $b]);
            $vecino->update(['numeroTema' => $a]);
        });

        $this->cargarTemas();
    }
}
