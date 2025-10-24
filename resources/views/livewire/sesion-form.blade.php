<div class="py-10">
    <div class="max-w-5xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white shadow-xl sm:rounded-lg p-8">

            <!-- Sección: Forma de captura -->
            <h3 class="text-lg font-semibold text-emerald-800 mb-6 border-b pb-2 text-left">
                Forma de captura
            </h3>

            <div class="flex items-center space-x-6 mb-8">
                <label class="inline-flex items-center">
                    <input type="radio" wire:model="forma_captura" value="programada"
                           class="text-emerald-600 border-gray-300 focus:ring-emerald-500" checked>
                    <span class="ml-2 text-gray-700">Programada</span>
                </label>
                <label class="inline-flex items-center">
                    <input type="radio" wire:model="forma_captura" value="referida"
                           class="text-emerald-600 border-gray-300 focus:ring-emerald-500">
                    <span class="ml-2 text-gray-700">Referida</span>
                </label>
            </div>

            <!-- Campos principales -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Sede</label>
                    <select wire:model="sede"
                            class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-emerald-500 focus:border-emerald-500">
                        <option value="">-- Selecciona una opción --</option>
                        <option value="civil">Pleno Civil</option>
                        <option value="penal">Pleno Penal</option>
                    </select>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Tipo de sesión</label>
                    <select wire:model="tipo_sesion"
                            class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-emerald-500 focus:border-emerald-500">
                        <option value="">-- Selecciona --</option>
                        <option value="ordinaria">Ordinaria</option>
                        <option value="extraordinaria">Extraordinaria</option>
                    </select>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Carácter de sesión</label>
                    <select wire:model="caracter"
                            class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-emerald-500 focus:border-emerald-500">
                        <option value="">-- Selecciona --</option>
                        <option value="publica">Pública</option>
                        <option value="privada">Privada</option>
                    </select>
                </div>
            </div>

            <!-- Fechas y horas -->
            <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mt-8">
                <div>
                    <x-ui.date-picker
                        label="Fecha"
                        wire:model.defer="fecha_programada"  
                        :disable-past="true"
                    />
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Hora programada</label>
                    <input type="time" wire:model="hora_programada"
                           class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-emerald-500 focus:border-emerald-500">
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Hora estimada de término</label>
                    <input type="time" wire:model="hora_termino"
                           class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-emerald-500 focus:border-emerald-500">
                </div>

                <div class="flex flex-col justify-end">
                    <button type="button"
                            wire:click="agregarReceso"
                            class="inline-flex items-center justify-center w-full bg-emerald-600 text-white py-2 px-3 rounded-md hover:bg-emerald-700 transition">
                        Agregar Receso
                    </button>
                </div>
            </div>

            <!-- Botones -->
            <div class="flex justify-end space-x-4 mt-10">
                <button wire:click="continuar"
                        class="bg-emerald-600 hover:bg-emerald-700 text-white px-5 py-2 rounded-md font-semibold transition">
                    Continuar
                </button>
                <button wire:click="cancelar"
                        class="bg-gray-300 hover:bg-gray-400 text-gray-800 px-5 py-2 rounded-md font-semibold transition">
                    Cancelar
                </button>
            </div>
        </div>
    </div>
</div>
