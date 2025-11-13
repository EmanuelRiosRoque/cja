<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Reportes') }}
        </h2>
        <p class="text-gray-600 text-sm">
            Por favor seleccione el reporte que desea generar
        </p>
    </x-slot>

    <div class="py-6">
        <div class="max-w-2xl m-auto px-8 space-y-6">

            {{-- FILTROS Y BOTONES DE REPORTE --}}
            <div class="bg-white border border-gray-200 shadow-sm rounded-lg p-6">
                
                {{-- Filtros --}}
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-6">
                    <div>
                        <x-label for="fecha_inicio" value="Fecha Inicio" />
                        <x-input type="date" id="fecha_inicio" wire:model="fecha_inicio"
                            class="mt-1 w-full border-gray-300 rounded-lg shadow-sm focus:ring-emerald-500 focus:border-emerald-500" />
                    </div>

                    <div>
                        <x-label for="fecha_fin" value="Fecha Fin" />
                        <x-input type="date" id="fecha_fin" wire:model="fecha_fin"
                            class="mt-1 w-full border-gray-300 rounded-lg shadow-sm focus:ring-emerald-500 focus:border-emerald-500" />
                    </div>

                   
                </div>

                {{-- Botones --}}
                <div class="flex flex-wrap md:flex-nowrap gap-4 justify-center md:justify-center">
                    <x-button
                        wire:click="generarPDF"
                        variant="primary">                       
                        Documentos Aceptados 
                    </x-button>

                    <x-button
                        wire:click="generarExcel"
                        variant="danger">
                        Documentos Rechazados
                    </x-button>

                    <x-button
                        wire:click="generarExcel"
                        variant="blue">
                        Registros Diarios 
                    </x-button>
                </div>
            </div>

        </div>
    </div>
</x-app-layout>
