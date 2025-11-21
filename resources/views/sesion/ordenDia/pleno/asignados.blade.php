
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Turnos asignados') }}
        </h2>
        {{-- <p>
            Por favor seleccione la acción que desea hacer a cada registro. Puede realizar la búsqueda de registros de acuerdo a los siguientes campos.
        </p> --}}
    </x-slot>

    <div class="py-6">
        <div class="w-full px-8"> {{-- tabla ocupa todo el ancho --}}
            <livewire:sesion.pleno.asignados :solicitudes="$solicitudes" />
        </div>
    </div>
</x-app-layout>
