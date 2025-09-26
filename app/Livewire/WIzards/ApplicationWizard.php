<?php

namespace App\Livewire\Wizards;

use Livewire\Attributes\On;
use Livewire\Component;

class ApplicationWizard extends Component
{
    public int $step = 1;

    // Paso 1 (alineado con el hijo)
    public array $basic = [
        'modalidad'   => '',
        'materia'     => '',
        'canalizado'  => null,     // '0' | '1'
        'institucion' => null,
        'ticket'      => null,
        'attachments' => [],       // [{path,name,size,mime} o temp files, según tu dropzone]
    ];

    // Paso 2/3 si los sigues usando
    public array $person  = ['name' => '', 'surname' => ''];
    public array $company = ['name' => '', 'rfc' => ''];
    public string $message = '';

    // Adjuntos recibidos por evento (si los usas fuera del form modelable)
    public array $attachments = [];

    public function rulesForStep(int $step): array
    {
        return match ($step) {
            1 => [
                'basic.modalidad'   => ['required', 'in:linea,presencial'],
                'basic.materia'     => ['required', 'in:civil,mercantil,familiar'],
                'basic.canalizado'  => ['required', 'in:0,1'],
                // institución se añade condicionalmente en next()
                'basic.ticket'      => ['nullable', 'integer', 'min:1'],
                'basic.attachments' => ['array'],   // Ajusta si validas cada item
                // 'basic.attachments.*.path' => ['string'], etc.
            ],
            2 => $this->basic['materia'] !== 'familiar'
                ? [
                    'person.name'    => ['required','string','max:120'],
                    'person.surname' => ['required','string','max:120'],
                  ]
                : [
                    'company.name' => ['required','string','max:180'],
                    'company.rfc'  => ['required','string','max:13'],
                  ],
            3 => [
                'message' => ['required','string','min:5','max:1000'],
            ],
            default => [],
        };
    }

    public function next(): void
    {
        $rules = $this->rulesForStep($this->step);

        // Reglas condicionales del paso 1
        if ($this->step === 1 && (int)($this->basic['canalizado'] ?? 0) === 1) {
            $rules['basic.institucion'] = ['required','string','max:120'];
        } else if ($this->step === 1) {
            // Si cambia de Sí a No, limpia institución
            $this->basic['institucion'] = null;
        }

        $this->validate($rules);
        $this->step = min($this->step + 1, 4);
    }

    public function back(): void
    {
        $this->step = max($this->step - 1, 1);
    }

    public function updatedBasicCanalizado($value): void
    {
        // Normaliza a 0/1 por claridad
        $this->basic['canalizado'] = is_numeric($value) ? (string)(int)$value : ((bool)$value ? '1' : '0');
    }

    public function submit(): void
    {
        // Valida todo lo necesario (ajusta si tu wizard tiene más pasos o distintos)
        $this->validate($this->rulesForStep(1) + (
            ((int)($this->basic['canalizado'] ?? 0) === 1)
                ? ['basic.institucion' => ['required','string','max:120']]
                : []
        ));
        $this->validate($this->rulesForStep(2));
        $this->validate($this->rulesForStep(3));

        // Decide de dónde salen los archivos
        $attachments = $this->basic['attachments'] ?? $this->attachments;

        $payload = [
            'basic'       => $this->basic,
            'message'     => $this->message,
            // Si tu bifurcación depende ahora de materia, ajusta esta parte:
            'person'      => in_array($this->basic['materia'] ?? '', ['civil','mercantil'], true) ? $this->person  : null,
            'company'     => ($this->basic['materia'] ?? '') === 'familiar' ? $this->company : null,
            'attachments' => $attachments,
            'step'        => $this->step,
        ];

        dd($payload);
        // ...persistencia real después de quitar el dd()
    }

    #[On('attachments-updated')]
    public function onAttachments(array $list): void
    {
        $this->attachments = $list; // [{path,name,size,...}]
    }

    public function render()
    {
        return view('livewire.wizards.application-wizard');
    }
}
