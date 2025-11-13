<?php

use App\Http\Controllers\OficialiaController;
use App\Http\Controllers\SesionController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {

    // Dashboard
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');

    // ===========================
    // SESIONES (PLENO)
    // ===========================
    Route::prefix('sesiones')
        ->as('sesion.')
        ->controller(SesionController::class)
        ->group(function () {

            Route::get('/', 'list')->name('index');

            Route::middleware('role:SuperAdmin')->group(function () {
                Route::get('/crear', 'index')->name('create');
                Route::get('/{sesion}/orden-dia', 'ordenDia')->name('ordenDia');
                Route::get('/{sesion}/temas', 'temas')->name('temas');
                Route::get('/{sesion}/adjuntar', 'adjuntar')->name('adjuntar');
            });

            Route::middleware('role:Administrador')->group(function () {
                Route::get('/{sesion}/monitor', 'monitor')->name('monitor');
            });

            Route::middleware('role:Coordinador')->group(function () {
                Route::get('/{sesion}/asignar', 'asignar')->name('asignar');
            });

            Route::get('/{sesion}/ponencia', 'ponencia')->name('ponencia');
        });

    // ===========================
    // OFICIALÍA
    // ===========================
    Route::prefix('oficialia')
        ->as('oficialia.')
        ->controller(OficialiaController::class)
        ->group(function () {

            Route::middleware('role:Oficialía')->group(function () {
                Route::get('/registro', 'registroDocumento')->name('registro');
                Route::get('/turnos', 'turnos')->name('turnos');
                Route::get('/reportes', 'reportes')->name('reportes');
            });
        });
});
