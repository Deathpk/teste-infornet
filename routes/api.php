<?php

use App\Http\Controllers\Auth\AuthenticationController;
use App\Http\Controllers\ProviderController;
use Illuminate\Support\Facades\Route;

Route::controller(AuthenticationController::class)->prefix('auth')
->group(function() {
    Route::post('/register', 'register');
    Route::post('/login', 'login');
    Route::get('/logout', 'logout')->middleware('auth:api');
});

Route::controller(ProviderController::class)->prefix('provider')
->group(function (){
    Route::get('/search', 'search');
});