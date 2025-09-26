<div class="space-y-4">
    <div class="grid grid-cols-1 md:grid-cols-3 place-items-start gap-6">
        {{-- Modalidad --}}
        <fieldset class="space-y-2">
            <legend class="text-sm font-semibold">Modalidad</legend>
            <div class="flex flex-col gap-2">
                <label class="inline-flex items-center gap-2">
                    <input type="radio" class="rounded border-neutral-300"
                           wire:model="form.modalidad" value="linea">
                    <span class="text-sm">En línea</span>
                </label>
                <label class="inline-flex items-center gap-2">
                    <input type="radio" class="rounded border-neutral-300"
                           wire:model="form.modalidad" value="presencial">
                    <span class="text-sm">Presencial</span>
                </label>
            </div>
            @error('basic.modalidad') <p class="text-xs text-red-600 mt-1">{{ $message }}</p> @enderror
        </fieldset>

        {{-- Materia --}}
        <fieldset class="space-y-2">
            <legend class="text-sm font-semibold">Materia</legend>
            <div class="flex flex-col gap-2">
                <label class="inline-flex items-center gap-2">
                    <input type="radio" class="rounded border-neutral-300"
                           wire:model="form.materia" value="civil"
                           wire:change="$dispatch('materia-changed', { materia: 'civil' })">
                    <span class="text-sm">Civil</span>
                </label>
                <label class="inline-flex items-center gap-2">
                    <input type="radio" class="rounded border-neutral-300"
                           wire:model="form.materia" value="mercantil"
                           wire:change="$dispatch('materia-changed', { materia: 'mercantil' })">
                    <span class="text-sm">Mercantil</span>
                </label>
                <label class="inline-flex items-center gap-2">
                    <input type="radio" class="rounded border-neutral-300"
                           wire:model="form.materia" value="familiar"
                           wire:change="$dispatch('materia-changed', { materia: 'familiar' })">
                    <span class="text-sm">Familiar</span>
                </label>
            </div>
            @error('basic.materia') <p class="text-xs text-red-600 mt-1">{{ $message }}</p> @enderror
        </fieldset>

        {{-- ¿Canalizado? --}}
        <fieldset class="space-y-2">
            <legend class="text-sm font-semibold">¿Canalizado?</legend>
            <div class="flex flex-col gap-2">
                <label class="inline-flex items-center gap-2">
                    <input type="radio" class="rounded border-neutral-300"
                           wire:model="form.canalizado" value="1">
                    <span class="text-sm">Sí</span>
                </label>
                <label class="inline-flex items-center gap-2">
                    <input type="radio" class="rounded border-neutral-300"
                           wire:model="form.canalizado" value="0">
                    <span class="text-sm">No</span>
                </label>
            </div>
            @error('basic.canalizado') <p class="text-xs text-red-600 mt-1">{{ $message }}</p> @enderror
        </fieldset>
    </div>

    {{-- Ticket (solo si modalidad = línea) --}}
    <div x-data x-show="$wire.form.modalidad == 'linea'" x-collapse x-cloak>
        <label class="block text-sm font-medium text-neutral-700"># Ticket</label>
        <input type="number" min="1" step="1" placeholder="Ej. 12345"
               wire:model.defer="form.ticket"
               class="mt-1 w-full rounded-md border-neutral-300 focus:border-neutral-500 focus:ring-neutral-500" />
        @error('basic.ticket') <p class="text-xs text-red-600 mt-1">{{ $message }}</p> @enderror
    </div>

    {{-- Institución + Dropzone (solo si canalizado = 1) --}}
    <div x-data x-show="$wire.form.canalizado == '1'" x-collapse x-cloak>
        <div class="space-y-4">
            <label class="block text-sm font-medium text-neutral-700">Institución</label>
            <select wire:model.defer="form.institucion" class="w-full rounded-md border-neutral-300">
                <option value="">--Seleccione--</option>
                <option value="Fiscalía">Fiscalía</option>
                <option value="Juzgado">Juzgado</option>
                <option value="CDH">Comisión de Derechos Humanos de la CDMX</option>
                <option value="LUNAS">Secretaría de Mujeres (LUNAS)</option>
                <option value="Registro Civil">Juzgado de Registro Civil</option>
                <option value="Otro">Otro</option>
            </select>
            @error('basic.institucion') <p class="text-xs text-red-600 mt-1">{{ $message }}</p> @enderror

            <livewire:ui.dropzone wire:model="form.attachments" :multiple="true"
                                  accept=".pdf,.jpg,.jpeg,.png" />
            @error('basic.attachments') <p class="text-xs text-red-600 mt-1">{{ $message }}</p> @enderror
            @error('basic.attachments.*') <p class="text-xs text-red-600 mt-1">{{ $message }}</p> @enderror
        </div>
    </div>
</div>
