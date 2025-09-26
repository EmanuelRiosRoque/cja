@props([
    'name' => 'default-modal',
    'title' => null,
    'description' => null,
    'size' => 'max-w-lg', // max-w-sm | max-w-lg | max-w-2xl | etc.
    'closeOnBackdrop' => true,
    'closeOnEsc' => true,
])

<div
    x-data="{ open: false }"
    @open-modal.window="if ($event.detail?.name === @js($name)) open = true"
    @close-modal.window="if (!$event.detail || $event.detail?.name === @js($name)) open = false"
    @if($closeOnEsc) @keydown.escape.window="open = false" @endif
    x-id="['modal-title','modal-desc']"
    class="relative"
>
    {{-- Trigger opcional (slot) --}}
    @if (isset($trigger))
      <div @click="open = true">
        {{ $trigger }}
      </div>
    @endif

    {{-- Overlay --}}
    <div
        x-show="open"
        x-transition.opacity
        x-cloak
        class="fixed inset-0 z-50 bg-black/40 backdrop-blur-[1px]"
        aria-hidden="true"
        @if($closeOnBackdrop) @click="open=false" @endif
    ></div>

    {{-- Contenedor centrado --}}
    <div
        x-show="open"
        x-transition
        x-cloak
        class="fixed inset-0 z-50 flex items-center justify-center p-4"
        style="display: none;"
    >
        {{-- Caja del modal --}}
        <div
            @click.stop
            x-transition:enter="transition ease-out duration-200"
            x-transition:enter-start="opacity-0 translate-y-2 scale-95"
            x-transition:enter-end="opacity-100 translate-y-0 scale-100"
            x-transition:leave="transition ease-in duration-150"
            x-transition:leave-start="opacity-100 translate-y-0 scale-100"
            x-transition:leave-end="opacity-0 translate-y-2 scale-95"
            role="dialog"
            aria-modal="true"
            @if($title) :aria-labelledby="$id('modal-title')" @endif
            @if($description) :aria-describedby="$id('modal-desc')" @endif
            class="w-full {{ $size }} rounded-2xl bg-white shadow-xl ring-1 ring-neutral-200"
        >
            {{-- Header (slot header o predeterminado) --}}
            <div class="flex items-start justify-between gap-4 p-5 border-b">
                <div class="min-w-0">
                    @if (trim($header ?? '') !== '')
                        {{ $header }}
                    @else
                        @if($title)
                            <h2 :id="$id('modal-title')" class="text-base font-semibold text-neutral-900">
                                {{ $title }}
                            </h2>
                        @endif
                        @if($description)
                            <p :id="$id('modal-desc')" class="mt-1 text-sm text-neutral-500">
                                {{ $description }}
                            </p>
                        @endif
                    @endif
                </div>

                <button
                    x-ref="firstFocusable"
                    @click="open=false"
                    class="rounded-full p-1.5 hover:bg-neutral-100 text-neutral-500"
                    aria-label="Cerrar"
                >
                    <svg viewBox="0 0 24 24" class="h-5 w-5" fill="none" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 6l12 12M18 6L6 18"/>
                    </svg>
                </button>
            </div>

            {{-- Body --}}
            <div class="p-5">
                {{ $slot }}
            </div>

            {{-- Footer opcional --}}
            @if (trim($footer ?? '') !== '')
                <div class="flex items-center justify-end gap-3 p-5 border-t">
                    {{ $footer }}
                </div>
            @endif
        </div>
    </div>
</div>
