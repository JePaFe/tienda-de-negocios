<?php

use App\Http\Controllers\Api\V1\CategoriaController;
use App\Http\Controllers\Api\V1\ProductoController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::prefix('v1')->group(function() {
    // Route::get('/productos', [ProductoController::class, 'index']);
    // Route::get('/productos/{producto}', [ProductoController::class, 'show']);
    // Route::post('/productos', [ProductoController::class, 'store']);
    // Route::put('/productos/{producto}', [ProductoController::class, 'update']);
    // Route::delete('/productos/{producto}', [ProductoController::class, 'destroy']);

    Route::apiResource('productos', ProductoController::class)->middleware('throttle:10,1');
    Route::apiResource('categorias', CategoriaController::class)->middleware('throttle:10,1');
});