<?php

use App\Http\Controllers\Auth\AuthenticationController;
use App\Http\Controllers\CoordinatesController;
use App\Http\Controllers\ProviderController;
use App\Http\Controllers\ServiceController;
use Illuminate\Support\Facades\Route;

Route::controller(AuthenticationController::class)->prefix('auth')
->group(function() {
    Route::post('/register', 'register');
    Route::post('/login', 'login');
    Route::get('/logout', 'logout')->middleware('auth:api');
});

Route::middleware(['auth:api'])->controller(ProviderController::class)->prefix('providers')
->group(function () {
    Route::get('/search', 'search');
    Route::get('/{provider}', 'show');
    Route::put('/{provider}', 'update');
});

// TODO REFATORAR PARA CONTROLLER INVOKABLE
Route::middleware(['auth:api'])->controller(CoordinatesController::class)->prefix('coordinates')
->group(function() {
    Route::get('/', 'fetch');
})->middleware('auth:api');

Route::middleware(['auth:api'])->controller(ServiceController::class)->prefix('services')
->group(function() {
    Route::get('/', 'index');
    Route::get('/{service}', 'show');
    Route::post('/', 'store');
    Route::put('/{service}', 'update');
    Route::delete('/{service}', 'destroy');
});