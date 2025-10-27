<div class="py-10">
    <div class="max-w-5xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white shadow-xl sm:rounded-lg p-8">

            <!-- Sección: Forma de captura -->
            <h3 class="text-lg font-semibold text-emerald-800 mb-6 border-b pb-2 text-left">
                Forma de captura
            </h3>

            <div class="flex items-center space-x-6 mb-8">
                <label class="inline-flex items-center">
                    <x-input type="radio" wire:model="forma_captura" value="programada"
                        class="text-emerald-600 border-gray-300 focus:ring-emerald-500" checked />
                    <span class="ml-2 text-gray-700">Programada</span>
                </label>

                <label class="inline-flex items-center">
                    <x-input type="radio" wire:model="forma_captura" value="referida"
                        class="text-emerald-600 border-gray-300 focus:ring-emerald-500" />
                    <span class="ml-2 text-gray-700">Referida</span>
                </label>
            </div>

            <!-- Campos principales -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <!-- Sede -->
                <div>
                    <x-label for="sede" value="Sede" />
                    <select id="sede" wire:model="sede"
                        class="mt-1 w-full border-gray-300 rounded-lg shadow-sm focus:ring-emerald-500 focus:border-emerald-500">
                        <option value="">-- Selecciona una opción --</option>
                        @foreach ($sedes as $s)
                            <option value="{{ $s->id }}">{{ $s->nombre }}</option>
                        @endforeach
                    </select>
                    @error('sede') <span class="text-sm text-red-600">{{ $message }}</span> @enderror
                </div>

                <!-- Tipo de sesión -->
                <div>
                    <x-label for="tipo_sesion" value="Tipo de sesión" />
                    <select id="tipo_sesion" wire:model="tipo_sesion"
                        class="mt-1 w-full border-gray-300 rounded-lg shadow-sm focus:ring-emerald-500 focus:border-emerald-500">
                        <option value="">-- Selecciona --</option>
                        @foreach ($tipo_sesiones as $t)
                            <option value="{{ $t->id }}">{{ $t->nombre }}</option>
                        @endforeach
                    </select>
                    @error('tipo_sesion') <span class="text-sm text-red-600">{{ $message }}</span> @enderror
                </div>

                <!-- Carácter de sesión -->
                <div>
                    <x-label for="caracter" value="Carácter de sesión" />
                    <select id="caracter" wire:model="caracter"
                        class="mt-1 w-full border-gray-300 rounded-lg shadow-sm focus:ring-emerald-500 focus:border-emerald-500">
                        <option value="">-- Selecciona --</option>
                        @foreach ($caracteres_sesiones as $c)
                            <option value="{{ $c->id }}">{{ $c->nombre }}</option>
                        @endforeach
                    </select>
                    @error('caracter') <span class="text-sm text-red-600">{{ $message }}</span> @enderror
                </div>
            </div>

            <!-- Fechas y horas -->
            <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mt-8">
                <!-- Fecha programada -->
                <div>
                    <x-ui.date-picker
                        label="Fecha programada"
                        wire:model.defer="fecha_programada"
                        :disable-past="true"
                    />
                    @error('fecha_programada') <span class="text-sm text-red-600">{{ $message }}</span> @enderror
                </div>

                <!-- Hora programada -->
                <div>
                    <x-label for="hora_programada" value="Hora programada" />
                    <x-input id="hora_programada" type="time" wire:model="hora_programada"
                        class="mt-1 w-full border-gray-300 rounded-lg shadow-sm focus:ring-emerald-500 focus:border-emerald-500" />
                    @error('hora_programada') <span class="text-sm text-red-600">{{ $message }}</span> @enderror
                </div>

                <!-- Hora término -->
                <div>
                    <x-label for="hora_termino" value="Hora estimada de término" />
                    <x-input id="hora_termino" type="time" wire:model="hora_termino"
                        class="mt-1 w-full border-gray-300 rounded-lg shadow-sm focus:ring-emerald-500 focus:border-emerald-500" />
                    @error('hora_termino') <span class="text-sm text-red-600">{{ $message }}</span> @enderror
                </div>

                <!-- Botón agregar receso -->
                <div class="flex flex-col justify-end">
                    <x-button type="button" wire:click="agregarReceso"
                        class="w-full bg-emerald-600 hover:bg-emerald-700 text-white justify-center">
                        Agregar Receso
                    </x-button>
                </div>
            </div>

            <!-- Botones -->
            <div class="flex justify-end space-x-4 mt-10">
                <x-button wire:click="continuar"
                    class="bg-emerald-600 hover:bg-emerald-700 text-white">
                    Continuar
                </x-button>

                <a href="{{ route('dashboard') }}"
                    class="inline-flex items-center px-5 py-2 rounded-md font-medium bg-gray-300 hover:bg-gray-400 text-gray-800 transition">
                    Cancelar
                </a>
            </div>

        </div>
    </div>
</div>
