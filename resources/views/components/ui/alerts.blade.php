@props([
    'type' => 'info', 
    'title' => null,
    'message' => null,
    'timer' => false,    {{-- true = se cierra solo --}}
    'timeout' => 5000,   {{-- milisegundos --}}
])

@php
    $styles = [
        'success' => 'bg-green-100 text-green-700 border-green-300',
        'error'   => 'bg-red-100 text-red-700 border-red-300',
        'warning' => 'bg-yellow-100 text-yellow-700 border-yellow-300',
        'info'    => 'bg-blue-100 text-blue-700 border-blue-300',
    ];

    $titles = [
        'success' => 'Éxito',
        'error'   => 'Error',
        'warning' => 'Advertencia',
        'info'    => 'Información',
    ];

    $color = $styles[$type] ?? $styles['info'];
    $title = $title ?? $titles[$type];
@endphp

<div
    x-data="{
        show: true,
        timerEnabled: {{ $timer ? 'true' : 'false' }},
        timeout: {{ $timeout }},
        restart() {
            this.show = true;
            if (this.timerEnabled) {
                clearTimeout(this._t);
                this._t = setTimeout(() => this.show = false, this.timeout);
            }
        }
    }"
    x-init="restart()"
    x-effect="restart()" 
    x-show="show"
    x-transition.opacity.duration.400ms
    class="flex items-center justify-between {{ $color }} rounded-lg p-4 mb-4 text-sm border shadow-sm"
    role="alert"
>
    <!-- Contenido principal -->
    <div class="flex items-center space-x-3">
        <svg class="w-5 h-5 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
            @if($type === 'success')
                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.707a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
            @elseif($type === 'error')
                <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10 7.293 11.293a1 1 0 001.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"></path>
            @elseif($type === 'warning')
                <path fill-rule="evenodd" d="M10 2a8 8 0 100 16 8 8 0 000-16zM9 8h2v4H9V8zm0 6h2v2H9v-2z" clip-rule="evenodd"></path>
            @else
                <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"></path>
            @endif
        </svg>

        <div>
            <span class="font-semibold">{{ $title }}:</span>
            {{ $message ?? $slot }}
        </div>
    </div>

    <!-- Botón de cierre -->
    <button 
        @click="show = false"
        class="text-current hover:opacity-70 focus:outline-none ml-4"
        aria-label="Cerrar"
    >
        ✕
    </button>
</div>
