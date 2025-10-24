<?php

namespace App\Livewire;

use Illuminate\Validation\Rule;
use Livewire\Attributes\Validate;
use Livewire\Component;

class SesionForm extends Component
{
    /* ===== Campos del formulario ===== */
    public string $forma_captura = 'programada'; // programada | referida

    public ?string $sede = null;           // ej. civil | penal
    public ?string $tipo_sesion = null;    // ej. ordinaria | extraordinaria
    public ?string $caracter = null;       // ej. publica | privada

    public ?string $fecha_programada = null; // YYYY-MM-DD
    public ?string $hora_programada = null;  // HH:MM
    public ?string $hora_termino = null;     // HH:MM

    /** Si quieres manejar recesos dinámicos, déjalo listo */
    public array $recesos = []; // cada item puede ser ['inicio' => 'HH:MM', 'fin' => 'HH:MM']

    /* ===== Reglas de validación ===== */
    protected function rules(): array
    {
        return [
            'forma_captura'    => ['required', Rule::in(['programada', 'referida'])],
            'sede'             => ['required', Rule::in(['civil', 'penal'])],
            'tipo_sesion'      => ['required', Rule::in(['ordinaria', 'extraordinaria'])],
            'caracter'         => ['required', Rule::in(['publica', 'privada'])],
            'fecha_programada' => ['required', 'date'],
            'hora_programada'  => ['required', 'date_format:H:i'],
            'hora_termino'     => ['required', 'date_format:H:i', 'after:hora_programada'],
            // si quieres validar recesos, añade aquí reglas para $recesos.*
        ];
    }

    protected function messages(): array
    {
        return [
            'sede.required'             => 'Selecciona la sede.',
            'tipo_sesion.required'      => 'Selecciona el tipo de sesión.',
            'caracter.required'         => 'Selecciona el carácter de la sesión.',
            'fecha_programada.required' => 'Indica la fecha programada.',
            'hora_programada.required'  => 'Indica la hora programada.',
            'hora_termino.required'     => 'Indica la hora estimada de término.',
            'hora_termino.after'        => 'La hora de término debe ser posterior a la hora programada.',
        ];
    }

    /** Validación campo a campo en tiempo real */
    public function updated($property): void
    {
        $this->validateOnly($property);
    }

    /* ===== Acciones ===== */

    /** Agrega un receso por defecto (puedes abrir modal si prefieres) */
    public function agregarReceso(): void
    {
        $this->recesos[] = [
            'inicio' => null,
            'fin'    => null,
        ];
        // Ejemplo: $this->dispatch('toast', type:'info', message:'Receso agregado');
    }

    /** Guarda / continúa el flujo */
    public function continuar()
    {
        $data = $this->validate();

        // TODO: ajusta al modelo real que uses (ej. Sesion)
        // use App\Models\Sesion;
        // $sesion = Sesion::create([
        //     'forma_captura'    => $data['forma_captura'],
        //     'sede'             => $data['sede'],
        //     'tipo_sesion'      => $data['tipo_sesion'],
        //     'caracter'         => $data['caracter'],
        //     'fecha_programada' => $data['fecha_programada'],
        //     'hora_programada'  => $data['hora_programada'],
        //     'hora_termino'     => $data['hora_termino'],
        // ]);

        // Si guardas recesos:
        // foreach ($this->recesos as $r) {
        //     if (!empty($r['inicio']) && !empty($r['fin'])) {
        //         $sesion->recesos()->create($r);
        //     }
        // }

        // Mensaje/redirect
        session()->flash('success', 'Sesión guardada correctamente.');
        // return redirect()->route('sesiones.show', $sesion); // Ajusta a tu ruta
    }

    /** Cancela y redirige (ajusta la ruta) */
    public function cancelar()
    {
        return redirect()->route('sesiones.index');
    }

    public function render()
    {
        return view('livewire.sesion-form');
    }
}
