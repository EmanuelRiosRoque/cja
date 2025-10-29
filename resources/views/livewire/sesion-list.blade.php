<!-- component -->
<div class="overflow-x-auto">
        <div class="flex items-center justify-center  font-sans overflow-hidden">
            <div class="w-full lg:w-9/6">
                <div class="bg-white shadow-md rounded my-6">
                    <table class=" w-full table-auto">
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
                            @foreach ($sesiones as $sesion)
                            <tr class="border-b border-gray-200 hover:bg-gray-100">
                                <td class="py-3 px-6 text-left whitespace-nowrap">
                                    {{ $sesion->folio }}
                                </td>
                                <td class="py-3 px-6 text-left">
                                    {{ $sesion->forma_captura }}
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
                                            {{ $sesion->created_at->format('d/m/Y') }}
                                        </div>
                                        <div class="flex items-center gap-1 text-sm font-medium">
                                            {{ $sesion->created_at->format('h:i A') }}
                                        </div>
                                    </div>
                                </td>

                                <td class="py-3 px-6 text-center">
                                    @if (!$sesion->temas_exists)
                                    <x-button as="a" href="{{ route('sesion.ordenDia', $sesion) }}">
                                        Agregar
                                    </x-button>
                                    @else
                                    {{--  
                                    ** 1 = Ver
                                    ** 2 = Cargar Documentos
                                    ** 3 = Editar
                                    ** 4 = Finalizar
                                    --}}
                                    <div class="flex item-center justify-center">
                                        <a 
                                            href="{{ route('sesion.temas', $sesion) }}" 
                                            class="w-4 mr-2 transform hover:text-emerald-500 hover:scale-110"
                                        >
                                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <circle cx="11" cy="11" r="7" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-4.35-4.35" />
                                            </svg>
                                        </a>

                                        <a 
                                            href="{{ route('sesion.adjuntar', $sesion) }}" 
                                            class="w-4 mr-2 transform hover:text-red-500 hover:scale-110"
                                        >
                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 3h10a2 2 0 012 2v14a2 2 0 01-2 2H7a2 2 0 01-2-2V5a2 2 0 012-2z" />
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 15c1.5-3 3.5-6 6-9m0 9c-1.5-1-3-1.5-4.5-1.5m4.5 1.5c.5-.5 1.5-1.5 2-2.5" />
                                            </svg>
                                        </a>
                                      
                                        <a 
                                            href="{{ route('sesion.ordenDia', $sesion)  }}" 
                                            class="w-4 mr-2 transform hover:text-yellow-500 hover:scale-110"
                                        >
                                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z" />
                                            </svg>
                                        </a>
                                     
                                        <a 
                                            href="{{ route('sesion.ponencia', $sesion)  }}" 
                                            class="w-4 mr-2 transform hover:text-blue-500 hover:scale-110"
                                        >                                            
                                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9l-6-6H7a2 2 0 00-2 2v14a2 2 0 002 2z" />
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 3v6h6" />
                                            </svg>
                                        </a>
                                    </div>
                                    @endif
                                </td>
                                <td class="py-3 px-6 text-center">
                                    <div class="flex item-center justify-center">
                                        <div class="w-4 mr-2 transform hover:text-purple-500 hover:scale-110">
                                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                            </svg>
                                        </div>
                                        <div class="w-4 mr-2 transform hover:text-purple-500 hover:scale-110">
                                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z" />
                                            </svg>
                                        </div>
                                        <div class="w-4 mr-2 transform hover:text-purple-500 hover:scale-110">
                                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                            </svg>
                                        </div>
                                    </div>
                                </td>

                                <td class="py-3 px-6 text-center">
                                    <div class="flex item-center justify-center">
                                        <div class="w-4 mr-2 transform hover:text-purple-500 hover:scale-110">
                                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                            </svg>
                                        </div>
                                        <div class="w-4 mr-2 transform hover:text-purple-500 hover:scale-110">
                                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z" />
                                            </svg>
                                        </div>
                                        <div class="w-4 mr-2 transform hover:text-purple-500 hover:scale-110">
                                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                            </svg>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>