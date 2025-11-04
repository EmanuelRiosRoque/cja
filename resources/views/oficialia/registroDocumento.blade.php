<x-app-layout>
     <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Registro de Documento') }}
        </h2>
    </x-slot>

    <div class="pt-2">  {{-- <- antes py-8 --}}
        <div class="max-w-5xl mx-auto sm:px-6 lg:px-8">
                <livewire:oficialia.registro-documento />
        </div>
    </div>
</x-app-layout>
