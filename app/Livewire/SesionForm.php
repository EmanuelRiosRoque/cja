<?php

namespace App\Livewire;

use App\Models\Sede;
use App\Models\TipoSesion;
use App\Models\CaracterSesion;
use App\Models\Sesion;
use Illuminate\Validation\Rule;
use Livewire\Component;

class SesionForm extends Component
{
    // ===== CAMPOS =====
    public string $forma_captura = 'programada';
    public ?string $sede = null;
    public ?string $tipo_sesion = null;
    public ?string $caracter = null;
    public ?string $fecha_programada = null;
    public ?string $hora_programada = null;
    public ?string $hora_termino = null;

    public array $recesos = [];

    // ===== CATÁLOGOS =====
    public $sedes = [];
    public $tipo_sesiones = [];
    public $caracteres_sesiones = [];

    public function mount()
    {
        $this->sedes = Sede::all();
        $this->tipo_sesiones = TipoSesion::all();
        $this->caracteres_sesiones = CaracterSesion::all();
    }

    // ===== VALIDACIÓN =====
    protected function rules(): array
    {
        return [
            'forma_captura' => ['required', Rule::in(['programada', 'referida'])],
            'sede' => ['required'],
            'tipo_sesion' => ['required'],
            'caracter' => ['required'],
            'fecha_programada' => ['required', 'date'],
            'hora_programada' => ['required', 'date_format:H:i'],
            'hora_termino' => ['required', 'date_format:H:i', 'after:hora_programada'],
        ];
    }

    protected function messages(): array
    {
        return [
            'sede.required' => 'Selecciona la sede.',
            'tipo_sesion.required' => 'Selecciona el tipo de sesión.',
            'caracter.required' => 'Selecciona el carácter de la sesión.',
            'fecha_programada.required' => 'Indica la fecha programada.',
            'hora_programada.required' => 'Indica la hora programada.',
            'hora_termino.after' => 'La hora de término debe ser posterior a la programada.',
        ];
    }

    public function updated($property)
    {
        $this->validateOnly($property);
    }

    // ===== ACCIONES =====
    public function agregarReceso()
    {
        // 1️⃣ Agregamos nuevo receso vacío
        $this->recesos[] = ['inicio' => null, 'fin' => null];

        // 2️⃣ Validamos el formulario (solo para mostrar datos correctos)
        $data = $this->validate();

        // 3️⃣ Mostramos todo el estado actual del componente
        dd([
            'forma_captura' => $this->forma_captura,
            'sede' => $this->sede,
            'tipo_sesion' => $this->tipo_sesion,
            'caracter' => $this->caracter,
            'fecha_programada' => $this->fecha_programada,
            'hora_programada' => $this->hora_programada,
            'hora_termino' => $this->hora_termino,
            'recesos' => $this->recesos,
        ]);
    }

    public function continuar()
    {
        $data = $this->validate();

        dd($data); // 🔍 Verifica datos antes de guardar

        // $sesion = Sesion::create([
        //     'forma_captura' => $this->forma_captura,
        //     'sede_id' => $this->sede,
        //     'tipo_sesion_id' => $this->tipo_sesion,
        //     'caracter_sesion_id' => $this->caracter,
        //     'fecha_programada' => $this->fecha_programada,
        //     'hora_programada' => $this->hora_programada,
        //     'hora_termino' => $this->hora_termino,
        // ]);

        session()->flash('success', '✅ Sesión agregada correctamente.');
        return redirect()->route('sesiones.index');
    }

    public function cancelar()
    {
        return redirect()->route('dashboard');
    }

    public function render()
    {
        return view('livewire.sesion-form');
    }
}
