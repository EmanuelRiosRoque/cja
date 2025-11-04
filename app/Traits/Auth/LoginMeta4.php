<?php

namespace App\Traits\Auth;

use App\Models\User;
use App\Services\Meta4ApiService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Laravel\Fortify\Fortify;

trait LoginMeta4
{
    /**
     * Registra el proceso de autenticación personalizado de Fortify.
     */
    public function registerMeta4Login(): void
    {
        $useMeta4 = filter_var(env('USE_META4_LOGIN', false), FILTER_VALIDATE_BOOLEAN);

        Fortify::authenticateUsing(function (Request $request) use ($useMeta4) {
            $numEmpleado = trim($request->input('num_empleado'));
            $password = trim($request->input('password'));

            if (!$numEmpleado) {
                return null;
            }

            //  LOGIN LOCAL NORMAL
            if (!$useMeta4) {
                $user = User::where('num_empleado', $numEmpleado)->first();

                if (!$user) {
                    session()->flash('error', 'Usuario no encontrado en el sistema local.');
                    return null;
                }

                if (!Hash::check($password, $user->password)) {
                    session()->flash('error', 'Contraseña incorrecta.');
                    return null;
                }

                return $user;
            }

            // LOGIN CON META4
            $meta4 = app(Meta4ApiService::class);
            $empleado = $meta4->validarActivo($numEmpleado);

            if (!$empleado) {
                session()->flash('error', 'Tu cuenta no está activa en el sistema Meta4.');
                return null;
            }

            $user = User::where('num_empleado', $empleado['nuM_EMPL'])->first();

            if (!$user) {
                session()->flash('error', 'No estás registrado en el sistema local. Contacta al administrador.');
                return null;
            }

            if (!Hash::check($password, $user->password)) {
                session()->flash('error', 'Contraseña incorrecta.');
                return null;
            }

            return $user;
        });
    }
}
