<div class="space-y-6 p-6 bg-white shadow-md rounded-xl">

    {{-- Entrega / Procedencia --}}
    <div class="grid grid-cols-3 gap-4">
        <div>
            <x-ui.date-picker
                label="Fecha de recepción"
                wire:model="fecha_recepcion"
                :disable-past="true"
            />
        </div>

        <div>
            <x-label for="tipo_entrega" value="Entrega Física / Virtual" />
            <select
                id="tipo_entrega"
                wire:model="tipo_entrega"
                class="mt-1 w-full border-gray-300 rounded-lg shadow-sm focus:ring-emerald-500 focus:border-emerald-500"
            >
                <option value="">-- Selecciona --</option>
                <option value="1">OPF</option>
                <option value="2">SICAPOAJ</option>
            </select>
            @error('tipo_entrega') <span class="text-sm text-red-600">{{ $message }}</span> @enderror
        </div>

        <div>
            <x-label for="tipo_procedencia" value="Tipo de procedencia" />
            <select
                id="tipo_procedencia"
                wire:model="tipo_procedencia"
                class="mt-1 w-full border-gray-300 rounded-lg shadow-sm focus:ring-emerald-500 focus:border-emerald-500"
            >
                <option value="">-- Selecciona --</option>
                <option value="1">Interno</option>
                <option value="2">Externo</option>
                <option value="3">Particular</option>
            </select>
            @error('tipo_procedencia') <span class="text-sm text-red-600">{{ $message }}</span> @enderror
        </div>

        <div>
            <x-label for="area_procedencia" value="Área de procedencia" />
            <select
                id="area_procedencia"
                wire:model="area_procedencia"
                class="mt-1 w-full border-gray-300 rounded-lg shadow-sm focus:ring-emerald-500 focus:border-emerald-500"
            >
                <option value="">-- Selecciona --</option>
                <option value="1">Área 1</option>
                <option value="2">Área 2</option>
                <option value="3">Área 3</option>
            </select>
            @error('area_procedencia') <span class="text-sm text-red-600">{{ $message }}</span> @enderror
        </div>

        <div>
            <x-label for="turno" value="Turno" />
            <select
                id="turno"
                wire:model="turno"
                class="mt-1 w-full border-gray-300 rounded-lg shadow-sm focus:ring-emerald-500 focus:border-emerald-500"
            >
                <option value="">-- Selecciona --</option>
                <option value="1">Pleno</option>
                <option value="2">Seguimiento</option>
                <option value="3">Amparo</option>
                <option value="4">Varios</option>
            </select>
            @error('turno') <span class="text-sm text-red-600">{{ $message }}</span> @enderror
        </div>

        <div>
            <x-label for="anexos" value="Anexos" />
            <select
                id="anexos"
                wire:model="anexos"
                class="mt-1 w-full border-gray-300 rounded-lg shadow-sm focus:ring-emerald-500 focus:border-emerald-500"
            >
                <option value="">-- Selecciona --</option>
                <option value="1">Sí</option>
                <option value="0">No</option>
            </select>
            @error('anexos') <span class="text-sm text-red-600">{{ $message }}</span> @enderror
        </div>

        <div>
            <x-label for="no_oficio" value="Número de oficio" />
            <x-input
                id="no_oficio"
                type="text"
                wire:model="no_oficio"
                class="mt-1 w-full border-gray-300 rounded-lg shadow-sm focus:ring-emerald-500 focus:border-emerald-500"
            />
            @error('no_oficio') <span class="text-sm text-red-600">{{ $message }}</span> @enderror
        </div>

        <div>
            <x-label for="promovente" value="Promovente" />
            <x-input
                id="promovente"
                type="text"
                wire:model="promovente"
                class="mt-1 w-full border-gray-300 rounded-lg shadow-sm focus:ring-emerald-500 focus:border-emerald-500"
            />
            @error('promovente') <span class="text-sm text-red-600">{{ $message }}</span> @enderror
        </div>

        <div>
            <x-label for="tipo" value="Tipo" />
            <select
                id="tipo"
                wire:model="tipo"
                class="mt-1 w-full border-gray-300 rounded-lg shadow-sm focus:ring-emerald-500 focus:border-emerald-500"
            >
                <option value="">-- Selecciona --</option>
                <option value="1">Original</option>
                <option value="2">Copia</option>
            </select>
            @error('tipo') <span class="text-sm text-red-600">{{ $message }}</span> @enderror
        </div>
    </div>

    {{-- Descripción --}}
    <div class="grid grid-cols-2 gap-4">
        <div>
            <x-label for="descripcion" value="Descripción (síntesis)" />
            <x-input
                id="descripcion"
                type="text"
                wire:model="descripcion"
                class="mt-1 w-full border-gray-300 rounded-lg shadow-sm focus:ring-emerald-500 focus:border-emerald-500"
            />
            @error('descripcion') <span class="text-sm text-red-600">{{ $message }}</span> @enderror
        </div>

        <div>
            <x-label for="descripcion_anexos" value="Descripción de anexos" />
            <x-input
                id="descripcion_anexos"
                type="text"
                wire:model="descripcion_anexos"
                class="mt-1 w-full border-gray-300 rounded-lg shadow-sm focus:ring-emerald-500 focus:border-emerald-500"
            />
            @error('descripcion_anexos') <span class="text-sm text-red-600">{{ $message }}</span> @enderror
        </div>
    </div>

    {{-- Botones de acción --}}
       <div class="flex justify-between mt-6">
        <x-button
            type="button"
            wire:click="subirDocumento"
            variant="danger"
        >
            Subir documento
        </x-button>

        <x-button
            type="button"
            wire:click="$set('mostrarModalConfirmacion', true)"
            variant="primary"
        >
            Realizar Registro
        </x-button>
    </div>

    @include('livewire.oficialia.includes.modales')
</div>
