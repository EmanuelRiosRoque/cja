<div>
  <fieldset @disabled($bloqueado) class="{{ $bloqueado ? 'opacity-70 pointer-events-none select-none' : '' }}">

    {{-- ===== CAMPOS PRINCIPALES ===== --}}
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
      {{-- Sede --}}
      <div>
        <x-label for="sede" value="Sede" />
        <select
          id="sede"
          wire:model="sede"
          class="mt-1 w-full border-gray-300 rounded-lg shadow-sm 
                 focus:ring-emerald-500 focus:border-emerald-500"
        >
          <option value="">-- Selecciona una opción --</option>
          @foreach ($sedes as $s)
            <option value="{{ $s->id }}">{{ $s->nombre }}</option>
          @endforeach
        </select>
        @error('sede') <span class="text-sm text-red-600">{{ $message }}</span> @enderror
      </div>

      {{-- Tipo de sesión --}}
      <div>
        <x-label for="tipo_sesion" value="Tipo de sesión" />
        <select
          id="tipo_sesion"
          wire:model="tipo_sesion"
          class="mt-1 w-full border-gray-300 rounded-lg shadow-sm 
                 focus:ring-emerald-500 focus:border-emerald-500"
        >
          <option value="">-- Selecciona --</option>
          @foreach ($tipo_sesiones as $t)
            <option value="{{ $t->id }}">{{ $t->nombre }}</option>
          @endforeach
        </select>
        @error('tipo_sesion') <span class="text-sm text-red-600">{{ $message }}</span> @enderror
      </div>

      {{-- Carácter --}}
      <div>
        <x-label for="caracter" value="Carácter de sesión" />
        <select
          id="caracter"
          wire:model="caracter"
          class="mt-1 w-full border-gray-300 rounded-lg shadow-sm 
                 focus:ring-emerald-500 focus:border-emerald-500"
        >
          <option value="">-- Selecciona --</option>
          @foreach ($caracteres_sesiones as $c)
            <option value="{{ $c->id }}">{{ $c->nombre }}</option>
          @endforeach
        </select>
        @error('caracter') <span class="text-sm text-red-600">{{ $message }}</span> @enderror
      </div>
    </div>

    {{-- ===== FECHAS Y HORAS ===== --}}
    <div class="grid grid-cols-1 md:grid-cols-[1fr_1fr_1fr_200px] gap-6 mt-8">
      {{-- Fecha programada --}}
      <div>
        <x-ui.date-picker
          label="Fecha programada"
          wire:model="fecha_programada"
          :disable-past="true"
        />
      </div>

      {{-- Hora programada --}}
      <div>
        <x-label for="hora_programada" value="Hora programada" class="whitespace-normal leading-tight" />
        <x-input
          id="hora_programada"
          type="time"
          wire:model="hora_programada"
          class="mt-1 w-full border-gray-300 rounded-lg shadow-sm 
                 focus:ring-emerald-500 focus:border-emerald-500"
        />
        @error('hora_programada') <span class="text-sm text-red-600">{{ $message }}</span> @enderror
      </div>

      {{-- Hora estimada de término --}}
      <div>
        <x-label for="hora_termino" value="Hora estimada de término" class="whitespace-normal leading-tight" />
        <x-input
          id="hora_termino"
          type="time"
          wire:model="hora_termino"
          class="mt-1 w-full border-gray-300 rounded-lg shadow-sm 
                 focus:ring-emerald-500 focus:border-emerald-500"
        />
        @error('hora_termino') <span class="text-sm text-red-600">{{ $message }}</span> @enderror
      </div>

      {{-- Botón agregar receso --}}
      <div class="flex flex-col justify-end">
        <x-button
          type="button"
          wire:click="agregarReceso"
          class="w-full bg-emerald-600 hover:bg-emerald-700 text-white justify-center"
        >
          Agregar Receso
        </x-button>
      </div>
    </div>

    {{-- ===== UI Recesos ===== --}}
    @include('sesion.includes.recesos')
  </fieldset>

  <div class="flex justify-end space-x-4 mt-10">
    @if(!$bloqueado)
      <x-button variant="primary" wire:click="continuar">
        Continuar
      </x-button>

      <x-button as="a" href="{{ route('dashboard') }}" variant="secondary">
        Cancelar
      </x-button>
    @else
      <x-button wire:click="corregir" variant="warning">
        Corregir
      </x-button>

      <x-button wire:click="guardar" variant="primary">
        Guardar
      </x-button>

      <x-button as="a" href="{{ route('dashboard') }}" variant="secondary">
        Cancelar
      </x-button>
    @endif
  </div>
</div>
