<div class="overflow-x-auto p-6 bg-gray-50 rounded-lg w-full max-w-none">

    @include('livewire.oficialia.includes.filtro')

    @if (session('message'))
    <x-ui.alerts type="success" :message="session('message')" timer="true" />
    @endif

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
                    <th class="py-3 px-6 text-center">Entrega</th>
                    <th class="py-3 px-6 text-center">Tipo</th>
                    <th class="py-3 px-6 text-center">Documento</th>
                    <th class="py-3 px-6 text-center">Acciones</th>
                </tr>
            </thead>

            <tbody class="text-gray-600 text-sm font-light">

                @forelse ($solicitudes as $solicitud)
                <tr class="border-b border-gray-200 hover:bg-gray-100">

                    <td class="py-3 px-6 text-left">
                        {{ $solicitud->promoventes_areas ?? '—' }}
                    </td>

                    <td class="py-3 px-6 text-left">
                        {{ $solicitud->promoventes_nombres ?? '—' }}
                    </td>

                    <td class="py-3 px-6 text-center">
                        {{ $solicitud->tipoProcedencia->tipoProcedencia ?? '—' }}
                    </td>

                    <td class="py-3 px-6 text-center">
                        {{ $solicitud->areaTurno->areaTurno ?? '—' }}
                    </td>

                    <td class="py-3 px-6 text-center">
                        {{ $solicitud->anexos ? 'Sí' : 'No' }}
                    </td>

                    <td class="py-3 px-6 text-center">
                        {{ $solicitud->fechaAlta }}
                    </td>

                    <td class="py-3 px-6 text-center">
                        {{ $solicitud->entrega->entrega ?? '—' }}
                    </td>

                    <td class="py-3 px-6 text-center">
                        {{ $solicitud->tipoDoc->tipoDoc ?? '—' }}
                    </td>

                    {{-- DOCUMENTO --}}
                    <td class="py-3 px-6 text-center">
                        <div class="flex items-center justify-center">
                            <a wire:click="abrirModalDocumentos({{ $solicitud->id }})"
                                class="w-5 transform hover:text-blue-600 hover:scale-110 cursor-pointer"
                                title="Ver documentos">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24"
                                    stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M7 3h10a2 2 0 012 2v14a2 2 0 01-2 2H7a2 2 0 01-2-2V5a2 2 0 012-2z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M9 15l3-3 3 3m0 0l-3 3m3-3H9" />
                                </svg>
                            </a>
                        </div>
                    </td>


                    {{-- ACCIONES --}}
                    <td class="py-3 px-6 text-center">
                        <div class="flex item-center justify-center">

                            {{-- EDITAR REGISTRO --}}
                            <a href="{{ route('oficialia.registro', ['id' => $solicitud->id]) }}"
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


                            {{-- EDITAR TURNO --}}
                            <a wire:click="abrirModalEditarTurno({{ $solicitud->id }})"
                                class="w-4 mr-2 transform hover:text-purple-500 hover:scale-110" title="Editar turno">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                    stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 20h9M16.5 3.5a2.121 2.121 0 013 3L8 18l-4 1 1-4 11.5-11.5z" />
                                </svg>
                            </a>

                            {{-- CANCELAR --}}
                            <a wire:click="abrirModalCancelar({{ $solicitud->id }})"
                                class="w-4 mr-2 transform hover:text-red-500 hover:scale-110" title="Cancelar">
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
                @empty
                <tr>
                    <td colspan="10" class="py-6 text-center text-gray-500">
                        No hay solicitudes registradas.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    {{-- MODAL CANCELAR --}}
    <x-dialog-modal wire:model="modalCancelar">
        <x-slot name="title">Cancelar solicitud</x-slot>

        <x-slot name="content">
            <p class="text-gray-700 text-base">
                ¿Está seguro de que desea <span class="font-semibold text-red-600">CANCELAR</span> esta solicitud?
            </p>
        </x-slot>

        <x-slot name="footer">
            <div class="flex justify-end gap-3">
                <x-button wire:click="$set('modalCancelar', false)" variant="danger">
                    No, volver
                </x-button>

                <x-button wire:click="confirmarCancelar" variant="primary">
                    Sí, cancelar
                </x-button>
            </div>
        </x-slot>
    </x-dialog-modal>

    {{-- MODAL DE PREVIEW DE DOCUMENTO --}}
    <x-dialog-modal wire:model="modalDocumentos" maxWidth="2xl">

        <x-slot name="title">
            Documentos del empleado
        </x-slot>

        <x-slot name="content">

            @php
            // EJEMPLOS PARA VISTA
            $documentosSeleccionados = [
            [
            'tipo' => 'Contrato PDF',
            'extension' => 'pdf',
            'url' => 'https://www.africau.edu/images/default/sample.pdf',
            ],
            [
            'tipo' => 'Contrato PDF',
            'extension' => 'pdf',
            'url' => 'https://www.africau.edu/images/default/sample.pdf',
            ],
            [
            'tipo' => 'Contrato PDF',
            'extension' => 'pdf',
            'url' => 'https://www.africau.edu/images/default/sample.pdf',
            ],
            [
            'tipo' => 'Contrato PDF',
            'extension' => 'pdf',
            'url' => 'https://www.africau.edu/images/default/sample.pdf',
            ],
            ];
            @endphp


            @if (!empty($documentosSeleccionados))

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">

                @foreach ($documentosSeleccionados as $doc)

                @php
                $ext = strtolower($doc['extension'] ?? '');
                @endphp

                <div class="border rounded-lg p-2 bg-gray-50 shadow-sm">

                    <h4 class="text-sm font-semibold text-gray-700 mb-2">
                        {{ $doc['tipo'] }}
                    </h4>

                    {{-- ===========================
                    DOCUMENTO EXISTENTE
                    ============================ --}}
                    @if ($doc['url'])

                    {{-- PDF --}}
                    @if ($ext === 'pdf')
                    <iframe src="{{ $doc['url'] }}#toolbar=0" class="w-full h-64 rounded-md border"></iframe>


                    @endif
                    {{-- ============================
                    SIN DOCUMENTO
                    ============================= --}}
                    @else
                    <p class="text-gray-500 text-sm italic text-center py-8">
                        Documento no disponible
                    </p>

                    <div class="text-center text-xs text-gray-400">
                        Ejemplo: el empleado no ha subido este archivo.
                    </div>
                    @endif

                </div>

                @endforeach

            </div>

            @else

            <p class="text-sm text-gray-500 text-center py-6">
                No hay documentos disponibles para este empleado.
            </p>

            <div class="text-xs text-center text-gray-400">
                Ejemplo: lista vacía.
            </div>

            @endif

        </x-slot>

        <x-slot name="footer">
            <x-secondary-button wire:click="$set('modalDocumentos', false)">
                Cerrar
            </x-secondary-button>
        </x-slot>

    </x-dialog-modal>

    {{-- MODAL EDITAR TURNO --}}
    <x-dialog-modal wire:model="modalEditarTurno" maxWidth="md">
        <x-slot name="title">Editar turno</x-slot>

        <x-slot name="content">
            <p class="text-gray-700 mb-4">
                Seleccione a qué área se turnará este registro:
            </p>

            <select wire:model="turnoSeleccionado"
                class="w-full border-gray-300 rounded-md focus:ring-emerald-500 focus:border-emerald-500">
                <option value="">-- Selecciona el área --</option>
                @foreach(\App\Models\Catalogos\CatAreaTurno::all() as $area)
                <option value="{{ $area->id }}">{{ $area->areaTurno }}</option>
                @endforeach
            </select>
        </x-slot>

        <x-slot name="footer">
            <div class="flex justify-end gap-3">
                <x-button wire:click="$set('modalEditarTurno', false)" variant="danger">
                    Cancelar
                </x-button>

                <x-button wire:click="confirmarEditarTurno" variant="primary">
                    Guardar
                </x-button>
            </div>
        </x-slot>
    </x-dialog-modal>

</div>