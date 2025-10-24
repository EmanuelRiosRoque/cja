@props([
  'label' => null,
  'name' => null,                 // opcional: para POST clásico (agrega hidden con name)
  'value' => null,                // YYYY-MM-DD valor inicial si NO usas wire:model
  'placeholder' => 'Selecciona fecha',

  // Config
  'firstDay' => 1,                // 1 = Lunes
  'min' => null,                  // YYYY-MM-DD
  'max' => null,                  // YYYY-MM-DD
  'disabledDates' => [],          // ['2025-10-31', ...]
  'disabledDaysOfWeek' => [],     // [0..6] 0=Dom
  'disablePast' => false,         // ⬅️ NUEVO: true = no permitir días pasados
])

@php
  // Extrae cualquier wire:model(.defer/.live) del USO del componente
  $wireModelAttr =
      $attributes->get('wire:model')
      ?? $attributes->get('wire:model.defer')
      ?? $attributes->get('wire:model.live');

  // Para validación/claves de error
  $errorKey = $name ?: $wireModelAttr;
@endphp

<div
  {{ $attributes->except(['wire:model','wire:model.live','wire:model.defer'])->merge(['class' => 'relative']) }}
  x-data="dpLivewire({
    initial: @json($value),
    min: @json($min),
    max: @json($max),
    disabled: @json($disabledDates),
    disabledDows: @json($disabledDaysOfWeek),
    firstDay: @json((int)$firstDay),
    disablePast: @json((bool)$disablePast),     // ⬅️ pasa la config a Alpine
  })"
  x-id="['dp']"
>
  @if($label)
    <label :for="$id('dp')" class="block text-sm font-medium text-neutral-700 mb-1">
      {{ $label }}
    </label>
  @endif

  <div class="relative">
    {{-- Input visible (solo lectura) --}}
    <input
      x-ref="input"
      :id="$id('dp')"
      type="text"
      x-model="display"
      readonly
      autocomplete="off"
      @mousedown.prevent.stop="open()"
      @click.prevent.stop="open()"
      @focus="open()"
      @keydown.enter.prevent.stop
      @keydown.space.prevent.stop
      placeholder="{{ $placeholder }}"
      class="h-10 rounded-md border border-neutral-300 px-3 pr-10 w-full
             focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500">

    {{-- Icono/calendario --}}
    <button type="button"
      class="absolute inset-y-0 right-0 px-2 text-neutral-500 hover:text-emerald-600"
      @mousedown.prevent.stop="toggle()" @click.prevent.stop="toggle()"
      aria-label="Abrir calendario">
      <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
              d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 0 0 2-2V7a2 2 0 0 0-2-2H5a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2z"/>
      </svg>
    </button>

    {{-- Hidden que SINCRONIZA con Livewire (coloca aquí el wire:model del USO) --}}
    <input
      type="hidden"
      x-model="value"
      {{ $attributes->whereStartsWith('wire:model') }}
      @change.window="
        display = (typeof value==='string' && /^\d{4}-\d{2}-\d{2}$/.test(value)) ? formatDisplay(value) : ''
      "
      @input="
        display = (typeof value==='string' && /^\d{4}-\d{2}-\d{2}$/.test(value)) ? formatDisplay(value) : ''
      "
      @dp:set.window="value = $event.detail; display = formatDisplay($event.detail)"
      @dp:clear.window="value = null; display='';"
      @if($name) name="{{ $name }}" @endif
    >
  </div>

  @if($errorKey)
    @error($errorKey)
      <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
    @enderror
  @endif

  {{-- Overlay --}}
  <div x-show="isOpen" x-transition.opacity x-cloak
       @keydown.escape.window="close()" @click="close()"
       class="fixed inset-0 z-[9998]"></div>

  {{-- Panel (aislado de Livewire) --}}
  <div x-show="isOpen" x-transition x-cloak
       @click.stop
       wire:ignore
       class="fixed z-[9999] w-[20rem] bg-white rounded-2xl shadow-xl ring-1 ring-neutral-200"
       x-ref="panel" :style="panelStyle">

    <div class="relative px-3 pt-3 pb-2">
      <div class="flex items-center justify-between">
        <div class="flex items-center gap-2">
          <button type="button" @click="toggleYearList()"
            class="inline-flex items-center gap-1 px-2 py-1 rounded-md hover:bg-neutral-100 text-neutral-800">
            <span class="font-medium" x-text="year"></span>
            <svg class="w-4 h-4 text-neutral-500" viewBox="0 0 20 20" fill="currentColor">
              <path fill-rule="evenodd" d="M5.23 7.21a.75.75 0 011.06.02L10 11.11l3.71-3.88a.75.75 0 011.08 1.04l-4.25 4.45a.75.75 0 01-1.08 0L5.21 8.27a.75.75 0 01.02-1.06z" clip-rule="evenodd"/>
            </svg>
          </button>

          <button type="button" @click="toggleMonthList()"
            class="inline-flex items-center gap-1 px-2 py-1 rounded-md hover:bg-neutral-100 text-neutral-800">
            <span class="font-medium" x-text="months[month]"></span>
            <svg class="w-4 h-4 text-neutral-500" viewBox="0 0 20 20" fill="currentColor">
              <path fill-rule="evenodd" d="M5.23 7.21a.75.75 0 011.06.02L10 11.11l3.71-3.88a.75.75 0 011.08 1.04l-4.25 4.45a.75.75 0 01-1.08 0L5.21 8.27a.75.75 0 01.02-1.06z" clip-rule="evenodd"/>
            </svg>
          </button>
        </div>

        <div class="flex items-center gap-2">
          <button @click="prevMonth()" class="p-1 rounded hover:bg-neutral-100" aria-label="Mes anterior">
            <svg class="w-5 h-5 text-neutral-600" viewBox="0 0 24 24" fill="none" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M15 19l-7-7 7-7"/></svg>
          </button>
          <button @click="selectToday()" class="p-1" aria-label="Hoy">
            <span class="block w-2.5 h-2.5 rounded-full bg-neutral-400 hover:bg-emerald-500"></span>
          </button>
          <button @click="nextMonth()" class="p-1 rounded hover:bg-neutral-100" aria-label="Mes siguiente">
            <svg class="w-5 h-5 text-neutral-600" viewBox="0 0 24 24" fill="none" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 5l7 7-7 7"/></svg>
          </button>
        </div>
      </div>

      {{-- Popovers año/mes --}}
      <div x-show="showYears" x-transition x-cloak
           class="absolute z-10 mt-2 w-24 max-h-56 overflow-auto bg-white border border-neutral-200 rounded-xl shadow"
           style="left:.25rem;">
        <template x-for="y in years" :key="'y'+y">
          <button type="button" @click="selectYear(y)"
            class="w-full text-left px-3 py-1.5 hover:bg-neutral-100"
            :class="{'text-emerald-600 font-semibold': y===year}"
            x-text="y"></button>
        </template>
      </div>

      <div x-show="showMonths" x-transition x-cloak
           class="absolute z-10 mt-2 w-36 max-h-56 overflow-auto bg-white border border-neutral-200 rounded-xl shadow"
           style="left:5.5rem;">
        <template x-for="(m,idx) in months" :key="'m'+idx">
          <button type="button" @click="selectMonth(idx)"
            class="w-full text-left px-3 py-1.5 hover:bg-neutral-100"
            :class="{'text-emerald-600 font-semibold': idx===month}"
            x-text="m"></button>
        </template>
      </div>
    </div>

    {{-- Encabezados --}}
    <div class="grid grid-cols-7 gap-1 px-3 text-[11px] font-medium text-neutral-500">
      <template x-for="d in weekdaysOrdered" :key="d"><div class="text-center py-1" x-text="d"></div></template>
    </div>

    {{-- Días --}}
    <div class="grid grid-cols-7 gap-1 p-3 pt-2">
      <template x-for="_ in blanks"><div></div></template>
      <template x-for="day in daysInThisMonth" :key="day">
        <button type="button" @click="select(day)" :disabled="isDisabled(day)"
          class="h-9 w-9 mx-auto rounded-full text-sm hover:bg-emerald-50 disabled:opacity-40 disabled:cursor-not-allowed
                 focus:outline-none focus:ring-2 focus:ring-emerald-500"
          :class="{
            'bg-emerald-600 text-white hover:bg-emerald-600': isSelected(day),
            'ring-2 ring-emerald-500': isToday(day) && !isSelected(day)
          }"
          x-text="day"></button>
      </template>
    </div>
  </div>
</div>

@once
<script>
document.addEventListener('alpine:init', () => {
  Alpine.data('dpLivewire', (opts = {}) => ({
    // Estado
    value: opts.initial || null,      // YYYY-MM-DD
    display: '',
    isOpen: false,
    year: 0,
    month: 0,
    panelStyle: '',
    min: opts.min ? new Date(opts.min) : null,
    max: opts.max ? new Date(opts.max) : null,
    disabledSet: new Set((opts.disabled || []).map(String)),
    disabledDows: new Set(opts.disabledDows || []),
    firstDay: Number.isInteger(opts.firstDay) ? opts.firstDay : 1,
    disablePast: !!opts.disablePast,                          // ⬅️ NUEVO en estado

    showYears: false,
    showMonths: false,

    months: ['enero','febrero','marzo','abril','mayo','junio','julio','agosto','septiembre','octubre','noviembre','diciembre'],
    weekdays: ['DOM','LUN','MAR','MIÉ','JUE','VIE','SÁB'],
    get weekdaysOrdered(){ return [...this.weekdays.slice(this.firstDay), ...this.weekdays.slice(0, this.firstDay)]; },
    years: (() => { const now=new Date().getFullYear(), s=now-80, e=now+20; return Array.from({length:e-s+1},(_,i)=>s+i); })(),

    get daysInThisMonth(){ return new Date(this.year, this.month + 1, 0).getDate(); },
    get blanks(){
      const first = new Date(this.year, this.month, 1).getDay();
      const offset = (first - this.firstDay + 7) % 7;
      return Array(offset).fill(0);
    },

    init(){
      const iso = (typeof this.value === 'string' && /^\d{4}-\d{2}-\d{2}$/.test(this.value)) ? this.value : null;
      const base = iso ? new Date(iso + 'T00:00:00') : new Date();
      this.year = base.getFullYear();
      this.month = base.getMonth();
      this.display = iso ? this.formatDisplay(iso) : '';

      this.$watch('value', (v) => {
        if (typeof v === 'string' && /^\d{4}-\d{2}-\d{2}$/.test(v)) {
          this.display = this.formatDisplay(v);
        } else if (!v) {
          this.display = '';
        }
      });
    },

    // Abrir / cerrar
    open(){ this.isOpen = true; this.$nextTick(() => this.updatePanelPosition()); window.addEventListener('resize', this.updatePanelPosition); window.addEventListener('scroll', this.updatePanelPosition, true); },
    close(){ this.isOpen = false; this.showYears = false; this.showMonths = false; window.removeEventListener('resize', this.updatePanelPosition); window.removeEventListener('scroll', this.updatePanelPosition, true); },
    toggle(){ this.isOpen ? this.close() : this.open(); },

    updatePanelPosition(){
      const r = this.$refs.input.getBoundingClientRect();
      const gap=6, top = r.bottom + window.scrollY + gap;
      let left = r.left + window.scrollX;
      const panel = this.$refs.panel, panelW = panel ? panel.offsetWidth : 320;
      const vw = window.innerWidth + window.scrollX;
      if (left + panelW > vw - 8) left = vw - panelW - 8;
      this.panelStyle = `top:${top}px;left:${left}px;width:${panelW}px`;
    },

    // Header
    prevMonth(){ this.month--; if (this.month < 0) { this.month=11; this.year--; } },
    nextMonth(){ this.month++; if (this.month > 11){ this.month=0;  this.year++; } },
    selectToday(){
      const t = new Date();
      const iso = `${t.getFullYear()}-${String(t.getMonth()+1).padStart(2,'0')}-${String(t.getDate()).padStart(2,'0')}`;
      this.year = t.getFullYear(); this.month = t.getMonth();
      if (!this.isDateDisabled(iso)) this.apply(iso);
    },

    toggleYearList(){ this.showYears = !this.showYears; if (this.showYears) this.showMonths = false; },
    toggleMonthList(){ this.showMonths = !this.showMonths; if (this.showMonths) this.showYears = false; },
    selectYear(y){ this.year = y; this.showYears = false; },
    selectMonth(m){ this.month = m; this.showMonths = false; },

    // Utilidades
    isToday(day){ const t=new Date(); return day===t.getDate()&&this.month===t.getMonth()&&this.year===t.getFullYear(); },
    isSelected(day){
      if (!this.value || typeof this.value !== 'string') return false;
      const d = new Date(this.value + 'T00:00:00');
      return !isNaN(d) && day===d.getDate() && this.month===d.getMonth() && this.year===d.getFullYear();
    },

    isDateDisabled(iso){
      const dt = new Date(iso + 'T00:00:00');

      // min / max
      if (this.min && dt < new Date(this.min.getFullYear(), this.min.getMonth(), this.min.getDate())) return true;
      if (this.max && dt > new Date(this.max.getFullYear(), this.max.getMonth(), this.max.getDate())) return true;

      // ⬅️ NUEVO: bloquear fechas pasadas respecto a hoy
      if (this.disablePast) {
        const today = new Date();
        const todayStart = new Date(today.getFullYear(), today.getMonth(), today.getDate());
        if (dt < todayStart) return true;
      }

      // días de semana
      if (this.disabledDows.size && this.disabledDows.has(dt.getDay())) return true;

      // fechas exactas
      if (this.disabledSet.has(iso)) return true;

      return false;
    },
    isDisabled(day){ return this.isDateDisabled(this.isoOf(day)); },

    select(day){
      const iso = this.isoOf(day);
      if (this.isDateDisabled(iso)) return;
      this.apply(iso);
    },

    apply(iso){
      this.value = iso;                         // x-model -> hidden (Livewire lo recoge)
      this.display = this.formatDisplay(iso);   // texto legible
      this.$dispatch('change', { value: iso }); // evento opcional
      this.close();
    },

    isoOf(day){ const m=String(this.month+1).padStart(2,'0'); const d=String(day).padStart(2,'0'); return `${this.year}-${m}-${d}`; },
    formatDisplay(iso){ const [y,m,d]=iso.split('-'); return `${d}/${m}/${y}`; },
  }));
});
</script>
@endonce
