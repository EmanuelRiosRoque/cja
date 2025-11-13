@props([
  'variant' => 'primary', // primary | secondary | danger | outline
  'size'    => 'md',      // sm | md | lg
  'as'      => 'button',  // button | a
  'href'    => null,
  'type'    => 'submit',
])

@php
  $base = 'inline-flex items-center rounded-md font-semibold uppercase tracking-widest
           focus:outline-none focus:ring-2 focus:ring-offset-2
           transition ease-in-out duration-150 disabled:opacity-50';

  $sizes = [
    'sm' => 'px-3 py-1.5 text-xs',
    'md' => 'px-4 py-2 text-xs',
    'lg' => 'px-6 py-3 text-sm',
  ];

  $variants = [
    'primary'   => 'bg-emerald-800 text-white border border-transparent
                    hover:bg-emerald-700 focus:bg-emerald-700 active:bg-emerald-900
                    focus:ring-emerald-500',
    'secondary' => 'bg-gray-100 text-gray-800 border border-gray-300
                    hover:bg-gray-200 focus:bg-gray-200 active:bg-gray-300
                    focus:ring-gray-400',
    'danger'    => 'bg-red-600 text-white border border-transparent
                    hover:bg-red-500 focus:bg-red-500 active:bg-red-700
                    focus:ring-red-500',
    'blue'       => 'bg-blue-600 text-white border border-transparent
                    hover:bg-blue-500 focus:bg-blue-500 active:bg-blue-700
                    focus:ring-blue-500',
    'warning'    => 'bg-yellow-400 text-white border border-transparent
                    hover:bg-yellow-500 focus:bg-yellow-500 active:bg-yellow-600
                    focus:ring-yellow-500',
    'outline'   => 'bg-transparent text-emerald-800 border border-emerald-800
                    hover:bg-emerald-50 focus:ring-emerald-500',
                  
  ];

  // Resuelve valores con fallback sin usar ?? dentro de interpolación
  $sizeClass = isset($sizes[$size]) ? $sizes[$size] : $sizes['md'];
  $variantClass = isset($variants[$variant]) ? $variants[$variant] : $variants['primary'];

  $classes = "{$base} {$sizeClass} {$variantClass}";
@endphp

@if($as === 'a')
  <a href="{{ $href }}" {{ $attributes->class($classes) }}>
    {{ $slot }}
  </a>
@else
  <button type="{{ $type }}" {{ $attributes->class($classes) }}>
    {{ $slot }}
  </button>
@endif
