<?php

use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route;

Route::prefix('room')->name('room.')->group(function () {
    Route::get('/login', [AuthController::class, 'login'])->name('login');
    Route::post('/register', [AuthController::class, 'register'])->name('register');
    Route::get('/health', [AuthController::class, 'health'])->name('health');

    Route::middleware('api.auth')->group(function () {
        Route::get('/profile/{id}', [AuthController::class, 'profile'])->name('profile');
    });
});
