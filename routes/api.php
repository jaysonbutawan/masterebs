<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\OrderItemsController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\RoleController;
use Illuminate\Support\Facades\Route;

Route::prefix('POS')->group(function () {
    Route::post('/login', [AuthController::class, 'login'])->name('user-login');
    Route::post('/register', [AuthController::class, 'register'])->name('user-register');
    Route::get('/health', [AuthController::class, 'health'])->name('api-health');

    Route::middleware(['auth:sanctum', 'api.auth'])->group(function () {
        Route::prefix('profile')->name('auth.')->group(function () {
            Route::get('/{id}', [AuthController::class, 'profile'])->name('profile');
        });

        Route::prefix('categories')->name('categories.')->group(function () {
            Route::get('/{id?}', [CategoryController::class, 'index'])->name('index-optional');
            Route::post('/', [CategoryController::class, 'store'])->name('store');
            Route::put('/{id}', [CategoryController::class, 'update'])->name('update');
            Route::delete('/{id}', [CategoryController::class, 'destroy'])->name('destroy');
        });

        Route::prefix('products')->name('products.')->group(function () {
            Route::get('/{id?}', [ProductController::class, 'index'])->name('index-optional');
            Route::post('/', [ProductController::class, 'store'])->name('store');
            Route::put('/{id}', [ProductController::class, 'updateDetails'])->name('updateDetails');
            Route::delete('/{id}', [ProductController::class, 'destroy'])->name('destroy');
        });

        Route::prefix('orders')->name('orders.')->group(function () {
            Route::get('/{id?}', [OrderController::class, 'index'])->name('index-optional');
            Route::post('/', [OrderController::class, 'store'])->name('store');
            Route::match(['put', 'patch'], '/{id}', [OrderController::class, 'update'])->name('update');
            Route::match(['get', 'post'], 'cancel/{id}', [OrderController::class, 'cancel'])->name('cancel');
        });

        Route::prefix('order-items')->name('order-items.')->group(function () {
            Route::get('/{id?}', [OrderItemsController::class, 'index'])->name('index-optional');
            Route::post('/', [OrderItemsController::class, 'store'])->name('store');
            Route::put('/{id}', [OrderItemsController::class, 'update'])->name('update');
            Route::delete('/{id}', [OrderItemsController::class, 'destroy'])->name('destroy');
        });

        Route::prefix('roles')->name('roles.')->group(function () {
            Route::get('/{id?}', [RoleController::class, 'roles'])->name('index-optional');
            Route::post('/', [RoleController::class, 'store'])->name('store');
            Route::put('/{id}', [RoleController::class, 'update'])->name('update');
            Route::match(['delete', 'post'], '/{id}', [RoleController::class, 'destroy'])->name('destroy');
        });

        Route::post('/logout', [AuthController::class, 'logout'])->name('user-logout');
    });
});
