<?php

use App\Http\Controllers\Api\V1\CategoriaController;
use App\Http\Controllers\Api\V1\ProductoController;
use App\Http\Controllers\Api\V1\AuthController;
use App\Http\Controllers\Api\V1\CarritoController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::prefix('v1')->group(function () {
    // Route::get('/productos', [ProductoController::class, 'index']);
    // Route::get('/productos/{producto}', [ProductoController::class, 'show']);
    // Route::post('/productos', [ProductoController::class, 'store']);
    // Route::put('/productos/{producto}', [ProductoController::class, 'update']);
    // Route::delete('/productos/{producto}', [ProductoController::class, 'destroy']);

    Route::middleware('throttle:10,1')->group(function () {
        Route::apiResource('productos', ProductoController::class)->middlewareFor(['store', 'update', 'destroy'],  ['auth:api', 'admin']);
        Route::apiResource('categorias', CategoriaController::class)->middleware(['auth:api', 'admin']);
    });

    // Route::apiResource('productos', ProductoController::class)->middleware(['throttle:10,1', 'auth:api', 'admin']);
    // Route::apiResource('categorias', CategoriaController::class)->middleware('throttle:10,1');

    Route::post('/register', [AuthController::class, 'register']);
    Route::post('/login', [AuthController::class, 'login']);
    Route::get('/profile', [AuthController::class, 'profile'])->middleware('auth:api');

    Route::middleware('auth:api')->prefix('carrito')->group(function () {
        Route::get('/', [CarritoController::class, 'index']);
        Route::post('/items', [CarritoController::class, 'store']);
        Route::patch('/items/{carritoItem}', [CarritoController::class, 'update']);
        Route::delete('/items/{carritoItem}', [CarritoController::class, 'destroy']);
        Route::delete('/', [CarritoController::class, 'clear']);
    });
});
