@props([
  'href' => '#',
  // Puedes pasar un patrón de ruta (o array) para el estado activo: 'dashboard' o 'users.*'
  'route' => null,
  // Forzar manualmente activo si lo necesitas (sobrescribe route)
  'active' => null,
])

@php
  // Determinar estado activo
  $isActive = false;

  if (!is_null($active)) {
      $isActive = (bool) $active;
  } elseif (!is_null($route)) {
      // Acepta string o array de patrones
      $isActive = request()->routeIs($route);
  }

  // Clases base + activas
  $base = 'relative group w-full flex items-center gap-3 px-3 py-2 rounded-lg text-[15px] text-gray-700
           border border-transparent hover:bg-gray-50 hover:border-gray-200
           focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-indigo-500/60 transition
           before:absolute before:inset-y-1 before:left-0 before:w-1 before:rounded-full before:bg-indigo-500
           before:opacity-0 before:transition';

  $activeClasses = $isActive
      ? ' bg-indigo-50 text-indigo-700 border-indigo-200 before:opacity-100'
      : '';
@endphp

<a
  href="{{ $href }}"
  data-active="{{ $isActive ? 'true' : 'false' }}"
  @if($isActive) aria-current="page" @endif
  {{ $attributes->merge(['class' => $base . $activeClasses]) }}
>
  @isset($icon)
    <span class="shrink-0 size-5">
      {{ $icon }}
    </span>
  @endisset

  <span class="truncate">{{ $slot }}</span>
</a>
