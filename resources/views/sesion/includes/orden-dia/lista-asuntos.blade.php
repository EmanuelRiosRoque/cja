<div>
    <h3 class="font-semibold text-gray-800 border-b pb-1 mb-2">
        Asuntos Adicionales
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
            @forelse ($temasAdicionales as $index => $tema)
            <tr>
                <td class="p-2 border text-center">{{ $tema->numeroTema }}</td>
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
                    {{ $tema->presentadores->pluck('nombre')->join(', ') }}
                </td>
                <td class="p-2 border text-center">
                    {{ $tema->descripcion }}
                </td>

                <td class="p-2 border text-center">
                    <button wire:click="eliminar({{ $tema->id }})" class="text-red-600 hover:text-red-800"
                        title="Eliminar">
                        Eliminar
                    </button>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="5" class="text-center p-3 text-gray-500">
                    No hay asuntos adicionales registrados.
                </td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>