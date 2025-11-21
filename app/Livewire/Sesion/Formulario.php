<?php

namespace App\Livewire\Sesion;

use App\Models\Sede;
use App\Models\TipoSesion;
use App\Models\CaracterSesion;
use App\Models\Catalogos\CatCaracterSesion;
use App\Models\Catalogos\CatSede;
use App\Models\Catalogos\CatTipoSesion;
use App\Models\Sesion;
use Illuminate\Validation\Rule;
use Livewire\Component;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class Formulario extends Component
{
    // ===== CAMPOS =====
    public $forma_captura = 1;
    public ?string $sede = null;
    public ?string $tipo_sesion = null;
    public ?string $caracter = null;
    public ?string $fecha_programada = null;
    public ?string $hora_programada = null;
    public ?string $hora_termino = null;
    public bool $bloqueado = false;

    /** Recesos confirmados */
    public array $recesos = []; // cada item: ['inicio' => 'HH:MM', 'fin' => 'HH:MM']

    /** Estado del formulario "Agregar receso" */
    public bool $agregandoReceso = false;
    public ?string $receso_inicio = null;
    public ?string $receso_fin    = null;

    // ===== CATÁLOGOS =====
    public $sedes = [];
    public $tipo_sesiones = [];
    public $caracteres_sesiones = [];

    public function mount()
    {
        $this->sedes = CatSede::all();
        $this->tipo_sesiones = CatTipoSesion::all();
        $this->caracteres_sesiones = CatCaracterSesion::all();
    }

    // ===== VALIDACIÓN =====
    protected function rules(): array
    {
        return [
            'forma_captura'    => ['required'],
            'sede'             => ['required'],
            'tipo_sesion'      => ['required'],
            'caracter'         => ['required'],
            'fecha_programada' => ['required', 'date_format:Y-m-d'],
            'hora_programada'  => ['required', 'date_format:H:i'],
            'hora_termino'     => ['required', 'date_format:H:i', 'after:hora_programada'],
            'recesos'          => ['nullable', 'array'],
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
            'hora_termino.after'        => 'La hora de término debe ser posterior a la programada.',
        ];
    }

    public function updated($property)
    {
        $this->validateOnly($property);
    }

    // ===== RECESOS =====
    public function agregarReceso()
    {
        $this->agregandoReceso = true;
        $this->receso_inicio = null;
        $this->receso_fin = null;
    }

    public function cancelarReceso()
    {
        $this->agregandoReceso = false;
        $this->receso_inicio = null;
        $this->receso_fin = null;
    }

    public function confirmarReceso()
    {
        $this->validateRecesoBasico();

        $ini = $this->receso_inicio;
        $fin = $this->receso_fin;

        // Orden
        if (!$this->esTiempoMenor($ini, $fin)) {
            $this->addError('receso_fin', 'La hora de fin debe ser mayor a la de inicio.');
            return;
        }

        // Dentro del rango de la sesión
        if ($this->hora_programada && $this->hora_termino) {
            if (
                !$this->esTiempoEntre($ini, $this->hora_programada, $this->hora_termino) ||
                !$this->esTiempoEntre($fin, $this->hora_programada, $this->hora_termino)
            ) {
                $this->addError('receso_inicio', 'El receso debe estar dentro del horario de la sesión.');
                return;
            }
        }

        // Sin traslapes
        foreach ($this->recesos as $r) {
            if ($this->rangoTraslapa($ini, $fin, $r['inicio'], $r['fin'])) {
                $this->addError('receso_inicio', 'Este receso se traslapa con uno existente.');
                return;
            }
        }

        $this->recesos[] = ['inicio' => $ini, 'fin' => $fin];
        $this->cancelarReceso();
    }

    public function eliminarReceso($index)
    {
        unset($this->recesos[$index]);
        $this->recesos = array_values($this->recesos);
    }

    private function validateRecesoBasico(): void
    {
        $this->resetErrorBag(['receso_inicio','receso_fin']);

        if (!$this->receso_inicio) {
            $this->addError('receso_inicio', 'Completa la hora de inicio.');
        }
        if (!$this->receso_fin) {
            $this->addError('receso_fin', 'Completa la hora de fin.');
        }

        $fmt = '/^\d{2}:\d{2}$/';
        if ($this->receso_inicio && !preg_match($fmt, $this->receso_inicio)) {
            $this->addError('receso_inicio', 'Formato inválido (HH:MM).');
        }
        if ($this->receso_fin && !preg_match($fmt, $this->receso_fin)) {
            $this->addError('receso_fin', 'Formato inválido (HH:MM).');
        }

        if ($this->getErrorBag()->isNotEmpty()) {
            throw \Illuminate\Validation\ValidationException::withMessages($this->getErrorBag()->toArray());
        }
    }

    private function esTiempoMenor(string $a, string $b): bool
    {
        return Carbon::createFromFormat('H:i', $a) < Carbon::createFromFormat('H:i', $b);
    }

    private function esTiempoEntre(string $t, string $inicio, string $fin): bool
    {
        $T = Carbon::createFromFormat('H:i', $t);
        return $T->betweenIncluded(
            Carbon::createFromFormat('H:i', $inicio),
            Carbon::createFromFormat('H:i', $fin)
        );
    }

    private function rangoTraslapa(string $a1, string $a2, string $b1, string $b2): bool
    {
        $A1 = Carbon::createFromFormat('H:i', $a1);
        $A2 = Carbon::createFromFormat('H:i', $a2);
        $B1 = Carbon::createFromFormat('H:i', $b1);
        $B2 = Carbon::createFromFormat('H:i', $b2);

        return $A1 < $B2 && $A2 > $B1;
    }

    // ===== ACCIONES =====
    public function continuar()
    {
        $this->validate();

        $this->bloqueado = true;
    }

    public function corregir()
    {
        $this->bloqueado = false;
    }

    public function cancelar()
    {
        return redirect()->route('dashboard');
    }

    public function guardar()
    {
        // try {
        //     DB::beginTransaction();

            $this->validate();

            $sesion = Sesion::create([
                'forma_captura'      => $this->forma_captura,
                'fecha_programada'   => $this->fecha_programada,
                'hora_programada'    => $this->hora_programada,
                'hora_termino'       => $this->hora_termino,
                'fechaAlta'          => now(), 
                'fechaModificacion'  => null,
                'fk_sede'            => $this->sede,
                'fk_tipo_sesion'     => $this->tipo_sesion,
                'fk_estatus'         => 1, // Pendiente
                'fk_caracter'        => $this->caracter,
            ]);

            foreach ($this->recesos as $receso) {
                $sesion->recesos()->create([
                    'hora_inicio'       => $receso['inicio'],
                    'hora_fin'          => $receso['fin'],
                    'fechaAlta'         => now(),
                    'fechaModificacion' => null
                ]);
            }

            // DB::commit();

            session()->flash('success', 'Sesión guardada correctamente.');
        // } catch (\Throwable $e) {
        //     DB::rollBack();

        //     session()->flash('error', 'Sesión guardada correctamente.');

        //     Log::error('Error al guardar sesión', [
        //         'error' => $e->getMessage(),
        //         'trace' => $e->getTraceAsString(),
        //     ]);
        // }
    }


    public function render()
    {
        return view('livewire.sesion.formulario');
    }
}
