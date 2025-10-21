<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');
Route::get('/cidades/{estado}', [\App\Http\Controllers\LocationController::class, 'listaDeCidades'])->name('cidades.list');
Route::get('/estados', [\App\Http\Controllers\LocationController::class, 'listaDeEstados'])->name('estados.list');
Route::post('/login', [\App\Http\Controllers\SessionController::class, 'login'])->name('api.login');

Route::group(['middleware' => ['auth:web']], function () {
    Route::post('/register', [\App\Http\Controllers\SessionController::class, 'register'])->name('api.register');
});


