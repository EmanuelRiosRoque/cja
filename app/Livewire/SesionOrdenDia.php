<?php

namespace App\Livewire;

use App\Models\Sesion;
use App\Models\Tema;
use App\Models\Presentador;
use App\Services\DocumentoService;
use App\Traits\OrdenDia\AccionesSobreFila;
use App\Traits\OrdenDia\HelperUi;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Livewire\Component;

class SesionOrdenDia extends Component
{
    use HelperUi;  // Nuevo Presentador / Calcular Tema / Limpiar campos
    use AccionesSobreFila; // Eliminar / Editar / Mover: Arriba o Abajo

    /** @var \App\Models\Sesion|int|string */
    public $sesion;

    /** @var \Illuminate\Support\Collection|\App\Models\Presentador[] */
    public $presentadores;

    public $sesion_id;
    public $temas = [];
    public $temasAdicionales = [];

    // Campos del formulario
    public $numero_tema;
    public $descripcion = '';
    public $prioridad = 0;
    public $documentos;

    /**
     * '': no seleccionado
     * '0': orden del día (tema normal)
     * '1': asuntos adicionales
     */
    public $es_asunto_adicional = '';

    // Presentadores dinámicos
    public $presentadoresSeleccionados = [''];

    // Modo edición
    public $editando_id = null;


    public function mount()
    {
        // Acepta sesion como objeto o id
        if (!$this->sesion instanceof Sesion) {
            $this->sesion = Sesion::with('temas.presentadores')->findOrFail(
                is_array($this->sesion) ? ($this->sesion['id'] ?? null) : $this->sesion
            );
        }

        if (empty($this->presentadores)) {
            $this->presentadores = Presentador::orderBy('id')->get();
        }

        $this->sesion_id = $this->sesion->id;

        $this->cargarTemas();
        $this->recalcNumeroTema();
    }

    public function cargarTemas(): void
    {
        $this->temas = Tema::where('sesion_id', $this->sesion_id)
            ->where('es_asunto_adicional', false)
            ->with('presentadores')
            ->orderBy('numero_tema')
            ->get();

        $this->temasAdicionales = Tema::where('sesion_id', $this->sesion_id)
            ->where('es_asunto_adicional', true)
            ->with('presentadores')
            ->orderBy('numero_tema')
            ->get();
    }

    public function guardarTema(): void
    {
        $this->validate([
            'descripcion' => 'required|string|max:1000',
            'presentadoresSeleccionados.*' => 'required|exists:presentadores,id',
            'es_asunto_adicional' => 'nullable|in:0,1',
        ], [
            'descripcion.required' => 'Escribe la descripción del tema.',
            'presentadoresSeleccionados.*.required' => 'Selecciona al menos un presentador.',
        ]);

        // Cast seguro para base de datos (boolean)
        $esAdicBool = ($this->es_asunto_adicional === '1' || $this->es_asunto_adicional === 1);

        if ($this->editando_id) {
            // Actualizar
            $tema = Tema::findOrFail($this->editando_id);

            $tema->update([
                'descripcion' => $this->descripcion,
                'prioridad' => $this->prioridad,
                'es_asunto_adicional' => $esAdicBool,
            ]);

            $tema->presentadores()->sync(array_filter($this->presentadoresSeleccionados));
        } else {
            // Asegurar número correcto al momento de crear
            $this->recalcNumeroTema();

            $tema = Tema::create([
                'sesion_id' => $this->sesion_id,
                'numero_tema' => $this->numero_tema,
                'descripcion' => $this->descripcion,
                'prioridad' => $this->prioridad,
                'es_asunto_adicional' => $esAdicBool,
            ]);

            $tema->presentadores()->attach(array_filter($this->presentadoresSeleccionados));
        }

        if (!empty($this->documentos)) {
            $documentoService = new DocumentoService();
            $documentoService->enviarYRegistrar($tema, $this->documentos);
        }

        // Refrescar listas y limpiar formulario (manteniendo si es adicional o no)
        $this->cargarTemas();
        $this->limpiarCampos(mantenerTipo: true);

        session()->flash('success', 'Tema guardado correctamente.');
    }

    public function cancelar(): void
    {
        $this->limpiarCampos();
    }

    public function terminarCaptura()
    {
        return $this->redirect(route('sesion.index'));
    }
    public function render()
    {
        return view('livewire.sesion-orden-dia');
    }
}
