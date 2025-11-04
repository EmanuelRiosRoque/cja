<?php

use App\Http\Controllers\Gestor\Servicio;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');


Route::post('/gestor', [Servicio::class, 'gestor']);
