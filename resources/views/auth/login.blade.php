<x-guest-layout>
    <x-authentication-card>
        <x-slot name="logo">
            <x-authentication-card-logo />
        </x-slot>

        {{-- Mostrar errores de validación --}}
        <x-validation-errors class="mb-4" />

        {{-- Mensaje de estado --}}
        @if (session('status'))
            <div class="mb-4 font-medium text-sm text-green-600">
                {{ session('status') }}
            </div>
        @endif

        <form method="POST" action="{{ route('login') }}">
            @csrf

            {{-- Número de empleado --}}
            <div>
                <x-label for="num_empleado" :value="__('Número de empleado')" />
                <x-input id="num_empleado"
                         class="block mt-1 w-full"
                         type="text"
                         name="num_empleado"
                         :value="old('num_empleado')"
                         required
                         autofocus
                         autocomplete="username" />
            </div>

            {{-- Contraseña --}}
            <div class="mt-4">
                <x-label for="password" :value="__('Contraseña')" />
                <x-input id="password"
                         class="block mt-1 w-full"
                         type="password"
                         name="password"
                         required
                         autocomplete="current-password" />
            </div>

            {{-- Recordarme --}}
            <div class="block mt-4">
                <label for="remember_me" class="flex items-center">
                    <x-checkbox id="remember_me" name="remember" />
                    <span class="ms-2 text-sm text-gray-600">{{ __('Recordarme') }}</span>
                </label>
            </div>

            {{-- Acciones --}}
            <div class="flex items-center justify-end mt-4">
                @if (Route::has('password.request'))
                    <a class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-emerald-500"
                       href="{{ route('password.request') }}">
                        {{ __('¿Olvidaste tu contraseña?') }}
                    </a>
                @endif

                <x-button type="submit" class="ms-4 bg-emerald-700 hover:bg-emerald-600 focus:ring-emerald-500">
                    {{ __('Iniciar sesión') }}
                </x-button>
            </div>
        </form>
    </x-authentication-card>
</x-guest-layout>
