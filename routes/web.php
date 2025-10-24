<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\EventoController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\InscricaoController;
use Illuminate\Support\Facades\Route;

Route::get('/', [HomeController::class, 'index'])->name('home');


// Rota para exibir a página de detalhes do evento
Route::get('/eventos/{evento}', [EventoController::class, 'show'])->name('eventos.show');

Route::get('login', [AuthController::class, 'create'])->name('login');
Route::post('login', [AuthController::class, 'store'])->name('login.store');
Route::post('logout', [AuthController::class, 'destroy'])->middleware('auth')->name('logout');
Route::post('/inscricoes', [InscricaoController::class, 'store'])
    ->name('inscricoes.store');


Route::middleware('auth')->group(function () {
    Route::get('/minha-conta/compras', [\App\Http\Controllers\DashboardController::class, 'compras'])->name('minha-conta.compras');
    // Você pode adicionar outras rotas da conta aqui no futuro (perfil, etc.)
});
