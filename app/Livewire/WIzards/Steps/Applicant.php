<?php

namespace App\Livewire\Wizards\Steps;

use Illuminate\Support\Facades\Storage;
use Livewire\Attributes\Modelable;
use Livewire\Component;
use Livewire\WithFileUploads;

class Applicant extends Component
{
    use WithFileUploads;

    #[Modelable]
    public array $form = [
        'name'        => '',
        'surname'     => '',
        'phones'      => [ ['type' => 'mobile', 'number' => '', 'primary' => true] ],
        'emails'      => [ ['email' => ''] ],
        'attachments' => [],

        // Escolaridad
        'education'        => '',
        'education_other'  => '',

        // NUEVO: radios para ramificar
        'variant' => '', // '1' | '2'

        // Campos para la opción 1 (Persona Física)
        'pf' => [
            'curp' => '',
            'dob'  => null, // YYYY-MM-DD
        ],

        // Campos para la opción 2 (Persona Moral)
        'pm' => [
            'razon_social' => '',
            'rfc'          => '',
        ],

        'representante' => '',           // '1' = Sí, '2' = No
        'rep' => [
            'name' => '', 
            'surname' => '',
             'docs'    => [ // booleans
            'doc1' => false,
            'doc2' => false,
            'doc3' => false,
        ],
        'files' => [
            'doc1' => [],   // cada dropzone modela aquí
            'doc2' => [],
            'doc3' => [],
        ],
        ],
    ];


    /** === Inputs simples para “agregar” === */
    public string $newPhoneNumber = '';
    public string $newPhoneType   = 'mobile';
    public string $newEmail       = '';

    /** === Tipos de teléfono (para el <select>) === */
    public array $phoneTypes = [
        'mobile' => 'Celular',
        'home'   => 'Casa',
        'work'   => 'Trabajo',
        'other'  => 'Otro',
    ];

    /** === Dropzone (archivos temporales solo para captura) === */
    public array $newFiles = []; // TemporaryUploadedFile[]

    /** ===================== Teléfonos ===================== */

public function updatedFormVariant($value): void
{
    if ($value === '1') {
        // Limpia los campos de Persona Moral
        $this->form['pm'] = ['razon_social' => '', 'rfc' => ''];
    } elseif ($value === '2') {
        // Limpia los campos de Persona Física
        $this->form['pf'] = ['curp' => '', 'dob' => null];
    }
}
public function updatedFormRepresentante($value): void
{
    if ($value !== '1') {
        $this->form['rep'] = ['name' => '', 'surname' => ''];
    }
}

    private function normalizePhone(string $raw): string
    {
        // Solo dígitos, recorta largo exagerado
        $digits = preg_replace('/\D+/', '', $raw) ?? '';
        return mb_substr($digits, 0, 20);
    }

    private function phoneExists(string $digits): bool
    {
        foreach (($this->form['phones'] ?? []) as $p) {
            if (($p['number'] ?? '') === $digits) {
                return true;
            }
        }
        return false;
    }

    public function addPhoneFromInput(): void
    {
        $this->validate([
            'newPhoneNumber' => ['required', 'string', 'min:8', 'max:30'],
            'newPhoneType'   => ['required', 'in:mobile,home,work,other'],
        ]);

        $digits = $this->normalizePhone($this->newPhoneNumber);
        if ($digits === '') return;

        if (!isset($this->form['phones']) || !is_array($this->form['phones'])) {
            $this->form['phones'] = [];
        }

        // evita duplicado exacto
        if ($this->phoneExists($digits)) {
            $this->newPhoneNumber = '';
            return;
        }

        $this->form['phones'][] = [
            'type'    => $this->newPhoneType,
            'number'  => $digits,
            'primary' => empty($this->form['phones']), // el primero es principal
        ];

        $this->newPhoneNumber = '';
    }

    public function removePhone(int $i): void
    {
        if (!isset($this->form['phones'][$i])) return;

        $wasPrimary = (bool)($this->form['phones'][$i]['primary'] ?? false);

        unset($this->form['phones'][$i]);
        $this->form['phones'] = array_values($this->form['phones']);

        // re-asigna principal si quitaste el que era
        if ($wasPrimary && !empty($this->form['phones'])) {
            $this->form['phones'][0]['primary'] = true;
            for ($k = 1; $k < count($this->form['phones']); $k++) {
                $this->form['phones'][$k]['primary'] = false;
            }
        }

        // si quedó vacío, deja un placeholder
        if (empty($this->form['phones'])) {
            $this->form['phones'][] = ['type' => 'mobile', 'number' => '', 'primary' => true];
        }
    }

    public function setPrimaryPhone(int $i): void
    {
        if (empty($this->form['phones'][$i])) return;
        foreach ($this->form['phones'] as $k => &$p) {
            $p['primary'] = ($k === $i);
        }
        unset($p);
    }

    // Limpia el campo "otro" cuando cambian a una opción distinta
public function updatedFormEducation($value): void
{
    if ($value !== 'other') {
        $this->form['education_other'] = '';
    }
}


    /** ===================== Emails ===================== */

    private function emailExists(string $email): bool
    {
        $needle = mb_strtolower(trim($email));
        foreach (($this->form['emails'] ?? []) as $e) {
            if (mb_strtolower($e['email'] ?? '') === $needle) {
                return true;
            }
        }
        return false;
    }

    public function addEmailFromInput(): void
    {
        $this->validate([
            'newEmail' => ['required', 'email', 'max:120'],
        ]);

        if (!isset($this->form['emails']) || !is_array($this->form['emails'])) {
            $this->form['emails'] = [];
        }

        if ($this->emailExists($this->newEmail)) {
            $this->newEmail = '';
            return;
        }

        $this->form['emails'][] = ['email' => trim($this->newEmail)];
        $this->newEmail = '';
    }

    public function removeEmail(int $i): void
    {
        if (!isset($this->form['emails'][$i])) return;

        unset($this->form['emails'][$i]);
        $this->form['emails'] = array_values($this->form['emails']);

        if (empty($this->form['emails'])) {
            $this->form['emails'][] = ['email' => ''];
        }
    }

    /** ===================== Dropzone / Adjuntos ===================== */

    /** Se dispara al seleccionar/soltar archivos → guarda y agrega a attachments */
    public function updatedNewFiles(): void
    {
        $this->validate([
            'newFiles.*' => 'mimes:pdf,jpg,jpeg,png|max:10240', // 10MB
        ]);

        foreach ($this->newFiles as $file) {
            $path = $file->store('attachments', 'public');
            $this->form['attachments'][] = [
                'path' => 'storage/' . $path, // usable con asset()
                'name' => $file->getClientOriginalName(),
                'size' => $file->getSize(),
                'mime' => $file->getMimeType(),
            ];
        }

        // limpia temporales (ya guardados)
        $this->newFiles = [];
    }

    public function removeAttachment(int $i): void
    {
        if (!isset($this->form['attachments'][$i])) return;

        $att = $this->form['attachments'][$i];

        // Borrar archivo del disco (opcional; quítalo si no quieres)
        if (!empty($att['path'])) {
            $relative = str_starts_with($att['path'], 'storage/')
                ? substr($att['path'], strlen('storage/'))
                : $att['path'];

            if (Storage::disk('public')->exists($relative)) {
                Storage::disk('public')->delete($relative);
            }
        }

        unset($this->form['attachments'][$i]);
        $this->form['attachments'] = array_values($this->form['attachments']);
    }


    
    public function render()
    {
        return view('livewire.wizards.steps.applicant');
    }
}
