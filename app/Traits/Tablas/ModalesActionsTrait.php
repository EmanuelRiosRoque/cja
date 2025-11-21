<?php

namespace App\Traits\Tablas;

use App\Models\Oficialia\Solicitud;
trait ModalesActionsTrait
{
    /* ============================================================
       CANCELAR SOLICITUD
    ============================================================ */
    public function abrirModalCancelar($id)
    {
        $this->solicitudIdCancelar = $id;
        $this->modalCancelar = true;
    }

    public function confirmarCancelar()
    {
        $solicitud = Solicitud::find($this->solicitudIdCancelar);

        if ($solicitud) {
            $solicitud->fk_estatus = 4; // Cancelado
            $solicitud->save();
        }

        session()->flash('message', 'La solicitud fue cancelada correctamente.');

        $this->modalCancelar = false;
        $this->solicitudIdCancelar = null;

        // Recargar solicitudes
        $this->solicitudes = Solicitud::where('fk_estatus', '!=', 4)->get();
    }

    /* ============================================================
       EDITAR REGISTRO (NO TURNOS)
       ============================================================ */
    public function abrirModalEditarRegistro()
    {
        $this->reset([
            'tipo_procedencia',
            'area_procedencia',
            'entrega',
            'no_oficio',
            'promovente',
            'tipo',
            'turno',
            'anexos',
            'descripcion',
            'descripcion_anexos'
        ]);

        $this->modalEditarRegistro = true;
    }

    public function confirmarEditarRegistro()
    {
        session()->flash('message', 'El registro fue editado correctamente.');
        $this->modalEditarRegistro = false;
    }

    /* ============================================================
       EDITAR TURNO (ACTUALIZAR fk_areaTurno)
       ============================================================ */
    public function abrirModalEditarTurno($id)
    {
        $this->solicitudIdEditarTurno = $id;
        $this->reset('turnoSeleccionado');

        $this->modalEditarTurno = true;
    }

    public function confirmarEditarTurno()
    {
        $solicitud = Solicitud::find($this->solicitudIdEditarTurno);

        if ($solicitud) {
            // Actualizar el campo real
            $solicitud->fk_areaTurno = $this->turnoSeleccionado;
            $solicitud->save();
        }

        session()->flash('message', 'El turno fue actualizado correctamente.');

        $this->modalEditarTurno = false;
        $this->solicitudIdEditarTurno = null;

        // Recargar lista
        $this->solicitudes = Solicitud::where('fk_estatus', '!=', 4)->get();
    }


    public function abrirModalDocumentos($id)
    {
        $solicitud = Solicitud::find($id);

        // Documento de prueba — luego lo cambias por uno real
        $this->documentoActual = [
            'nombre' => 'Documento_prueba.pdf',
            'extension' => 'pdf',
            'url' => asset('storage/documentos/Documento_prueba.pdf'),
        ];

        // Mostramos modal
        $this->modalDocumentos = true;
    }
}
