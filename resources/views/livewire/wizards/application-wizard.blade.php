<div x-data="{ step: @entangle('step').live }" class="max-w-3xl mx-auto p-4 sm:p-6 space-y-6">
  <style>[x-cloak]{display:none!important}</style>

{{-- PROGRESO --}}
<div class="space-y-3">
  {{-- Etiquetas de pasos --}}
  <ol class="flex items-center justify-between text-xs sm:text-sm font-medium">
    <li :class="step>=1 ? 'text-emerald-700' : 'text-neutral-500'">
      <span class="inline-flex items-center gap-2">
        <span class="w-5 h-5 rounded-full grid place-items-center border"
              :class="step>1 ? 'bg-emerald-600 text-white border-emerald-600' :
                               (step===1 ? 'bg-emerald-50 text-emerald-700 border-emerald-300' : 'bg-white text-neutral-400 border-neutral-300')">1</span>
        <span> Básicos</span>
      </span>
    </li>
    <li :class="step>=2 ? 'text-emerald-700' : 'text-neutral-500'">
      <span class="inline-flex items-center gap-2">
        <span class="w-5 h-5 rounded-full grid place-items-center border"
              :class="step>2 ? 'bg-emerald-600 text-white border-emerald-600' :
                               (step===2 ? 'bg-emerald-50 text-emerald-700 border-emerald-300' : 'bg-white text-neutral-400 border-neutral-300')">2</span>
        <span> Identidad</span>
      </span>
    </li>
    <li :class="step>=3 ? 'text-emerald-700' : 'text-neutral-500'">
      <span class="inline-flex items-center gap-2">
        <span class="w-5 h-5 rounded-full grid place-items-center border"
              :class="step>3 ? 'bg-emerald-600 text-white border-emerald-600' :
                               (step===3 ? 'bg-emerald-50 text-emerald-700 border-emerald-300' : 'bg-white text-neutral-400 border-neutral-300')">3</span>
        <span> Mensaje</span>
      </span>
    </li>
    <li :class="step>=4 ? 'text-emerald-700' : 'text-neutral-500'">
      <span class="inline-flex items-center gap-2">
        <span class="w-5 h-5 rounded-full grid place-items-center border"
              :class="step===4 ? 'bg-emerald-50 text-emerald-700 border-emerald-300' : 'bg-white text-neutral-400 border-neutral-300'">4</span>
        <span> Adjuntos</span>
      </span>
    </li>
  </ol>

  {{-- Barra de progreso --}}
  <div class="h-2 rounded-full bg-neutral-200 overflow-hidden" role="progressbar"
       :aria-valuenow="step*25" aria-valuemin="0" aria-valuemax="100">
    <div class="h-full bg-emerald-600 transition-all duration-300"
         :style="`width: ${Math.min(step*25,100)}%`"></div>
  </div>

  {{-- Texto porcentaje (opcional) --}}
  <div class="text-right text-xs text-neutral-500">
    <span x-text="`${Math.min(step*25,100)}% completado`"></span>
  </div>
</div>

  {{-- PASO 1 --}}
  <div x-show="step===1" class="space-y-2" x-cloak>
    <livewire:wizards.steps.basic-info wire:model="basic" wire:key="step-basic"/>
    <div class="flex justify-end">
      <button type="button" class="px-3 py-2 rounded bg-emerald-600 text-white hover:bg-emerald-700"
              wire:click="next" wire:loading.attr="disabled" wire:target="next">Siguiente</button>
    </div>
  </div>

  {{-- PASO 2 --}}
  <div x-show="step===2" class="space-y-2" x-cloak>
    @if ($basic['materia']==='civil')
      <livewire:wizards.steps.applicant wire:model="person" wire:key="step-person"/>
    @endif
   
    <div class="flex justify-between">
      <button type="button" class="px-3 py-2 rounded bg-neutral-200 text-neutral-800 hover:bg-neutral-300"
              wire:click="back" wire:loading.attr="disabled" wire:target="back">Atrás</button>
      <button type="button" class="px-3 py-2 rounded bg-emerald-600 text-white hover:bg-emerald-700"
              wire:click="next" wire:loading.attr="disabled" wire:target="next">Siguiente</button>
    </div>
  </div>


</div>
