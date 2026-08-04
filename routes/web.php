<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/about', function () {
    return view('about');
});

Route::get('/productos', function () {
    return 'Listado de productos Web';
})->name('web.productos');

Route::get('/productos/{id}', function ($id) {
    return "Mostrando el producto con id: {$id}";
});
