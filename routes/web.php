<?php

use App\Http\Controllers\ListaSesionesController;
use App\Http\Controllers\NuevaSesionController;
use App\Livewire\Wizards\ApplicationWizard;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');

    Route::prefix('sesiones')->group(function () {
        Route::get('/', [NuevaSesionController::class, 'list'])->name('sesion.index');        
        Route::get('/crear', [NuevaSesionController::class, 'index'])->name('sesion.create'); 
        Route::get('/orden-dia/{sesion}', [NuevaSesionController::class, 'ordenDia'])->name('sesion.ordenDia');
        Route::get('/temas/{sesion}', [NuevaSesionController::class, 'temas'])->name('sesion.temas');
        Route::get('/adjuntar/{sesion}', [NuevaSesionController::class, 'adjuntar'])->name('sesion.adjuntar');
        Route::get('/ponencia/{sesion}', [NuevaSesionController::class, 'ponencia'])->name('sesion.ponencia');
    });
});

