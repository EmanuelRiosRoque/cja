<div class="grid grid-cols-1 md:grid-cols-4 gap-4 bg-white rounded-xl p-4 shadow-sm ring-1 ring-neutral-200 mb-6">

    {{-- Tipo de sesión --}}
    <div class="flex flex-col items-center justify-center bg-emerald-50 rounded-lg p-3">
        <p class="text-xs font-semibold text-emerald-800 uppercase tracking-wide">
            Tipo de sesión
        </p>
        <p class="mt-1 text-sm font-medium text-emerald-900 text-center">
            {{ $sesion->forma_captura ? 'Programada' : 'Referida' }}
        </p>
    </div>

    {{-- Carácter de la sesión --}}
    <div class="flex flex-col items-center justify-center bg-emerald-50 rounded-lg p-3">
        <p class="text-xs font-semibold text-emerald-800 uppercase tracking-wide">
            Carácter de la sesión
        </p>
        <p class="mt-1 text-sm font-medium text-emerald-900 text-center">
            {{ $sesion->caracter->nombre ?? '—' }}
        </p>
    </div>

    {{-- Inicio --}}
    <div class="flex flex-col items-center justify-center bg-emerald-50 rounded-lg p-3">
        <p class="text-xs font-semibold text-emerald-800 uppercase tracking-wide">
            Inicio
        </p>
        <p class="mt-1 text-sm font-medium text-emerald-900 text-center">
            {{ \Carbon\Carbon::parse($sesion->fecha_programada)->format('d/m/Y') }}
        </p>
        <p class="text-xs text-emerald-700">
            {{ $sesion->hora_programada }}
        </p>
    </div>

    {{-- Fin --}}
    <div class="flex flex-col items-center justify-center bg-emerald-50 rounded-lg p-3">
        <p class="text-xs font-semibold text-emerald-800 uppercase tracking-wide">
            Fin
        </p>
        <p class="mt-1 text-sm font-medium text-emerald-900 text-center">
            {{ \Carbon\Carbon::parse($sesion->fecha_programada)->format('d/m/Y') }}
        </p>
        <p class="text-xs text-emerald-700">
            {{ $sesion->hora_termino }}
        </p>
    </div>
</div>