    <form wire:submit.prevent="guardarTema" class="space-y-4">
        <div class="grid grid-cols-1 md:grid-cols-5 gap-4 items-start border p-4 rounded-lg bg-gray-50">
            {{-- Número de tema --}}
            <div class="col-span-1 text-center font-bold text-gray-700">
                {{ $numero_tema ?? 1 }}
                @if ($editando_id)
                <div class="text-[11px] text-amber-600 font-normal mt-1">Editando</div>
                @endif
            </div>

            <div class="col-span-4 space-y-3">

                {{-- Presentación del tema (múltiples selects) --}}
                <div>
                    <label class="text-sm font-medium text-gray-600">Presentación del Tema</label>

                    @foreach ($presentadoresSeleccionados as $index => $presentador_id)
                    <div class="flex items-center gap-2 mb-2">
                        <select wire:model="presentadoresSeleccionados.{{ $index }}"
                            class="w-full border-gray-300 rounded-md">
                            <option value="">-- Selecciona una opción --</option>
                            @foreach ($presentadores as $presentador)
                            <option value="{{ $presentador->id }}">
                                {{ $presentador->nombre }}{{ $presentador->cargo ? ' - '.$presentador->cargo : '' }}
                            </option>
                            @endforeach
                        </select>

                        @if (count($presentadoresSeleccionados) > 1)
                        <button type="button" wire:click="eliminarPresentador({{ $index }})"
                            class="text-red-600 hover:text-red-800 text-sm" title="Quitar">
                            X
                        </button>
                        @endif
                    </div>
                    @endforeach

                    <div>
                        <button type="button" wire:click="agregarPresentador"
                            class="text-emerald-600 text-sm hover:underline">
                            + Agregar otro presentador
                        </button>
                    </div>

                    {{-- errores de presentadores --}}
                    @error('presentadoresSeleccionados.*')
                    <p class="text-xs text-red-600 mt-1">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Descripción --}}
                <div>
                    <div>
                        <label class="text-sm font-medium text-gray-600">Descripción del Tema</label>

                        <select wire:model="es_asunto_adicional" class="w-full border-gray-300 rounded-md">
                            <option value="">-- Selecciona una opción --</option>
                            <option value="0">Introducir texto para orden del día</option>
                            <option value="1">Asuntos adicionales</option>
                        </select>
                        @error('es_asunto_adicional')
                        <p class="text-xs text-red-600 mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <label class="text-sm font-medium text-gray-600">Descripción del Tema</label>
                    <textarea wire:model="descripcion" rows="2" class="w-full border-gray-300 rounded-md"></textarea>
                    @error('descripcion')
                    <p class="text-xs text-red-600 mt-1">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Documento --}}
                <div 
                    x-data="{ forma: '0' }"
                    x-on:reset-dropzone-forma.window="forma = '0'; $wire.set('documentos', []);"
                >
                    <h3>Agregar documento</h3>

                    <div class="flex items-center space-x-6 mb-6">
                        <label class="inline-flex items-center">
                        <input type="radio" value="1" x-model="forma"
                                class="text-emerald-600 border-gray-300 focus:ring-emerald-500">
                        <span class="ml-2 text-gray-700">Sí</span>
                        </label>

                        <label class="inline-flex items-center">
                        <input type="radio" value="0" x-model="forma"
                                class="text-emerald-600 border-gray-300 focus:ring-emerald-500">
                        <span class="ml-2 text-gray-700">No</span>
                        </label>
                    </div>

                    <!-- Limpia documentos cuando eligen NO -->
                    <div x-effect="if (forma === '0') { $wire.set('documentos', []); }"></div>

                    <!-- Dropzone solo si forma === '1' -->
                    <div x-cloak x-show="forma === '1'" x-transition.opacity.duration.200ms>
                        <livewire:ui.dropzone 
                        wire:model="documentos" 
                        :label="'Documentos:'" 
                        :multiple="true"
                        accept=".pdf,.docx" 
                        />
                    </div>
                </div>

                {{-- Botones --}}
                <div class="flex gap-2 justify-end pt-2">
                    <x-button type="button" wire:click="cancelar" variant="secondary">
                        Cancelar
                    </x-button>

                    <x-button type="submit" variant="primary">
                        Agregar
                    </x-button>
                </div>
            </div>
        </div>
    </form>