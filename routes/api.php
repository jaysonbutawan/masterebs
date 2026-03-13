<?php

use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\OrderItemsController;
use App\Http\Controllers\RoleController;

Route::prefix('POS')->group(function () {

    Route::post('/login', [AuthController::class, 'login'])->name('user-login');
    Route::post('/register', [AuthController::class, 'register'])->name('user-register');
    Route::get('/health', [AuthController::class, 'health'])->name('api-health');

    Route::middleware(['auth:sanctum', 'api.auth'])->group(function () {

        Route::prefix('categories')->name('categories.')->group(function () {
            Route::get('/{id?}', [CategoryController::class, 'index'])->middleware('permission:category.read')->name('index-optional');
            Route::post('/', [CategoryController::class, 'store'])->middleware('permission:category.create')->name('store');
            Route::put('/{id}', [CategoryController::class, 'update'])->middleware('permission:category.update')->name('update');
            Route::delete('/{id}', [CategoryController::class, 'destroy'])->middleware('permission:category.delete')->name('destroy');
        });

        Route::prefix('products')->name('products.')->group(function () {
            Route::get('/{id?}', [ProductController::class, 'index'])->middleware('permission:product.read')->name('index-optional');
            Route::post('/', [ProductController::class, 'store'])->middleware('permission:product.create')->name('store');
            Route::put('/{id}', [ProductController::class, 'updateDetails'])->middleware('permission:product.update')->name('updateDetails');
            Route::delete('/{id}', [ProductController::class, 'destroy'])->middleware('permission:product.delete')->name('destroy');
        });

        Route::prefix('orders')->name('orders.')->group(function () {
            Route::get('/{id?}', [OrderController::class, 'index'])->middleware('permission:order.read')->name('index-optional');
            Route::post('/', [OrderController::class, 'store'])->middleware('permission:order.create')->name('store');
            Route::put('/{id}', [OrderController::class, 'update'])->middleware('permission:order.update')->name('update');
            Route::post('cancel/{id}', [OrderController::class, 'cancel'])->middleware('permission:order.cancel')->name('cancel');
        });

        Route::prefix('order-items')->name('order-items.')->group(function () {
            Route::get('/{id?}', [OrderItemsController::class, 'index'])->middleware('permission:order-item.read')->name('index-optional');
            Route::post('/', [OrderItemsController::class, 'store'])->middleware('permission:order-item.create')->name('store');
            Route::put('/{id}', [OrderItemsController::class, 'update'])->middleware('permission:order-item.update')->name('update');
            Route::delete('/{id}', [OrderItemsController::class, 'destroy'])->middleware('permission:order-item.delete')->name('destroy');
        });

        Route::prefix('roles')->name('roles.')->group(function () {
            Route::get('/{id?}', [RoleController::class, 'roles'])->middleware('permission:role.read')->name('index-optional');
            Route::post('/', [RoleController::class, 'store'])->middleware('permission:role.create')->name('store');
            Route::put('/{id}', [RoleController::class, 'update'])->middleware('permission:role.update')->name('update');
            Route::delete('/{id}', [RoleController::class, 'destroy'])->middleware('permission:role.delete')->name('destroy');
        });

        Route::post('/logout', [AuthController::class, 'logout'])->name('user-logout');
    });
});
