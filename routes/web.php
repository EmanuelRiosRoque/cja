<?php

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



});
Route::get('/contact-wizard', ApplicationWizard::class)->name('contact.wizard');

