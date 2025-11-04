    <div class="grid grid-cols-4 gap-4 mb-6 bg-white p-4 rounded-lg shadow-sm border border-gray-200">
        <div>
            <x-ui.date-picker label="Fecha de recepción" wire:model="fecha_recepcion" :disable-past="true" />
        </div>

        <div>
            <x-label for="tipo_entrega" value="Entrega Física / Virtual" />
            <select id="tipo_entrega" wire:model="tipo_entrega"
                class="mt-1 w-full border-gray-300 rounded-lg shadow-sm focus:ring-emerald-500 focus:border-emerald-500">
                <option value="">-- Selecciona --</option>
                <option value="1">OPF</option>
                <option value="2">SICAPOAJ</option>
            </select>
        </div>

        <div>
            <x-label for="tipo_procedencia" value="Tipo de procedencia" />
            <select id="tipo_procedencia" wire:model="tipo_procedencia"
                class="mt-1 w-full border-gray-300 rounded-lg shadow-sm focus:ring-emerald-500 focus:border-emerald-500">
                <option value="">-- Selecciona --</option>
                <option value="1">Interno</option>
                <option value="2">Externo</option>
                <option value="3">Particular</option>
            </select>
        </div>

        <div>
            <x-label for="area_procedencia" value="Área de procedencia" />
            <select id="area_procedencia" wire:model="area_procedencia"
                class="mt-1 w-full border-gray-300 rounded-lg shadow-sm focus:ring-emerald-500 focus:border-emerald-500">
                <option value="">-- Selecciona --</option>
                <option value="1">Área 1</option>
                <option value="2">Área 2</option>
                <option value="3">Área 3</option>
            </select>
        </div>

        <div>
            <x-label for="turno" value="Turno" />
            <select id="turno" wire:model="turno"
                class="mt-1 w-full border-gray-300 rounded-lg shadow-sm focus:ring-emerald-500 focus:border-emerald-500">
                <option value="">-- Selecciona --</option>
                <option value="1">Pleno</option>
                <option value="2">Seguimiento</option>
                <option value="3">Amparo</option>
                <option value="4">Varios</option>
            </select>
        </div>

        <div>
            <x-label for="no_oficio" value="Número de oficio" />
            <x-input id="no_oficio" type="text" wire:model="no_oficio"
                class="mt-1 w-full border-gray-300 rounded-lg shadow-sm focus:ring-emerald-500 focus:border-emerald-500" />
        </div>

        <div>
            <x-label for="promovente" value="Promovente" />
            <x-input id="promovente" type="text" wire:model="promovente"
                class="mt-1 w-full border-gray-300 rounded-lg shadow-sm focus:ring-emerald-500 focus:border-emerald-500" />
        </div>

        <div>
            <x-label for="tipo" value="Tipo" />
            <select id="tipo" wire:model="tipo"
                class="mt-1 w-full border-gray-300 rounded-lg shadow-sm focus:ring-emerald-500 focus:border-emerald-500">
                <option value="">-- Selecciona --</option>
                <option value="1">Original</option>
                <option value="2">Copia</option>
            </select>
        </div>
        <div class="">
            <x-button wire:click="limpiarFiltros" variant="secondary">
                LIMPIAR
            </x-button>
            <x-button wire:click="buscarRegistros" variant="primary">
                BUSCAR
            </x-button>
        </div>
    </div>