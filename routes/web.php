<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController; // Asegúrate de importar el controlador

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', [HomeController::class, 'index'])->name('home');

Route::resource('/proyectos', App\Http\Controllers\ProyectoController::class);
