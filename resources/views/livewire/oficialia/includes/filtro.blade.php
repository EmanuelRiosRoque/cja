{{-- CONTENEDOR DE FILTROS --}}
<div x-data="{ open: false }" class="mb-6">

    {{-- BOTÓN MODERNO --}}
    <button 
        x-on:click="open = !open"
        class="flex items-center gap-2 px-4 py-2 bg-white border border-gray-300 text-gray-700 font-medium rounded-lg shadow-sm hover:bg-gray-100 hover:border-gray-400 transition-all">
        
        <svg x-show="!open" xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-emerald-600" fill="none"
            viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                d="M19 9l-7 7-7-7" />
        </svg>

        <svg x-show="open" xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-emerald-600" fill="none"
            viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                d="M5 15l7-7 7 7" />
        </svg>

        <span class="text-emerald-700">
            <span x-show="!open">Mostrar filtros</span>
            <span x-show="open">Ocultar filtros</span>
        </span>
    </button>

    {{-- PANEL DESPLEGABLE --}}
    <div 
        x-show="open"
        x-transition
        class="mt-3 bg-white border border-gray-200 rounded-xl shadow-lg p-5">

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5">

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

        </div>

        {{-- BOTONES --}}
        <div class="flex justify-end gap-3 mt-6">
            <x-button wire:click="limpiarFiltros" variant="secondary">LIMPIAR</x-button>
            <x-button wire:click="buscarRegistros" variant="primary">BUSCAR</x-button>
        </div>

    </div>
</div>
