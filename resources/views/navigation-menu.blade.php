<div x-data="{
    open: false,
    collapsed: JSON.parse(localStorage.getItem('sbCollapsed') || 'false')
  }" x-init="$watch('collapsed', v => localStorage.setItem('sbCollapsed', JSON.stringify(v)))"
    x-effect="document.documentElement.style.setProperty('--sbw', collapsed ? '0rem' : '18rem')" class="relative">
    {{-- Top bar móvil --}}
    <header class="sm:hidden sticky top-0 z-40 bg-white border-b border-gray-200">
        <div class="px-4 h-14 flex items-center justify-between">
            <button @click="open = true"
                class="group inline-flex items-center justify-center p-2.5 rounded-xl border border-gray-200 bg-white text-gray-700 hover:bg-gray-50 hover:text-gray-900 active:scale-[.98] shadow-sm focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-indigo-500/60 transition"
                aria-label="Abrir menú" aria-expanded="false">
                <svg class="size-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                </svg>
            </button>
            <a href="{{ route('dashboard') }}" class="inline-flex items-center gap-2">
                <x-application-mark class="block h-6 w-auto" />
            </a>
        </div>
    </header>

    {{-- Overlay móvil --}}
    <div x-cloak x-show="open" @click="open=false" class="fixed inset-0 z-40 bg-black/40 sm:hidden"></div>

    {{-- Sidebar --}}
    <aside :class="(open || !collapsed) ? 'translate-x-0' : '-translate-x-full'"
        class="fixed inset-y-0 left-0 z-50 w-72 bg-white border-r border-gray-200 transition-transform duration-200 ease-out h-[100dvh]"
        aria-label="Barra lateral de navegación">
        <div class="h-full flex flex-col">
            <div class="h-[4.6rem] px-4 pb-2 border-b border-gray-200 flex items-center justify-between">

                <a href="{{ route('dashboard') }}" class="flex items-center gap-3">
                    <x-application-mark class="block h-8 w-auto" />
                    <span class="font-semibold text-gray-800 hidden md:inline">Panel</span>
                </a>


                {{-- cerrar móvil --}}
                <button
                    class="sm:hidden inline-flex items-center justify-center p-2.5 rounded-xl border border-gray-200 bg-white text-gray-700 hover:bg-gray-50 active:scale-[.98] shadow-sm focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-rose-500/60 transition"
                    @click="open=false" aria-label="Cerrar">
                    <svg class="size-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>

                {{-- ocultar escritorio --}}
                <button x-show="!collapsed" @click="collapsed = true"
                    class="hidden sm:inline-flex items-center justify-center p-2.5 rounded-xl border border-gray-200 bg-white text-gray-700 hover:bg-gray-50 active:scale-[.98] shadow-sm focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-indigo-500/60 transition"
                    aria-label="Ocultar sidebar" title="Ocultar sidebar">
                    <svg class="size-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M15 19l-7-7 7-7" />
                    </svg>
                </button>
            </div>

            {{-- Navegación --}}
            <nav class="flex-1 overflow-y-auto p-3">
                <ul class="space-y-1">
                    {{-- Ejemplo de item: usa data-active para estados --}}
                    <li>
                        <x-nav.item href="{{ route('dashboard') }}" route="dashboard">
                            <x-slot:icon>
                                <svg class="w-full h-full" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8"
                                        d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0h6" />
                                </svg>
                            </x-slot:icon>
                            {{ __('Dashboard') }}
                        </x-nav.item>
                    </li>

                    <li>
                        <x-nav.item href="{{ route('dashboard') }}" route="dashboard">
                            <x-slot:icon>
                                <svg class="w-full h-full" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8"
                                        d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/>
                                <polyline points="14 2 14 8 20 8" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"/>
                                <line x1="8" y1="13" x2="16" y2="13" stroke-width="1.8" stroke-linecap="round"/>
                                <line x1="8" y1="17" x2="16" y2="17" stroke-width="1.8" stroke-linecap="round"/>
                                </svg>
                            </x-slot:icon>
                            {{ __('Dashboard') }}
                        </x-nav.item>
                    </li>

                    {{-- <li>
                        <x-nav.item href="{{ route('users.index') }}" route="users.*">
                            <x-slot:icon>
                                <svg class="w-full h-full" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8"
                                        d="M17 20h5v-2a3 3 0 00-5.356-1.857M9 20H4v-2a3 3 0 015.356-1.857M15 7a3 3 0 11-6 0 3 3 0 016 0z" />
                                </svg>
                            </x-slot:icon>
                            Usuarios
                        </x-nav.item>
                    </li> --}}
                </ul>

                @if (Laravel\Jetstream\Jetstream::hasTeamFeatures())
                <div class="mt-6">
                    <p class="px-2 mb-2 text-xs font-semibold uppercase text-gray-400">{{ __('Teams') }}</p>
                    <div x-data="{ tOpen:false }" class="mb-2">
                        <button @click="tOpen = !tOpen" :aria-expanded="tOpen"
                            class="w-full px-3 py-2 rounded-lg text-left text-sm text-gray-700 border border-gray-200 bg-white hover:bg-gray-50 active:scale-[.99] transition focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-indigo-500/60">
                            <div class="flex items-center justify-between">
                                <span class="truncate">{{ Auth::user()->currentTeam->name }}</span>
                                <svg class="size-4 transition-transform" :class="tOpen ? 'rotate-180' : ''" fill="none"
                                    stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8"
                                        d="M19.5 8.25l-7.5 7.5-7.5-7.5" />
                                </svg>
                            </div>
                        </button>
                        <div x-show="tOpen" x-collapse class="mt-2 space-y-1">
                            <x-dropdown-link class="!px-3 !py-2 rounded-md hover:bg-gray-50"
                                href="{{ route('teams.show', Auth::user()->currentTeam->id) }}">Team Settings
                            </x-dropdown-link>
                            @can('create', Laravel\Jetstream\Jetstream::newTeamModel())
                            <x-dropdown-link class="!px-3 !py-2 rounded-md hover:bg-gray-50"
                                href="{{ route('teams.create') }}">Create New Team</x-dropdown-link>
                            @endcan
                        </div>
                    </div>
                </div>
                @endif
            </nav>

            <div class="border-t border-gray-200 p-3">
                <div class="flex items-center gap-3 px-2">
                    @if (Laravel\Jetstream\Jetstream::managesProfilePhotos())
                    <img class="size-9 rounded-full object-cover" src="{{ Auth::user()->profile_photo_url }}"
                        alt="{{ Auth::user()->name }}" />
                    @endif
                    <div class="min-w-0">
                        <p class="text-sm font-medium text-gray-800 truncate">{{ Auth::user()->name }}</p>
                        <p class="text-xs text-gray-500 truncate">{{ Auth::user()->email }}</p>
                    </div>
                </div>
                <div class="mt-3 grid gap-1">
                    <x-dropdown-link class="!px-3 !py-2 rounded-md hover:bg-gray-50" href="{{ route('profile.show') }}">
                        Profile</x-dropdown-link>
                    @if (Laravel\Jetstream\Jetstream::hasApiFeatures())
                    <x-dropdown-link class="!px-3 !py-2 rounded-md hover:bg-gray-50"
                        href="{{ route('api-tokens.index') }}">API Tokens</x-dropdown-link>
                    @endif
                    <form method="POST" action="{{ route('logout') }}" x-data class="mt-1">
                        @csrf
                        <x-dropdown-link class="!px-3 !py-2 rounded-md hover:bg-gray-50" href="{{ route('logout') }}"
                            @click.prevent="$root.submit();">Log Out</x-dropdown-link>
                    </form>
                </div>
            </div>
        </div>
    </aside>

    {{-- Botón para mostrar cuando está oculto --}}
    <button x-cloak x-show="collapsed && !open" @click="collapsed = false"
        class="hidden sm:flex fixed top-3 left-3 z-40 p-2.5 rounded-xl bg-white border border-gray-200 shadow-md hover:bg-gray-50 active:scale-[.98] focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-indigo-500/60"
        aria-label="Mostrar sidebar" title="Mostrar sidebar">
        <svg class="size-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M9 5l7 7-7 7" />
        </svg>
    </button>
</div>