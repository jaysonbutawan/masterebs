<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\OrderItemController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\RoleController;
use Illuminate\Support\Facades\Route;

Route::name('auth.')->controller(AuthController::class)->group(function () {
    Route::post('/login', 'login')->name('login');
    Route::post('/register', 'register')->name('register');
    Route::get('/health', 'health')->name('health');
});

Route::middleware('api.auth')->group(function () {
    Route::prefix('profile')->name('auth.')->group(function () {
        Route::get('/{id}', [AuthController::class, 'profile'])->name('profile');
    });

    Route::name('catalog.')->group(function () {
        Route::apiResource('categories', CategoryController::class);
        Route::apiResource('products', ProductController::class);
    });

    Route::name('sales.')->group(function () {
        Route::apiResource('orders', OrderController::class);
        Route::apiResource('order-items', OrderItemController::class);
    });

    Route::name('access.')->group(function () {
        Route::apiResource('roles', RoleController::class);
    });
});
