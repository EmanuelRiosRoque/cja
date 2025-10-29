<div>
    <h3 class="font-semibold text-gray-800 border-b pb-1 mb-2">
        Temas Capturados
    </h3>
    <table class="w-full border text-sm">
        <thead class="bg-gray-100 text-gray-700">
            <tr>
                <th class="p-2 border">No.</th>
                <th class="p-2 border">Prioridad</th>
                <th class="p-2 border">Presenta</th>
                <th class="p-2 border">Descripción</th>
                <th class="p-2 border">Acción</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($temas as $index => $tema)
            <tr>
                <td class="p-2 border text-center">{{ $tema->numero_tema }}</td>
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
                <td class="p-2 border">
                    {{ $tema->presentadores->pluck('nombre')->join(', ') }}
                </td>
                <td class="p-2 border">{{ $tema->descripcion }}</td>
                <td class="p-2 border text-center space-x-1">
                    @php
                    $esPrimero = $loop->first;
                    $esUltimo = $loop->last;
                    @endphp

                    <button
                        class="inline-flex items-center justify-center px-2 py-1 rounded-md ring-1 ring-gray-300 text-gray-700 hover:bg-gray-100 disabled:opacity-40 disabled:cursor-not-allowed"
                        wire:click="moverArriba({{ $tema->id }})" @disabled($esPrimero) title="Mover arriba">
                        ↑
                    </button>

                    <button
                        class="inline-flex items-center justify-center px-2 py-1 rounded-md ring-1 ring-gray-300 text-gray-700 hover:bg-gray-100 disabled:opacity-40 disabled:cursor-not-allowed"
                        wire:click="moverAbajo({{ $tema->id }})" @disabled($esUltimo) title="Mover abajo">
                        ↓
                    </button>
                    <button wire:click="editar({{ $tema->id }})" class="text-blue-600 hover:text-blue-800"
                        title="Editar">
                        Editar
                    </button>
                    <button wire:click="eliminar({{ $tema->id }})" class="text-red-600 hover:text-red-800"
                        title="Eliminar">
                        Eliminar
                    </button>
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
</div>