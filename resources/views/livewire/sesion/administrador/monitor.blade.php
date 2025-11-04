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
            Estado de los temas
        </h3>

        <form wire:submit.prevent="asignarTemas" class="space-y-4">
            <table class="w-full border text-sm">
                <thead class="bg-gray-100 text-gray-700">
                    <tr>
                        <th class="p-2 border">No.</th>
                        <th class="p-2 border">Tema</th>
                        <th class="p-2 border text-center">Estatus</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($temas as $tema)
                        <tr>
                            <td class="p-2 border text-center">{{ $tema->numero_tema }}</td>
                            <td class="p-2 border">{{ $tema->descripcion }}</td>

                            <td class="p-2 border text-center">
                                @php
                                    $estatus = strtolower($tema->estatus->nombre ?? 'pendiente');
                                @endphp

                                @if ($estatus === 'asignado')
                                    <span class="inline-flex items-center gap-1 px-2 py-1 text-xs font-medium rounded-full bg-emerald-100 text-emerald-700">
                                        {{-- Ícono check --}}
                                        <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />
                                        </svg>
                                        Asignado
                                    </span>
                                @elseif ($estatus === 'pendiente')
                                    <span class="inline-flex items-center gap-1 px-2 py-1 text-xs font-medium rounded-full bg-amber-100 text-amber-700">
                                        {{-- Ícono reloj --}}
                                        <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                        </svg>
                                        Pendiente
                                    </span>
                                @else
                                    <span class="inline-flex items-center gap-1 px-2 py-1 text-xs font-medium rounded-full bg-gray-100 text-gray-600">
                                        {{-- Ícono neutro --}}
                                        <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6l4 2" />
                                        </svg>
                                        {{ ucfirst($tema->estatus->nombre ?? 'Sin definir') }}
                                    </span>
                                @endif
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
        </form>
    </div>
</div>
