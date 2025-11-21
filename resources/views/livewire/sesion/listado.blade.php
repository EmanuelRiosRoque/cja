<div class="overflow-x-auto">
    <div class="flex items-center justify-center font-sans overflow-hidden">
        <div class="w-full lg:w-9/6">
            <div class="bg-white shadow-md rounded my-6">
                <table class="w-full table-auto">
                    <thead>
                        <tr class="bg-gray-200 text-gray-600 uppercase text-sm leading-normal">
                            <th class="py-3 px-6 text-left">No.</th>
                            <th class="py-3 px-6 text-left">Tipo</th>
                            <th class="py-3 px-6 text-center">Caracter</th>
                            <th class="py-3 px-6 text-center">Fecha Programada</th>
                            <th class="py-3 px-6 text-center">Fecha de Celebración</th>
                            <th class="py-3 px-6 text-center">Orden del Día</th>
                            <th class="py-3 px-6 text-center">Desarrollo de Sesión</th>
                            <th class="py-3 px-6 text-center">Controlador de Versiones de Acta</th>
                        </tr>
                    </thead>
                    <tbody class="text-gray-600 text-sm font-light">
                        @forelse ($sesiones as $sesion)
                            <tr class="border-b border-gray-200 hover:bg-gray-100">
                                <td class="py-3 px-6 text-left whitespace-nowrap">
                                    {{ $sesion->folio }}
                                </td>
                                <td class="py-3 px-6 text-left">
                                    {{ $sesion->forma_captura == 1 ? 'Programada' : 'Referida' }}
                                </td>
                                <td class="py-3 px-6 text-center">
                                    {{ $sesion->caracter->nombre }}
                                </td>
                                <td class="py-3 px-6 text-center">
                                    {{ $sesion->fecha_programada }}
                                </td>
                                <td class="py-3 px-6 text-center">
                                    <div class="flex flex-col items-center text-gray-700">
                                        <div class="flex items-center gap-1 text-xs text-gray-500">
                                            {{ \Carbon\Carbon::parse($sesion->fechaAlta)->format('d/m/Y') }}
                                        </div>
                                    </div>
                                </td>

                                <td class="py-3 px-6 text-center">
                                    @if ($sesion->temas_count === 0)
                                        <x-button as="a" href="{{ route('sesion.ordenDia', $sesion) }}">
                                            Agregar
                                        </x-button>
                                    @else
                                        @role(['Pleno', 'SuperAdmin'])
                                            @include('sesion.includes.orden-dia.integrador.views')
                                        @endrole

                                        @role(['Administrador', 'SuperAdmin'])
                                            <div class="flex item-center justify-center">
                                                <a href="{{ route('sesion.monitor', $sesion) }}" class="w-4 mr-2 transform hover:text-emerald-500 hover:scale-110">
                                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                                        stroke-width="1.8" stroke="currentColor" class="w-4 h-4">
                                                        <path stroke-linecap="round" stroke-linejoin="round" d="M4 21v-8m5 8v-5m5 5V9m5 12V3" />
                                                    </svg>
                                                </a>
                                            </div>
                                        @endrole

                                        @role(['Coordinador','SuperAdmin'])
                                            <div class="flex item-center justify-center">
                                                <a href="{{ route('sesion.asignar', $sesion) }}" class="w-4 mr-2 transform hover:text-emerald-500 hover:scale-110">
                                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                                        stroke-width="1.8" stroke="currentColor" class="w-4 h-4">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            d="M15.75 6a3.75 3.75 0 1 1-7.5 0 3.75 3.75 0 0 1 7.5 0z" />
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            d="M4.5 20.25a8.25 8.25 0 0 1 15 0M17 13l2 2 4-4" />
                                                    </svg>
                                                </a>
                                            </div>
                                        @endrole
                                        @role(['Integrador','SuperAdmin'])
                                            <div class="flex item-center justify-center">
                                                <a href="{{ route('sesion.ponencia', $sesion) }}" class="w-4 mr-2 transform hover:text-emerald-500 hover:scale-110">
                                                   <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" 
                                                        fill="none" stroke="currentColor" stroke-width="1.6" 
                                                        stroke-linecap="round" stroke-linejoin="round" 
                                                        class="w-5 h-5">
                                                    <!-- Documento -->
                                                    <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/>
                                                    <path d="M14 2v6h6"/>
                                                    <!-- Lápiz -->
                                                    <path d="M16.5 14.5l3 3L17 20h-3v-3l2.5-2.5z"/>
                                                    </svg>
                                                </a>
                                            </div>
                                        @endrole
                                    @endif
                                </td>
                                <td class="py-3 px-6 text-center">---</td>
                                <td class="py-3 px-6 text-center">---</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8" class="py-5 text-center text-gray-500 bg-gray-50">
                                    <div class="flex flex-col items-center justify-center">
                                        <span class="text-sm font-medium">No hay sesiones aún</span>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
