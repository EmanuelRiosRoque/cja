<x-app-layout>
     <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Información de las sesiones del Pleno') }}
        </h2>
    </x-slot>

    <div class="pt-2">  {{-- <- antes py-8 --}}
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <livewire:sesion.listado />
        </div>
    </div>
</x-app-layout>
