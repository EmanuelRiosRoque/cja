<div class="space-y-6 p-6  bg-white shadow-md rounded-xl">
    @if (session('success'))
    <x-ui.alerts type="success" :message="session('success')" timer="true" />
    @endif

    @include('sesion.includes.orden-dia.encabezado')

    <div>
        <h3 class="font-semibold text-gray-800 border-b pb-1 mb-2">
            Temas Capturados
        </h3>
        <table class="w-full border text-sm ">
            <thead class="bg-gray-100 text-gray-700">
                <tr>
                    <th class="p-2 border">No.Tema</th>
                    <th class="p-2 border">Documentos</th>
                    <th class="p-2 border">Acciones</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($temas as $index => $tema)
                <tr>
                    <td class="p-2 border text-center w-10">{{ $tema->numero_tema }}</td>
                    <td class="p-2 border align-top text-center">
                        @if ($tema->documentos->isNotEmpty())
                        <x-button wire:click="abrirModal({{ $tema->id }})" variant="secondary" size="sm">
                            Ver documentos
                        </x-button>
                        @else
                        <p class="text-center  text-gray-500">No hay documentos para este tema</p>
                        @endif
                    </td>
                    <td class="p-2 border text-center w-96">
                        <div class="flex items-center justify-center space-x-2">
                            <input type="file" wire:model="archivo.{{ $tema->id }}" accept=".pdf,.jpg,.png,.doc,.docx"
                                class="block w-full text-sm text-gray-700 
                                file:mr-4 file:py-2 file:px-3 
                                file:rounded-md file:border-0 
                                file:text-sm file:font-medium 
                                file:bg-gray-600 file:text-white 
                                hover:file:bg-gray-700 
                                border border-gray-300 rounded-md 
                                cursor-pointer focus:outline-none 
                                focus:ring-2 focus:ring-gray-500 focus:border-gray-500 transition">
                            <x-button size="sm" wire:click="adjuntar({{ $tema->id }})" wire:loading.attr="disabled">
                                <span wire:loading.remove wire:target="adjuntar({{ $tema->id }})">Adjuntar</span>
                                <span wire:loading wire:target="adjuntar({{ $tema->id }})">Subiendo...</span>
                            </x-button>
                        </div>

                        @error("archivo.$tema->id")
                        <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                        @enderror
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="text-center p-3 text-gray-500">
                        No hay temas capturados.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
        <div class="grid grid-flow-row gap-3  justify-center mt-4">
            <x-button href="{{ route('sesion.index') }}" class="justify-center" variant="secondary" as="a">
                Regresar
            </x-button>
        </div>
    </div>

    <x-dialog-modal wire:model="mostrarModalDocumentos" maxWidth="lg">
        <x-slot name="title">
            Documentos del tema
            @if($temaSeleccionado)
            #{{ $temas->firstWhere('id', $temaSeleccionado)?->numero_tema }}
            @endif
        </x-slot>

        <x-slot name="content">
            @php
            $temaActual = $temas->firstWhere('id', $temaSeleccionado);
            @endphp

            @if ($temaActual && $temaActual->documentos->isNotEmpty())
            <ul class="mt-2 space-y-2 text-sm text-gray-700 list-disc list-inside">
                @foreach ($temaActual->documentos as $doc)
                <li>
                    <a href="{{ $doc->url }}" target="_blank"
                        class="text-emerald-600 hover:underline hover:text-emerald-800 transition">
                        📄 {{ $doc->nombre }}
                    </a>
                </li>
                @endforeach
            </ul>
            @else
            <p class="mt-2 text-sm text-gray-500 italic">
                Sin documentos adjuntos
            </p>
            @endif
        </x-slot>

        <x-slot name="footer">
            <x-button variant="secondary" wire:click="$set('mostrarModalDocumentos', false)">
                Cerrar
            </x-button>
        </x-slot>
    </x-dialog-modal>

    <script>
        document.addEventListener('livewire:init', () => {
            Livewire.on('limpiar-input', ({ id }) => {
                const input = document.querySelector(`input[type="file"][wire\\:model="archivo.${id}"]`);
                if (input) {
                    input.value = ''; // resetea el input real
                }
            });
        });
    </script>
</div>