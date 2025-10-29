<div class="mt-4 p-4 border border-blue-200 bg-blue-50 rounded-md">
    <p class="text-sm text-gray-700">
        Esta opción permite crear una sesión sin especificar ningún dato de la fecha y lugar,
        permitiendo iniciar la captura de la orden del día.
    </p>

    <div class="flex gap-3 mt-4">
        <x-button type="button" wire:click="referenciar"
            class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-md">
            Referenciar
        </x-button>

        <x-button as="a" href="{{ route('dashboard') }}"
            class="bg-gray-400 hover:bg-gray-500 text-white px-4 py-2 rounded-md">
            Cancelar
        </x-button>
    </div>
</div>