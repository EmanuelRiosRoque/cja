<div 
    x-data="{ forma: 'programada' }"
    x-init="$watch('forma', value => $wire.set('forma_captura', value))"
    class="py-10"
>
  <div class="max-w-5xl mx-auto sm:px-6 lg:px-8">
    <div class="bg-white shadow-xl sm:rounded-lg p-8">

      @if (session('success'))
        <x-ui.alerts 
          type="success" 
          :message="session('success')" 
          timer="true"
          />
      @endif

      {{-- ======= Forma de captura ======= --}}
      <h3 class="text-lg font-semibold text-emerald-800 mb-6 border-b pb-2 text-left">
        Forma de captura
      </h3>

      @include('sesion.includes.opciones')

      {{-- ======= Bloque: Referida ======= --}}
      <div x-show="forma === 'referida'"  x-cloak>
        @include('sesion.includes.referidos')
      </div>

      {{-- ======= Bloque: Programada ======= --}}
      <div x-show="forma === 'programada'"  x-cloak>
        @include('sesion.includes.programada')
      </div>

    </div>
  </div>
</div>
