<?php

namespace App\Livewire\Sesion;

use Livewire\Component;
use Livewire\WithFileUploads;
use App\Services\DocumentoService;
use Illuminate\Support\Facades\Log;

class Adjuntar extends Component
{
    use WithFileUploads;

    public $sesion;
    public $temas;
    public $mostrarModalDocumentos = false;
    public $temaSeleccionado = null;
    public $archivo = []; // arreglo por tema para múltiples inputs

    protected $rules = [
        'archivo.*' => 'nullable|file|max:20480|mimes:pdf,jpg,jpeg,png,doc,docx',
    ];

    public function mount($sesion)
    {
        $this->sesion = $sesion;

        $this->temas = $sesion->temas()
            ->with(['presentadores', 'documentos'])
            ->orderBy('numero_tema')
            ->get();
    }

    public function abrirModal($temaId)
    {
        $this->temaSeleccionado = $temaId;
        $this->mostrarModalDocumentos = true;
    }

  public function adjuntar($temaId)
{
    $this->validate();

    if (empty($this->archivo[$temaId])) {
        session()->flash('error', 'Selecciona un archivo antes de adjuntar.');
        return;
    }

    $tema = $this->temas->firstWhere('id', $temaId);
    if (!$tema) {
        session()->flash('error', 'Tema no encontrado.');
        return;
    }

    try {
        $file = $this->archivo[$temaId];
        $path = $file->store('documentos/temas', 'public');

        $documentoService = new DocumentoService();

        $resultado = $documentoService->enviarYRegistrar($tema, [
            'path' => 'storage/' . $path,
            'name' => $file->getClientOriginalName(),
        ]);

        session()->flash('success', 'Documento adjuntado correctamente.');

        // recarga temas actualizados
        $this->temas = $this->sesion->temas()
            ->with(['presentadores', 'documentos'])
            ->orderBy('numero_tema')
            ->get();

        // limpia estado Livewire
        unset($this->archivo[$temaId]);

        // dispara evento JS para limpiar input visual
        $this->dispatch('limpiar-input', id: $temaId);

        Log::info('Documento enviado con éxito', $resultado);
    } catch (\Throwable $e) {
        Log::error('Error al adjuntar documento: ' . $e->getMessage());
        session()->flash('error', 'Ocurrió un error al subir el documento.');
    }
}


    public function render()
    {
        return view('livewire.sesion.adjuntar', [
            'temas' => $this->temas,
        ]);
    }
}
