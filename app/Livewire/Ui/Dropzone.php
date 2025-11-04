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
    public ?array $files = [];

    public array $uploads = [];

    // Configuración
    public string $disk = 'externo'; // ← tu disco externo
    public string $directory = '';   // ← vacío para guardar directo en raíz
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

    public function updatedUploads(): void
    {
        $this->validateOnly('uploads');

        foreach ($this->uploads as $file) {
            // Crear nombre único base
            $uniqueId = uniqid();
            $originalName = $file->getClientOriginalName();
            $extension = $file->getClientOriginalExtension();

            // Guardar archivo directamente en la raíz del disco externo
            $storedPath = $file->storeAs(
                '', // sin carpeta
                "{$uniqueId}_{$originalName}",
                $this->disk
            );

            // Si es PDF, generar su XML automáticamente
            if (strtolower($extension) === 'pdf') {
                $tipo = strtoupper($extension);
                $fecha = now()->format('Y-m-d H:i:s');

                $xml = '<?xml version="1.0" encoding="utf-8"?>' . PHP_EOL .
                    '<doc>' . PHP_EOL .
                    '   <metadata name="TipoArchivo">' . $tipo . '</metadata>' . PHP_EOL .
                    '   <metadata name="n_documento">' . "{$uniqueId}_{$originalName}" . '</metadata>' . PHP_EOL .
                    '   <metadata name="fecha_documento">' . $fecha . '</metadata>' . PHP_EOL .
                    '</doc>';

                // Guardar XML junto al PDF
                $xmlName = pathinfo($originalName, PATHINFO_FILENAME);
                $xmlName = "{$uniqueId}_{$xmlName}.xml";

                Storage::disk($this->disk)->put($xmlName, $xml);
            }

            // Registrar en array de archivos
            $this->files[] = [
                'path' => Storage::disk($this->disk)->path($storedPath),
                'name' => $file->getClientOriginalName(),
                'size' => $file->getSize(),
                'mime' => $file->getMimeType(),
            ];
        }

        // Limpiar cargas temporales
        $this->reset('uploads');
    }

    public function remove(int $index): void
    {
        $file = $this->files[$index] ?? null;
        if (!$file) return;

        $relative = basename($file['path']); // nombre del archivo

        // Eliminar archivo físico si existe
        if (Storage::disk($this->disk)->exists($relative)) {
            Storage::disk($this->disk)->delete($relative);
        }

        unset($this->files[$index]);
        $this->files = array_values($this->files);
    }

    public function render()
    {
        return view('livewire.ui.dropzone');
    }
}
