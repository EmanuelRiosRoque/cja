<div class="space-y-8 p-8 bg-white shadow-md rounded-2xl border border-gray-100">
    {{-- Mensaje de éxito --}}
    @if (session('success'))
        <x-ui.alerts type="success" :message="session('success')" timer="true" />
    @endif

    {{-- Encabezado --}}
    @include('sesion.includes.orden-dia.encabezado')

    {{-- Cuerpo principal --}}
    <div class="text-center">
        <h3 class="text-lg font-semibold text-gray-800 mb-4">
            Finalizar proyecto de orden del día
        </h3>

        {{-- Bloque de advertencia --}}
        <div class="flex items-start justify-center bg-amber-50 border border-amber-300 text-amber-800 px-4 py-3 rounded-lg max-w-2xl mx-auto">
            <svg xmlns="http://www.w3.org/2000/svg" 
                 fill="none" 
                 viewBox="0 0 24 24" 
                 stroke-width="1.5" 
                 stroke="currentColor" 
                 class="w-6 h-6 mr-3 text-amber-600 mt-0.5 flex-shrink-0">
                <path stroke-linecap="round" stroke-linejoin="round" 
                    d="M12 9v3.75m0 3.75h.008M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
            </svg>
            <p class="text-sm text-left leading-relaxed">
                <span class="font-semibold">Advertencia:</span> 
                al finalizar este proyecto, el orden del día quedará visible para todos los integrantes de las ponencias. 
                Asegúrate de haber revisado toda la información antes de continuar.
            </p>
        </div>

        {{-- Botones de acción --}}
        <div class="flex justify-center gap-4 mt-6">
            <x-button 
                href="{{ route('sesion.index') }}"
                variant="secondary"
                as="a"
                class="!px-5 !py-2.5"
            >
                Cancelar
            </x-button>

            <x-button
                variant="primary"
                class="!px-5 !py-2.5 bg-emerald-600 hover:bg-emerald-700 text-white font-medium rounded-md shadow-sm transition-colors"
            >
                Terminar orden
            </x-button>
        </div>
    </div>
</div>
