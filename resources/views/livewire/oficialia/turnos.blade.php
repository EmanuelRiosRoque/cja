<div class="overflow-x-auto p-6 bg-gray-50 rounded-lg w-full max-w-none">

    {{-- 🔹 FILTROS DE BÚSQUEDA --}}
    <div class="grid grid-cols-4 gap-4 mb-6 bg-white p-4 rounded-lg shadow-sm border border-gray-200">
        <div>
            <x-ui.date-picker label="Fecha de recepción" wire:model="fecha_recepcion" :disable-past="true" />
        </div>

        <div>
            <x-label for="tipo_entrega" value="Entrega Física / Virtual" />
            <select id="tipo_entrega" wire:model="tipo_entrega"
                class="mt-1 w-full border-gray-300 rounded-lg shadow-sm focus:ring-emerald-500 focus:border-emerald-500">
                <option value="">-- Selecciona --</option>
                <option value="1">OPF</option>
                <option value="2">SICAPOAJ</option>
            </select>
        </div>

        <div>
            <x-label for="tipo_procedencia" value="Tipo de procedencia" />
            <select id="tipo_procedencia" wire:model="tipo_procedencia"
                class="mt-1 w-full border-gray-300 rounded-lg shadow-sm focus:ring-emerald-500 focus:border-emerald-500">
                <option value="">-- Selecciona --</option>
                <option value="1">Interno</option>
                <option value="2">Externo</option>
                <option value="3">Particular</option>
            </select>
        </div>

        <div>
            <x-label for="area_procedencia" value="Área de procedencia" />
            <select id="area_procedencia" wire:model="area_procedencia"
                class="mt-1 w-full border-gray-300 rounded-lg shadow-sm focus:ring-emerald-500 focus:border-emerald-500">
                <option value="">-- Selecciona --</option>
                <option value="1">Área 1</option>
                <option value="2">Área 2</option>
                <option value="3">Área 3</option>
            </select>
        </div>

        <div>
            <x-label for="turno" value="Turno" />
            <select id="turno" wire:model="turno"
                class="mt-1 w-full border-gray-300 rounded-lg shadow-sm focus:ring-emerald-500 focus:border-emerald-500">
                <option value="">-- Selecciona --</option>
                <option value="1">Pleno</option>
                <option value="2">Seguimiento</option>
                <option value="3">Amparo</option>
                <option value="4">Varios</option>
            </select>
        </div>

        <div>
            <x-label for="no_oficio" value="Número de oficio" />
            <x-input id="no_oficio" type="text" wire:model="no_oficio"
                class="mt-1 w-full border-gray-300 rounded-lg shadow-sm focus:ring-emerald-500 focus:border-emerald-500" />
        </div>

        <div>
            <x-label for="promovente" value="Promovente" />
            <x-input id="promovente" type="text" wire:model="promovente"
                class="mt-1 w-full border-gray-300 rounded-lg shadow-sm focus:ring-emerald-500 focus:border-emerald-500" />
        </div>

        <div>
            <x-label for="tipo" value="Tipo" />
            <select id="tipo" wire:model="tipo"
                class="mt-1 w-full border-gray-300 rounded-lg shadow-sm focus:ring-emerald-500 focus:border-emerald-500">
                <option value="">-- Selecciona --</option>
                <option value="1">Original</option>
                <option value="2">Copia</option>
            </select>
        </div>

        <div class="flex items-end gap-2">
            <x-button wire:click="limpiarFiltros" variant="secondary">LIMPIAR</x-button>
            <x-button wire:click="buscarRegistros" variant="primary">BUSCAR</x-button>
        </div>
    </div>

    {{-- 🔹 TABLA --}}
    <div class="bg-white shadow-md rounded border border-gray-300">
        <table class="w-full border-collapse text-sm">
            <thead>
                <tr class="bg-gray-100 text-gray-700 uppercase text-xs border-b border-gray-300">
                    <th class="py-3 px-4 border-r border-gray-300">Área de procedencia</th>
                    <th class="py-3 px-4 border-r border-gray-300">Promovente</th>
                    <th class="py-3 px-4 border-r border-gray-300">Tipo de procedencia</th>
                    <th class="py-3 px-4 border-r border-gray-300">Turno</th>
                    <th class="py-3 px-4 border-r border-gray-300 text-center">Anexos</th>
                    <th class="py-3 px-4 border-r border-gray-300 text-center">Fecha recepción</th>
                    <th class="py-3 px-4 border-r border-gray-300 text-center">Clasificación</th>
                    <th class="py-3 px-4 border-r border-gray-300 text-center">Tipo</th>
                    <th class="py-3 px-4 border-r border-gray-300 text-center">Documento</th>
                    <th class="py-3 px-4 text-center">Acciones</th>
                </tr>
            </thead>
            <tbody class="text-gray-700">
                @for ($i = 1; $i <= 10; $i++)
                    <tr class="border-b border-gray-200 hover:bg-gray-50">
                        <td class="py-2 px-4 border-r border-gray-200">Área Jurídica {{ $i }}</td>
                        <td class="py-2 px-4 border-r border-gray-200">Juan Pérez {{ $i }}</td>
                        <td class="py-2 px-4 border-r border-gray-200 text-center">Interno</td>
                        <td class="py-2 px-4 border-r border-gray-200 text-center">#{{ 100 + $i }}</td>
                        <td class="py-2 px-4 border-r border-gray-200 text-center">{{ rand(0,1) ? 'Sí' : 'No' }}</td>
                        <td class="py-2 px-4 border-r border-gray-200 text-center">{{ now()->subDays(rand(1,30))->format('d/m/Y') }}</td>
                        <td class="py-2 px-4 border-r border-gray-200 text-center">Oficio</td>
                        <td class="py-2 px-4 border-r border-gray-200 text-center">{{ rand(1,2) === 1 ? 'Original' : 'Copia' }}</td>
                        <td class="py-2 px-4 border-r border-gray-200 text-center">
                            <button class="bg-red-600 hover:bg-red-700 text-white text-xs px-3 py-1 rounded shadow">
                                VER DOCUMENTO
                            </button>
                        </td>
                        <td class="py-2 px-4 text-center w-96">
                            <div class="flex flex-wrap justify-center gap-1">
                               <button
                                    wire:click="abrirModalEditarRegistro"
                                    class="bg-blue-600 hover:bg-blue-700 text-white text-xs font-semibold px-3 py-1.5 rounded-md shadow-sm transition">
                                    EDITAR REGISTRO
                                </button>

                               <button
                                    wire:click="abrirModalEditarTurno"
                                    class="bg-emerald-600 hover:bg-emerald-700 text-white text-xs font-semibold px-3 py-1.5 rounded-md shadow-sm transition">
                                    EDITAR TURNO
                                </button>


                                <button wire:click="abrirModalCancelar"
                                    class="bg-red-600 hover:bg-red-700 text-white text-xs font-semibold px-3 py-1.5 rounded-md shadow-sm transition">
                                    CANCELAR
                                </button>

                            </div>
                        </td>
                    </tr>
                @endfor
            </tbody>
        </table>
    </div>

    {{-- MODAL DE CONFIRMACIÓN --}}
   {{-- 🔹 MODAL CANCELAR --}}
<x-dialog-modal wire:model="modalCancelar">
    <x-slot name="title">
        Modal Cancelar
    </x-slot>

    <x-slot name="content">
        <p class="text-gray-700 text-base">
            ¿Está seguro de que desea <span class="font-semibold text-red-600">CANCELAR</span> el registro seleccionado?
        </p>
    </x-slot>

    <x-slot name="footer">
        <div class="flex justify-end gap-3">
            <x-button
                wire:click="$set('modalCancelar', false)"
                variant="danger"
                >
                Cancelar
            </x-button>

            <x-button
                wire:click="confirmarCancelar"
                variant="primary"
            >
                Confirmar
            </x-button>
        </div>
    </x-slot>
</x-dialog-modal>


<x-dialog-modal wire:model="modalEditarRegistro" maxWidth="2xl">
    <x-slot name="title">
        Modal Editar Registro
    </x-slot>

    <x-slot name="content">
        <div class="grid grid-cols-3 gap-4 mb-4">
            <div>
                <x-label value="Tipo de procedencia:" />
                <select wire:model="tipo_procedencia"
                    class="w-full mt-1 border-gray-300 rounded-md focus:ring-emerald-500 focus:border-emerald-500">
                    <option value="">-- Selecciona --</option>
                    <option value="1">Interno</option>
                    <option value="2">Externo</option>
                    <option value="3">Particular</option>
                </select>
            </div>

            <div>
                <x-label value="Área de procedencia:" />
                <select wire:model="area_procedencia"
                    class="w-full mt-1 border-gray-300 rounded-md focus:ring-emerald-500 focus:border-emerald-500">
                    <option value="">-- Selecciona --</option>
                    <option value="1">Área 1</option>
                    <option value="2">Área 2</option>
                    <option value="3">Área 3</option>
                </select>
            </div>

            <div>
                <x-label value="Entrega física/virtual:" />
                <select wire:model="entrega"
                    class="w-full mt-1 border-gray-300 rounded-md focus:ring-emerald-500 focus:border-emerald-500">
                    <option value="">-- Selecciona --</option>
                    <option value="1">Física</option>
                    <option value="2">Virtual</option>
                </select>
            </div>
        </div>

        <div class="grid grid-cols-3 gap-4 mb-4">
            <div>
                <x-label value="No. de oficio:" />
                <x-input type="text" wire:model="no_oficio"
                    class="w-full mt-1 border-gray-300 rounded-md focus:ring-emerald-500 focus:border-emerald-500" />
            </div>

            <div>
                <x-label value="Promovente:" />
                <x-input type="text" wire:model="promovente"
                    class="w-full mt-1 border-gray-300 rounded-md focus:ring-emerald-500 focus:border-emerald-500" />
            </div>

            <div>
                <x-label value="Tipo:" />
                <select wire:model="tipo"
                    class="w-full mt-1 border-gray-300 rounded-md focus:ring-emerald-500 focus:border-emerald-500">
                    <option value="">-- Selecciona --</option>
                    <option value="1">Original</option>
                    <option value="2">Copia</option>
                </select>
            </div>
        </div>

        <div class="grid grid-cols-3 gap-4 mb-4">
            <div>
                <x-label value="Turno:" />
                <select wire:model="turno"
                    class="w-full mt-1 border-gray-300 rounded-md focus:ring-emerald-500 focus:border-emerald-500">
                    <option value="">-- Selecciona --</option>
                    <option value="1">Pleno</option>
                    <option value="2">Seguimiento</option>
                    <option value="3">Amparo</option>
                    <option value="4">Varios</option>
                </select>
            </div>

            <div>
                <x-label value="Anexos:" />
                <select wire:model="anexos"
                    class="w-full mt-1 border-gray-300 rounded-md focus:ring-emerald-500 focus:border-emerald-500">
                    <option value="">-- Selecciona --</option>
                    <option value="1">Sí</option>
                    <option value="0">No</option>
                </select>
            </div>
        </div>

        <div class="grid grid-cols-2 gap-4">
            <div>
                <x-label value="Descripción (síntesis):" />
                <x-input type="text" wire:model="descripcion"
                    class="w-full mt-1 border-gray-300 rounded-md focus:ring-emerald-500 focus:border-emerald-500" />
            </div>

            <div>
                <x-label value="Descripción anexos:" />
                <x-input type="text" wire:model="descripcion_anexos"
                    class="w-full mt-1 border-gray-300 rounded-md focus:ring-emerald-500 focus:border-emerald-500" />
            </div>
        </div>
    </x-slot>

    <x-slot name="footer">
        <div class="flex justify-end gap-3">
            <x-button
                wire:click="$set('modalEditarRegistro', false)"
                variant="danger"   
            >
                Cancelar
            </x-button>

            <x-button
                wire:click="confirmarEditarRegistro"
                variant="primary"   
                >
                Editar registro
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
            <x-button
                wire:click="$set('modalEditarTurno', false)"
                class="bg-red-700 hover:bg-red-800 text-white px-4 py-2 rounded-md">
                Cancelar
            </x-button>

            <x-button
                wire:click="confirmarEditarTurno"
                class="bg-emerald-700 hover:bg-emerald-800 text-white px-4 py-2 rounded-md">
                Editar turno
            </x-button>
        </div>
    </x-slot>
</x-dialog-modal>


</div>
