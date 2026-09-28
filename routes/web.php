<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RegisterController;

// Rutas para el flujo de registro
Route::get('/register', [RegisterController::class, 'create'])->name('register.create');
Route::post('/register', [RegisterController::class, 'store'])->name('register.store');
Route::get('/', function () {
    return view('home');
});
//responde a get cuando el usuario entra a registrer , muestra el formulario
//responde a post cuanod el usuario llena el formulafio y toca registrarse , alida y guarda y manda el correo