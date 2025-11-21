<x-dialog-modal wire:model="mostrarModalConfirmacion">
    <x-slot name="title">
        {{ $modoEdicion ? 'Confirmar actualización' : 'Confirmar registro' }}
    </x-slot>

    <x-slot name="content">
        <div class="text-gray-700 space-y-2">
            <p class="font-semibold text-gray-900">
                {{ $modoEdicion ? '¿Desea actualizar esta solicitud?' : '¿Seguro que desea realizar el registro?' }}
            </p>

            <p class="text-sm text-gray-600">
                {{ $modoEdicion 
                    ? 'Por favor asegúrese de que los datos modificados sean correctos antes de actualizar.' 
                    : 'Por favor asegúrese de que todos los campos capturados y el documento proporcionado sean correctos.' }}
            </p>
        </div>
    </x-slot>

    <x-slot name="footer">
        <div class="flex justify-end space-x-3">
            <x-button
                wire:click="$set('mostrarModalConfirmacion', false)"
                variant="danger"
            >
                Cancelar
            </x-button>

            <x-button
                wire:click="{{ $modoEdicion ? 'actualizarRegistro' : 'realizarRegistro' }}"
                variant="primary"
            >
                {{ $modoEdicion ? 'Actualizar' : 'Aceptar' }}
            </x-button>
        </div>
    </x-slot>
</x-dialog-modal>



    <x-dialog-modal wire:model="mostrarModalExito">
        <x-slot name="title">
            Modal registro correcto
        </x-slot>

        <x-slot name="content">
            <p class="text-gray-700 text-base">
                El registro se realizó de manera correcta.
            </p>
        </x-slot>

         <x-slot name="footer">
            <div class="flex justify-end">
                <x-button
                    wire:click="cerrarModalExito"
                    class="bg-emerald-700 hover:bg-emerald-800 text-white px-4 py-2 rounded-md"
                >
                    Aceptar
                </x-button>
            </div>
        </x-slot>
    </x-dialog-modal>