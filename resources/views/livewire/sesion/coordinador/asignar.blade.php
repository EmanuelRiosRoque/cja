<div class="space-y-6 p-6 bg-white shadow-md rounded-xl">
    {{-- Alertas --}}
    @if (session('success'))
        <x-ui.alerts type="success" :message="session('success')" timer="true" />
    @endif
    @if (session('error'))
        <x-ui.alerts type="error" :message="session('error')" timer="true" />
    @endif

    {{-- Encabezado --}}
    @include('sesion.includes.orden-dia.encabezado')

    {{-- Tabla --}}
    <div>
        <h3 class="font-semibold text-gray-800 border-b pb-1 mb-2">
            Temas Capturados
        </h3>

        <form wire:submit.prevent="asignarTemas" class="space-y-4">
            <table class="w-full border text-sm">
                <thead class="bg-gray-100 text-gray-700">
                    <tr>
                        <th class="p-2 border text-center w-10">
                            <input 
                                type="checkbox" 
                                wire:model="selectAll"
                                class="text-emerald-600 border-gray-300 rounded focus:ring-emerald-500 focus:border-emerald-500"
                                {{ $todosAsignados ? 'disabled' : '' }}
                            >
                        </th>
                        <th class="p-2 border">No.</th>
                        <th class="p-2 border">Tema</th>
                        <th class="p-2 border">Prioridad</th>
                        <th class="p-2 border">¿Asignado?</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($temas as $tema)
                        @php
                            $asignado = $tema->fk_estatus == 2;
                        @endphp
                        <tr class="{{ in_array($tema->id, $temasSeleccionados) ? 'bg-emerald-50' : '' }}">
                            <td class="p-2 border text-center">
                                <input 
                                    type="checkbox" 
                                    wire:model="temasSeleccionados" 
                                    value="{{ $tema->id }}"
                                    class="text-emerald-600 border-gray-300 rounded focus:ring-emerald-500 focus:border-emerald-500"
                                    {{ $asignado ? 'disabled' : '' }}
                                >
                            </td>
                            <td class="p-2 border text-center">{{ $tema->numeroTema }}</td>
                            <td class="p-2 border">{{ $tema->descripcion }}</td>
                            <td class="p-2 border text-center">
                                @php
                                    $prioridad = [
                                        1 => 'Alta',
                                        2 => 'Media',
                                        3 => 'Baja',
                                    ][$tema->prioridad] ?? 'Sin asignar';
                                @endphp
                                {{ $prioridad }}
                            </td>
                            <td class="p-2 border text-center">
                                <span class="{{ $asignado ? 'text-green-600 font-semibold' : 'text-gray-600' }}">
                                    {{ $tema->estatus->nombre }}
                                </span>
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

            {{-- Sección de asignación --}}
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 items-center mt-4">
                <div>
                    <x-label for="usuarioId" value="Asignar a usuario" />
                    <select
                        id="usuarioId"
                        wire:model="usuarioId"
                        class="mt-1 w-full border-gray-300 rounded-lg shadow-sm 
                               focus:ring-emerald-500 focus:border-emerald-500"
                        {{ $todosAsignados ? 'disabled' : '' }}
                    >
                        <option value="">-- Selecciona --</option>
                        @foreach ($usuarios as $usuario)
                            <option value="{{ $usuario->id }}">{{ $usuario->name }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="flex gap-3 justify-end">
                    <x-button 
                        type="button" 
                        wire:click="$set('temasSeleccionados', [])" 
                        variant="secondary"
                        :disabled="$todosAsignados"
                    >
                        Limpiar selección
                    </x-button>

                    <x-button 
                        type="submit" 
                        :disabled="$todosAsignados"
                    >
                        Asignar temas
                    </x-button>
                </div>
            </div>
        </form>
    </div>
</div>
