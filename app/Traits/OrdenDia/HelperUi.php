<?php

namespace App\Traits\OrdenDia;

use App\Models\Tema;


trait HelperUi
{
      public function agregarPresentador(): void
    {
        $this->presentadoresSeleccionados[] = '';
    }

    public function eliminarPresentador($index): void
    {
        if (count($this->presentadoresSeleccionados) > 1) {
            unset($this->presentadoresSeleccionados[$index]);
            $this->presentadoresSeleccionados = array_values($this->presentadoresSeleccionados);
        }
    }

    private function recalcNumeroTema(): void
    {
        // Cast seguro del select
        $esAdic = ($this->es_asunto_adicional === '1' || $this->es_asunto_adicional === 1 || $this->es_asunto_adicional === true);

        $max = Tema::where('sesion_id', $this->sesion_id)
            ->where('es_asunto_adicional', $esAdic)
            ->max('numero_tema');

        $this->numero_tema = (int) $max + 1;
    }

    public function updatedEsAsuntoAdicional(): void
    {
        $this->recalcNumeroTema();
    }

    public function limpiarCampos(bool $mantenerTipo = true): void
    {
        $this->presentadoresSeleccionados = [''];
        $this->descripcion = '';
        $this->prioridad = 0;
        $this->editando_id = null;
        $this->documentos = [];
        $this->dispatch('reset-dropzone-forma');

        if (!$mantenerTipo) {
            $this->es_asunto_adicional = '';
        }

        $this->recalcNumeroTema();
    }
}
