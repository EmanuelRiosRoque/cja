<div class="space-y-6 p-6  bg-white shadow-md rounded-xl">

    {{-- Encabezado de sesión --}}
    @include('sesion.includes.orden-dia.encabezado')

    {{-- Formulario de tema --}}
    @include('sesion.includes.orden-dia.formulario')

    {{-- Lista de temas capturados --}}
    @include('sesion.includes.orden-dia.lista-temas')

    {{-- Asuntos adicionales --}}
    @include('sesion.includes.orden-dia.lista-asuntos')
    

    {{-- Terminar captura --}}
    <div class="text-right pt-4">
        <x-button wire:click="terminarCaptura" variant="primary">
            Terminar Captura
        </x-button>
    </div>
</div>