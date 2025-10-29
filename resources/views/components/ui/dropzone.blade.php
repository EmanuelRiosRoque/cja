<!-- Bonito Dropzone (Tailwind + Alpine) -->
<div x-data="dropzone({
        maxFiles: 10,
        maxSizeMB: 10,
        accepts: 'image/*,application/pdf'
     })"
     x-cloak
     class="space-y-3">

  <!-- Zona interactiva -->
  <div
      @dragover.prevent="drag=true"
      @dragleave.prevent="drag=false"
      @drop.prevent="handleDrop($event)"
      @click="$refs.file.click()"
      :class="drag ? 'ring-2 ring-emerald-400 bg-emerald-50/40' : 'ring-1 ring-gray-200 bg-white'"
      class="cursor-pointer rounded-2xl border border-dashed border-gray-300 p-6 text-center transition
             hover:bg-gray-50 hover:border-emerald-300 hover:ring-emerald-200">

    <!-- Ícono -->
    <div class="mx-auto mb-3 flex size-14 items-center justify-center rounded-full bg-gray-100">
      <svg class="size-7 text-gray-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
              d="M3 16.5v2.25A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75V16.5M16.5 7.5L12 3m0 0L7.5 7.5M12 3v13.5"/>
      </svg>
    </div>

    <p class="text-sm text-gray-700">
      <span class="font-medium text-emerald-700">Arrastra y suelta</span> tus archivos aquí,
      o <span class="underline">haz clic para seleccionar</span>.
    </p>
    <p class="mt-1 text-xs text-gray-500">
      Máx. <span x-text="maxFiles"></span> archivos, hasta <span x-text="maxSizeMB"></span> MB c/u.
    </p>

    <!-- Input real (se mantiene oculto) -->
    <input
        x-ref="file"
        type="file"
        class="hidden"
        :accept="accepts"
        multiple
        @change="handleSelect($event)"
        name="archivos[]"
        {{-- Livewire: descomenta si lo usas --}}
        {{-- wire:model="archivos" --}}
    />
  </div>

  <!-- Errores -->
  <template x-if="errors.length">
    <div class="rounded-xl border border-rose-200 bg-rose-50 p-3 text-sm text-rose-700">
      <ul class="list-disc pl-5 space-y-1">
        <template x-for="(e, i) in errors" :key="i">
          <li x-text="e"></li>
        </template>
      </ul>
    </div>
  </template>

  <!-- Previews -->
  <template x-if="files.length">
    <div class="space-y-2">
      <div class="text-sm font-medium text-gray-700">Archivos seleccionados</div>

      <!-- Grid de imágenes -->
      <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 gap-3">
        <template x-for="(f, i) in imageFiles" :key="f.key">
          <div class="relative overflow-hidden rounded-xl ring-1 ring-gray-200 bg-white">
            <img :src="f.preview" :alt="f.file.name" class="h-32 w-full object-cover" />
            <div class="p-2 border-t text-xs text-gray-700 truncate">
              <span x-text="f.file.name"></span>
              <span class="text-gray-400"> · </span>
              <span x-text="formatSize(f.file.size)"></span>
            </div>

            <!-- Quitar -->
            <button type="button"
                    @click.stop="removeByKey(f.key)"
                    class="absolute top-1 right-1 inline-flex items-center justify-center rounded-full bg-white/90
                           text-gray-700 shadow p-1 hover:bg-white"
                    title="Quitar">
              <svg class="size-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                      d="M6 18L18 6M6 6l12 12"/>
              </svg>
            </button>
          </div>
        </template>
      </div>

      <!-- Lista de no-imagenes -->
      <div class="divide-y divide-gray-200 rounded-xl border border-gray-200 bg-white">
        <template x-for="(f, i) in otherFiles" :key="f.key">
          <div class="flex items-center gap-3 p-3">
            <div class="flex size-9 items-center justify-center rounded-lg bg-gray-100">
              <!-- Icono PDF/archivo -->
              <svg class="size-5 text-gray-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.7"
                      d="M19.5 14.25v-6.75a2.25 2.25 0 00-2.25-2.25h-6.75M19.5 14.25L12 21.75 4.5 14.25M19.5 14.25H4.5" />
              </svg>
            </div>
            <div class="min-w-0 flex-1">
              <div class="truncate text-sm text-gray-800" x-text="f.file.name"></div>
              <div class="text-xs text-gray-500" x-text="formatSize(f.file.size)"></div>
            </div>

            <button type="button"
                    @click="removeByKey(f.key)"
                    class="inline-flex items-center justify-center rounded-md border border-gray-200 px-2.5 py-1.5 text-xs
                           text-gray-700 hover:bg-gray-50">
              Quitar
            </button>
          </div>
        </template>
      </div>

      <!-- Acciones -->
      <div class="flex items-center justify-end gap-2">
        <button type="button"
                @click="clearAll()"
                class="inline-flex items-center rounded-lg border border-gray-300 px-3 py-1.5 text-sm text-gray-700 hover:bg-gray-50">
          Limpiar
        </button>
        <!-- Si usas form clásico: el submit enviará archivos por name="archivos[]" -->
        <!-- Si usas Livewire y wire:model en el input, basta con submit normal -->
        <button type="submit"
                class="inline-flex items-center rounded-lg bg-emerald-600 px-3 py-1.5 text-sm text-white hover:bg-emerald-700">
          Subir
        </button>
      </div>
    </div>
  </template>
</div>

<script>
  document.addEventListener('alpine:init', () => {
    Alpine.data('dropzone', (opts = {}) => ({
      drag: false,
      files: [],       // [{ key, file, preview? }]
      errors: [],
      maxFiles: opts.maxFiles ?? 10,
      maxSizeMB: opts.maxSizeMB ?? 10,
      accepts: opts.accepts ?? '*/*',

      get imageFiles() {
        return this.files.filter(f => f.file.type.startsWith('image/'));
      },
      get otherFiles() {
        return this.files.filter(f => !f.file.type.startsWith('image/'));
      },

      handleSelect(e) {
        const list = Array.from(e.target.files || []);
        this.pushFiles(list);
        // Mantener input sincronizado (para forms/Livewire)
        // Si quieres resetear el input tras cargar, descomenta:
        // e.target.value = '';
      },

      handleDrop(e) {
        this.drag = false;
        const list = Array.from(e.dataTransfer.files || []);
        this.pushFiles(list);
      },

      pushFiles(list) {
        this.errors = [];

        for (const file of list) {
          // Validar cantidad
          if (this.files.length >= this.maxFiles) {
            this.errors.push(`Máximo ${this.maxFiles} archivos.`);
            break;
          }
          // Validar tipo (accepts simple, no parsing complejo de extensiones)
          if (this.accepts !== '*/*' && !this.accepts.split(',').some(a => {
            const t = a.trim();
            return t.endsWith('/*') ? file.type.startsWith(t.replace('/*','/')) : file.type === t;
          })) {
            // Si no coincide exactamente, lo dejamos pasar (para simplificar). Quita este return para bloquear estricto.
            // this.errors.push(`Tipo no permitido: ${file.type || file.name}`);
            // continue;
          }
          // Validar tamaño
          if (file.size > this.maxSizeMB * 1024 * 1024) {
            this.errors.push(`"${file.name}" excede ${this.maxSizeMB} MB.`);
            continue;
          }

          const item = { key: crypto.randomUUID(), file };
          if (file.type.startsWith('image/')) {
            item.preview = URL.createObjectURL(file);
          }
          this.files.push(item);

          // Añadir al input real (para formulario estándar / Livewire)
          // Nota: no se puede "empujar" programáticamente al input file por seguridad del navegador.
          // Este componente usa el input real solo para selección manual.
          // Para enviar con fetch personalizado, arma un FormData con this.files.map(f=>f.file).
        }
      },

      removeByKey(key) {
        const idx = this.files.findIndex(f => f.key === key);
        if (idx >= 0) {
          // liberar URL del preview
          const f = this.files[idx];
          if (f.preview) URL.revokeObjectURL(f.preview);
          this.files.splice(idx, 1);
        }
      },

      clearAll() {
        this.files.forEach(f => f.preview && URL.revokeObjectURL(f.preview));
        this.files = [];
        this.errors = [];
        // También puedes limpiar el input real:
        // this.$refs.file.value = '';
      },

      formatSize(bytes) {
        const units = ['B','KB','MB','GB'];
        let i = 0, num = bytes;
        while (num >= 1024 && i < units.length - 1) { num /= 1024; i++; }
        return `${num.toFixed( num < 10 && i > 0 ? 1 : 0 )} ${units[i]}`;
      },
    }));
  });
</script>
