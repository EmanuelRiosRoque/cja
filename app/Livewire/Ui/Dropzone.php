<?php

namespace App\Livewire\Ui;

use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\Attributes\Modelable;
use Illuminate\Support\Facades\Storage;

class Dropzone extends Component
{
    use WithFileUploads;

    #[Modelable]
    public ?array $files = []; // Eliminamos ?array → más rápido, evita errores de tipado

    public array $uploads = []; // Archivos temporales

    // Configuración
    public string $disk = 'public';
    public string $directory = 'attachments';
    public string $accept = '.pdf,.jpg,.jpeg,.png';
    public int $maxSizeKB = 10240;
    public bool $multiple = true;
    public string $label = 'Adjuntos';
    public ?string $help = '';

    protected function rules(): array
    {
        return [
            'uploads.*' => "file|mimes:pdf,jpg,jpeg,png|max:{$this->maxSizeKB}",
        ];
    }

    /**
     * Se ejecuta automáticamente al subir archivos.
     */
    public function updatedUploads(): void
    {
        $this->validateOnly('uploads');

        // Guardamos en bloque, minimizando I/O
        foreach ($this->uploads as $file) {
            // Se guarda directamente en el disco configurado
            $storedPath = $file->store($this->directory, $this->disk);

            // Añadimos metadatos mínimos
            $this->files[] = [
                'path' => "storage/{$storedPath}",
                'name' => $file->getClientOriginalName(),
                'size' => $file->getSize(),
                'mime' => $file->getMimeType(),
            ];
        }

        // Liberamos memoria temporal
        $this->reset('uploads');
    }

    /**
     * Elimina un archivo del array y del disco (si existe).
     */
    public function remove(int $index): void
    {
        $file = $this->files[$index] ?? null;
        if (!$file) return;

        // Convertir a ruta relativa del disco (quitar "storage/")
        $relative = str_starts_with($file['path'], 'storage/')
            ? substr($file['path'], 8)
            : $file['path'];

        // Eliminar si existe físicamente
        if (Storage::disk($this->disk)->exists($relative)) {
            Storage::disk($this->disk)->delete($relative);
        }

        // Quitar del array sin reindexar manualmente
        unset($this->files[$index]);
        $this->files = array_values($this->files); // normaliza índices
    }

    public function render()
    {
        return view('livewire.ui.dropzone');
    }
}
