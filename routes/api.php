<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductoController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::prefix('v1')->group(function () {
    Route::get('/productos', [ProductoController::class, 'index'])->name('api.productos');
    Route::get('/productos/{producto}', [ProductoController::class, 'show'])->name('api.productos.show');
    Route::post('/productos', [ProductoController::class, 'store'])->name('api.productos.store');
    Route::put('/productos/{producto}', [ProductoController::class, 'update'])->name('api.productos.update');

    // Route::get('/productos/{id}', function ($id) {
    //     return "Mostrando el producto con id: {$id}";
    // });
});