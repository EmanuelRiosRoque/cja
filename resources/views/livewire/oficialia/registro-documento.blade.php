<div class="space-y-6 p-6 bg-white shadow-md rounded-xl" x-data="{ anexos: '', tipo_procedencia: '' }"
    x-on:form-enviado.window="
        anexos = '';
        tipo_procedencia = '';
    ">
    @if (session('success'))
    <x-ui.alerts type="success" :message="session('success')" timer="true" />
    @endif

    <div class="grid grid-cols-4 gap-4">
        <!-- Fecha recepción -->
        <div>
            <x-ui.date-picker label="Fecha de recepción" wire:model="fecha_recepcion" :disable-past="true" />
        </div>

        <!-- Entrega -->
        <div>
            <x-label for="tipo_entrega" value="Entrega Física / Virtual" />
            <select id="tipo_entrega" wire:model="tipo_entrega"
                class="mt-1 w-full border-gray-300 rounded-lg shadow-sm focus:ring-emerald-500 focus:border-emerald-500">
                <option value="">-- Selecciona --</option>
                @foreach ($catEntregas as $entrega)
                <option value="{{ $entrega->id }}">{{ $entrega->entrega }}</option>
                @endforeach
            </select>
            @error('tipo_entrega') <span class="text-sm text-red-600">{{ $message }}</span> @enderror
        </div>

        <!-- Tipo -->
        <div>
            <x-label for="tipo" value="Tipo" />
            <select id="tipo" wire:model="tipo"
                class="mt-1 w-full border-gray-300 rounded-lg shadow-sm focus:ring-emerald-500 focus:border-emerald-500">
                <option value="">-- Selecciona --</option>
                @foreach ($catTipoDocs as $tipoDoc)
                <option value="{{ $tipoDoc->id }}">{{ $tipoDoc->tipoDoc }}</option>
                @endforeach
            </select>
            @error('tipo') <span class="text-sm text-red-600">{{ $message }}</span> @enderror
        </div>

        <!-- Número de oficio -->
        <div>
            <x-label for="no_oficio" value="Número de oficio" />
            <x-input id="no_oficio" type="text" wire:model="no_oficio"
                class="mt-1 w-full border-gray-300 rounded-lg shadow-sm focus:ring-emerald-500 focus:border-emerald-500" />
            @error('no_oficio') <span class="text-sm text-red-600">{{ $message }}</span> @enderror
        </div>

        <!-- Turno -->
        <div>
            <x-label for="turno" value="Turno" />
            <select id="turno" wire:model="turno"
                class="mt-1 w-full border-gray-300 rounded-lg shadow-sm focus:ring-emerald-500 focus:border-emerald-500">
                <option value="">-- Selecciona --</option>
                @foreach ($catTurnos as $turno)
                <option value="{{ $turno->id }}">{{ $turno->areaTurno }}</option>
                @endforeach
            </select>
            @error('turno') <span class="text-sm text-red-600">{{ $message }}</span> @enderror
        </div>

        <!-- Descripción -->
        <div class="col-span-3">
            <x-label for="descripcion" value="Descripción (síntesis)" />
            <x-input id="descripcion" type="text" wire:model="descripcion"
                class="mt-1 w-full border-gray-300 rounded-lg shadow-sm focus:ring-emerald-500 focus:border-emerald-500" />
            @error('descripcion') <span class="text-sm text-red-600">{{ $message }}</span> @enderror
        </div>

        <!-- Anexos -->
        <div>
            <x-label for="anexos" value="Anexos" />
            <select id="anexos" x-model="anexos" wire:model="anexos"
                class="mt-1 w-full border-gray-300 rounded-lg shadow-sm focus:ring-emerald-500 focus:border-emerald-500">
                <option value="">-- Selecciona --</option>
                @foreach ($catAnexos as $anexo)
                <option value="{{ $anexo->id }}">{{ $anexo->anexo }}</option>
                @endforeach
            </select>
            @error('anexos') <span class="text-sm text-red-600">{{ $message }}</span> @enderror
        </div>

        <!-- Descripción de anexos (siempre visible pero deshabilitado) -->
        <div class="col-span-2">
            <x-label for="descripcion_anexos" value="Descripción de anexos" />
            <x-input id="descripcion_anexos" type="text" wire:model="descripcion_anexos" x-bind:disabled="anexos != '1'"
                class="mt-1 w-full border-gray-300 rounded-lg shadow-sm 
                       focus:ring-emerald-500 focus:border-emerald-500
                       disabled:bg-gray-100 disabled:text-gray-500" />
            @error('descripcion_anexos')
            <span class="text-sm text-red-600">{{ $message }}</span>
            @enderror
        </div>

        <!-- Tipo de procedencia -->
        <div>
            <x-label for="tipo_procedencia" value="Tipo de procedencia" />
            <select id="tipo_procedencia" x-model="tipo_procedencia" wire:model="tipo_procedencia"
                class="mt-1 w-full border-gray-300 rounded-lg shadow-sm focus:ring-emerald-500 focus:border-emerald-500">
                <option value="">-- Selecciona --</option>
                @foreach ($catProcedencias as $procendencia)
                <option value="{{ $procendencia->id }}">{{ $procendencia->tipoProcedencia }}</option>
                @endforeach
            </select>
            @error('tipo_procedencia') <span class="text-sm text-red-600">{{ $message }}</span> @enderror
        </div>

        <!-- Línea divisoria -->
        <div class="col-span-4 border-b-2 font-bold">
            <p>Favor de llenar los siguientes campos por promovente a vincular a la solicitud:</p>
        </div>

        <!-- Área de procedencia -->
        <div>
            <!-- Campo de ejemplo deshabilitado -->
            <div x-show="tipo_procedencia == ''" x-cloak>
                <x-label for="area_procedencia_demo" value="Área de procedencia" />
                <x-input id="area_procedencia_demo" type="text" placeholder="Selecciona tipo de procedencia" disabled
                    class="mt-1 w-full border-gray-300 rounded-lg shadow-sm 
                   bg-gray-100 text-gray-500 cursor-not-allowed" />
            </div>

            <!-- Select visible solo si es Interno o Particular -->
            <div x-show="tipo_procedencia == '1' || tipo_procedencia == '3'" x-cloak>
                <x-ui.select-search label="Área de procedencia" wireModel="area_procedencia">
                    @foreach ($catAreaProcedencias as $proc)
                    <option value="{{ $proc->id }}" data-opt>{{ $proc->areaProcedencia }}</option>
                    @endforeach
                </x-ui.select-search>
            </div>

            <!-- Input visible solo si es Externo -->
            <div x-show="tipo_procedencia == '2'" x-cloak>
                <x-label for="area_procedencia_text" value="Área de procedencia" />
                <x-input id="area_procedencia_text" type="text" wire:model="area_procedencia_text" class="mt-1 w-full border-gray-300 rounded-lg shadow-sm 
                   focus:ring-emerald-500 focus:border-emerald-500" />
                @error('area_procedencia_text')
                <span class="text-sm text-red-600">{{ $message }}</span>
                @enderror
            </div>
        </div>

        <!-- Nombre promovente -->
        <div>
            <x-label for="nombre" value="Nombre" />
            <x-input id="nombre" type="text" wire:model="nombre"
                class="mt-1 w-full border-gray-300 rounded-lg shadow-sm focus:ring-emerald-500 focus:border-emerald-500" />
            @error('nombre') <span class="text-sm text-red-600">{{ $message }}</span> @enderror
        </div>

        <!-- Apellido paterno -->
        <div>
            <x-label for="paterno" value="Apellido paterno" />
            <x-input id="paterno" type="text" wire:model="paterno"
                class="mt-1 w-full border-gray-300 rounded-lg shadow-sm focus:ring-emerald-500 focus:border-emerald-500" />
            @error('paterno') <span class="text-sm text-red-600">{{ $message }}</span> @enderror
        </div>

        <!-- Apellido materno -->
        <div>
            <x-label for="materno" value="Apellido materno" />
            <x-input id="materno" type="text" wire:model="materno"
                class="mt-1 w-full border-gray-300 rounded-lg shadow-sm focus:ring-emerald-500 focus:border-emerald-500" />
            @error('materno') <span class="text-sm text-red-600">{{ $message }}</span> @enderror
        </div>

        <!-- Botón agregar promovente -->
        <div>
            <x-button type="button" wire:click="agregarPromovente" variant="primary">
                Agregar promovente
            </x-button>
        </div>

        <!-- Tabla de promoventes -->
        <div class="col-span-4 mt-4">
            @if(!empty($promoventes))
            <table class="w-full border border-gray-200 text-sm">
                <thead class="bg-gray-100 text-gray-700">
                    <tr>
                        <th class="p-2 border">#</th>
                        <th class="p-2 border">Nombre completo</th>
                        <th class="p-2 border">Área</th>
                        <th class="p-2 border w-16">Acción</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($promoventes as $index => $item)
                    <tr>
                        <td class="p-2 border text-center">{{ $index + 1 }}</td>
                        <td class="p-2 border">
                            {{ $item['nombre'] }} {{ $item['paterno'] }} {{ $item['materno'] }}
                        </td>

                        <td class="p-2 border">
                            {{ $item['area_nombre'] ?? '—' }}
                        </td>

                        <td class="p-2 border text-center">
                            <button wire:click="eliminarPromovente({{ $index }})"
                                class="text-red-600 hover:text-red-800">
                                ✕
                            </button>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
            @else
            <p class="text-gray-500 text-sm text-center">No hay promoventes agregados.</p>
            @endif
        </div>

    </div>

    <!-- Botones finales -->
    <div class=" mt-28">
        <div class="flex justify-between space-x-2">


            @if ($modoEdicion)
            <x-button type="button" as="a" href="{{ route('oficialia.turnos') }}" variant="secondary">
                Volver
            </x-button>
            @else
            <div x-data="{ fileName: '' }">
                <!-- INPUT REAL (oculto) -->
                <input type="file" id="archivoInput" wire:model="archivo" class="hidden"
                    @change="fileName = $event.target.files[0]?.name || 'Ningún archivo seleccionado'" />

                <!-- BOTÓN PERSONALIZADO -->
                <label for="archivoInput" class="inline-flex items-center px-4 py-2 bg-red-600 hover:bg-red-700 
               text-white text-sm font-medium rounded-md cursor-pointer">
                    Subir documento
                </label>

                <!-- TEXTO DEL ARCHIVO SELECCIONADO -->
                <span class="ml-3 text-sm text-gray-600" x-text="fileName || 'Ningún archivo seleccionado'"></span>

                @error('archivo')
                <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>


            @endif

            <x-button type="button" wire:click="$set('mostrarModalConfirmacion', true)" variant="primary">
                {{ $modoEdicion ? 'Actualizar' : 'Registrar' }}
            </x-button>
        </div>
    </div>

    @include('livewire.oficialia.includes.modales')
</div>