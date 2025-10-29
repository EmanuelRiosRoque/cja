<x-app-layout>
     <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Adjuntar documento nuevo') }}
        </h2>
    </x-slot>

  <div class="min-h-screen overflow-y-auto">
  <div class="pt-2">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

      <livewire:sesion-adjuntar-documento
        :sesion="$sesion"
      />
    </div>
  </div>
</div>
</x-app-layout>
