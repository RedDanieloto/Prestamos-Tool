<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TecnicoController;
use App\Http\Controllers\HerramientaController;
use App\Http\Controllers\PrestamoController;

Route::get('/', [PrestamoController::class, 'index'])->name('home');

// Rutas de Técnicos
Route::resource('tecnicos', TecnicoController::class);

// Rutas de Herramientas
Route::resource('herramientas', HerramientaController::class);

// Rutas de Préstamos
Route::get('prestamos', [PrestamoController::class, 'index'])->name('prestamos.index');
Route::post('prestamos', [PrestamoController::class, 'store'])->name('prestamos.store');
Route::post('prestamos/{prestamo}/devolver', [PrestamoController::class, 'devolver'])->name('prestamos.devolver');
