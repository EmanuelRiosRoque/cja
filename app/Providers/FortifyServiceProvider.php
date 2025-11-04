<?php

namespace App\Providers;

use App\Traits\Auth\LoginMeta4;
use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Str;

class FortifyServiceProvider extends ServiceProvider
{
    use LoginMeta4;

    public function boot(): void
    {
        $this->registerMeta4Login();

        // Limitadores de intentos
        RateLimiter::for('login', function (Request $request) {
            $throttleKey = Str::transliterate(
                Str::lower($request->input('num_empleado')).'|'.$request->ip()
            );
            return Limit::perMinute(5)->by($throttleKey);
        });
    }
}
