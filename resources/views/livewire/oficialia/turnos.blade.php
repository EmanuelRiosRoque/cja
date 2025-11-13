<div class="overflow-x-auto p-6 bg-gray-50 rounded-lg w-full max-w-none">

    @include('livewire.oficialia.includes.filtro')
    {{-- TABLA --}}
    <div class="bg-white shadow-md rounded border border-gray-300">

        <table class="w-full table-auto">
            <thead>
                <tr class="bg-gray-200 text-gray-600 uppercase text-sm leading-normal">
                    <th class="py-3 px-6 text-left">Área de procedencia</th>
                    <th class="py-3 px-6 text-left">Promovente</th>
                    <th class="py-3 px-6 text-center">Tipo de procedencia</th>
                    <th class="py-3 px-6 text-center">Turno</th>
                    <th class="py-3 px-6 text-center">Anexos</th>
                    <th class="py-3 px-6 text-center">Fecha recepción</th>
                    <th class="py-3 px-6 text-center">Clasificación</th>
                    <th class="py-3 px-6 text-center">Tipo</th>
                    <th class="py-3 px-6 text-center">Documento</th>
                    <th class="py-3 px-6 text-center">Acciones</th>
                </tr>
            </thead>

            <tbody class="text-gray-600 text-sm font-light">
                @for ($i = 1; $i <= 10; $i++) <tr class="border-b border-gray-200 hover:bg-gray-100">
                    <td class="py-3 px-6 text-left whitespace-nowrap">
                        Área Jurídica {{ $i }}
                    </td>
                    <td class="py-3 px-6 text-left">
                        Juan Pérez {{ $i }}
                    </td>
                    <td class="py-3 px-6 text-center">
                        Interno
                    </td>
                    <td class="py-3 px-6 text-center">
                        #{{ 100 + $i }}
                    </td>
                    <td class="py-3 px-6 text-center">
                        {{ rand(0,1) ? 'Sí' : 'No' }}
                    </td>
                    <td class="py-3 px-6 text-center">
                        {{ now()->subDays(rand(1,30))->format('d/m/Y') }}
                    </td>
                    <td class="py-3 px-6 text-center">
                        Oficio
                    </td>
                    <td class="py-3 px-6 text-center">
                        {{ rand(1,2) === 1 ? 'Original' : 'Copia' }}
                    </td>

                    {{-- Documento --}}
                    <td class="py-3 px-6 text-center">
                        <div class="flex item-center justify-center">
                            <a wire:click='abrirModalEditarTurno'
                                class="w-4 mr-2 transform hover:text-red-500 hover:scale-110"
                                    title="Ver documento">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none"
                                    stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M7 3h10a2 2 0 012 2v14a2 2 0 01-2 2H7a2 2 0 01-2-2V5a2 2 0 012-2z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M9 15c1.5-3 3.5-6 6-9m0 9c-1.5-1-3-1.5-4.5-1.5m4.5 1.5c.5-.5 1.5-1.5 2-2.5" />
                                </svg>
                            </a>
                        </div>
                    </td>

                    {{-- Acciones --}}
                    <td class="py-3 px-6 text-center">
                        <div class="flex item-center justify-center">

                            <a href="{{ route('oficialia.registro') }}"
                                class="w-4 mr-2 transform hover:text-emerald-500 hover:scale-110"
                                    title="Editar registro">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                    stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M4 4h16v16H4V4z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M8 12h8M8 8h8M8 16h3m2 3l4 4m0 0l4-4m-4 4V9" />
                                </svg>
                            </a>

                            <a wire:click='abrirModalEditarTurno'
                                class="w-4 mr-2 transform hover:text-purple-500 hover:scale-110"
                                    title="Editar turno">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                    stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 20h9M16.5 3.5a2.121 2.121 0 013 3L8 18l-4 1 1-4 11.5-11.5z" />
                                </svg>
                            </a>

                            <a wire:click='abrirModalCancelar'
                                class="w-4 mr-2 transform hover:text-red-500 hover:scale-110"
                                    title="Cancelar">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none"
                                    stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M3 6h18M8 6V4a1 1 0 011-1h6a1 1 0 011 1v2m2 0v14a2 2 0 01-2 2H8a2 2 0 01-2-2V6z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M10 11v6M14 11v6" />
                                </svg>
                            </a>

                        </div>
                    </td>
                    </tr>
                    @endfor
            </tbody>
        </table>

    </div>



    <x-dialog-modal wire:model="modalCancelar">
        <x-slot name="title">
            Modal Cancelar
        </x-slot>

        <x-slot name="content">
            <p class="text-gray-700 text-base">
                ¿Está seguro de que desea <span class="font-semibold text-red-600">CANCELAR</span> el registro
                seleccionado?
            </p>
        </x-slot>

        <x-slot name="footer">
            <div class="flex justify-end gap-3">
                <x-button wire:click="$set('modalCancelar', false)" variant="danger">
                    Cancelar
                </x-button>

                <x-button wire:click="confirmarCancelar" variant="primary">
                    Confirmar
                </x-button>
            </div>
        </x-slot>
    </x-dialog-modal>

 

    <x-dialog-modal wire:model="modalEditarTurno" maxWidth="md">
        <x-slot name="title">
            Modal Editar Turno
        </x-slot>

        <x-slot name="content">
            <p class="text-gray-700 text-base mb-4">
                Por favor seleccione a qué área se turnará el registro seleccionado
            </p>

            <select wire:model="turnoSeleccionado"
                class="w-full border-gray-300 rounded-md focus:ring-emerald-500 focus:border-emerald-500">
                <option value="">-- Selecciona el área --</option>
                <option value="pleno">Pleno</option>
                <option value="seguimiento">Seguimiento</option>
                <option value="amparo">Amparo</option>
                <option value="varios">Varios</option>
            </select>
        </x-slot>

        <x-slot name="footer">
            <div class="flex justify-end gap-3">
                <x-button wire:click="$set('modalEditarTurno', false)" variant="danger">
                    Cancelar
                </x-button>

                <x-button wire:click="confirmarEditarTurno" variant="primary">
                    Editar turno
                </x-button>
            </div>
        </x-slot>
    </x-dialog-modal>
</div>