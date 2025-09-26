<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @livewireStyles

    <style>[x-cloak]{display:none!important}</style>
  </head>
  <body class="font-sans antialiased">
    <x-banner />

    {{-- Wrapper: sin scroll en body, el scroll vive en <main> --}}
    <div class="bg-gray-100 h-[100svh] overflow-hidden grid grid-rows-[auto,1fr]">
      @livewire('navigation-menu')

      {{-- HEADER compacto (sin padding grande) --}}
      @if (isset($header))
        <header class="bg-white border-b sm:ml-[var(--sbw,18rem)]">
          <div class="px-4 py-4 sm:px-6 lg:px-8">
            <div class="max-w-7xl mx-auto">
              {{-- El slot decide el padding; por defecto le ponemos poco espacio --}}
              <div class="py-2">
                {{ $header }}
              </div>
            </div>
          </div>
        </header>
      @endif

      {{-- CONTENIDO: sin padding superior extra y anulando mt del primer hijo --}}
      <main class="sm:ml-[var(--sbw,18rem)] h-full overflow-y-auto bg-gray-50">
        <div class="pt-0 pb-8 px-4 sm:px-6 lg:px-8">
          <div class="max-w-7xl mx-auto [&>*:first-child]:mt-0">
            {{ $slot }}
          </div>
        </div>
      </main>
    </div>

    @stack('modals')
    @livewireScripts
  </body>
</html>
