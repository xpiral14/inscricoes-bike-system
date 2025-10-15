<?php

use App\Http\Controllers\EventoController;
use App\Http\Controllers\HomeController;
use Illuminate\Support\Facades\Route;

Route::get('/', [HomeController::class, 'index'])->name('home');

// Rota para exibir a página de detalhes do evento
Route::get('/eventos/{evento}', [EventoController::class, 'show'])->name('eventos.show');

// Rota para processar a solicitação de inscrição (vamos usar mais tarde)
Route::post('/inscricoes', [EventoController::class, 'processarInscricao'])->name('inscricoes.store');
