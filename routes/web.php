<?php

use App\Http\Controllers\EventoController;
use App\Http\Controllers\HomeController;
use Illuminate\Support\Facades\Route;

Route::get('/', [HomeController::class, 'index'])->name('home');

Route::get('/login', [HomeController::class, 'index'])->name('login');

// Rota para exibir a página de detalhes do evento
Route::get('/eventos/{evento}', [EventoController::class, 'show'])->name('eventos.show');

