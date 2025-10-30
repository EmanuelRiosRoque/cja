<div class="space-y-6 p-6  bg-white shadow-md rounded-xl">
    @include('sesion.includes.orden-dia.encabezado')


    <div>
    <h3 class="font-semibold text-gray-800 border-b pb-1 mb-2">
        Temas Capturados
    </h3>
    <table class="w-full border text-sm">
        <thead class="bg-gray-100 text-gray-700">
            <tr>
                <th class="p-2 border">No.</th>
                <th class="p-2 border">Tema</th>
                <th class="p-2 border">Prioridad</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($temas as $index => $tema)
            <tr>
                <td class="p-2 border text-center w-10">{{ $tema->numero_tema }}</td>
                <td class="p-2 border">{{ $tema->descripcion }}</td>
                <td class="p-2 border text-center w-28">
                        @php
                        $prioridad = [
                        1 => 'Alta',
                        2 => 'Media',
                        3 => 'Baja',
                        ][$tema->prioridad] ?? 'Sin asignar';
                        @endphp
                        {{ $prioridad }}
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
        <x-button 
            href="{{ route('sesion.index') }}"
            class="justify-center"
            variant="secondary"
            as="a"
        >
            Regresar
        </x-button>

        <x-button>
            Generar documento en Word
        </x-button>
    </div>
</div>
</div>
