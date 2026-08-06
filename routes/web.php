<?php

use App\Models\Comentario;
use App\Models\Producto;
use Illuminate\Support\Facades\Route;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

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

Route::get('/prueba-usuario', function () {
    // $usuario = new User();

    // $usuario->name = 'Juan Pérez';
    // $usuario->email = 'juan.perez@example.com';
    // $usuario->password = Hash::make('password123');
    
    // $usuario->save();

    // return $usuario;

    // $usuario = new User();
    // $usuario->name = 'María López';
    // $usuario->email = 'maria.lopez@example.com';
    // $usuario->password = Hash::make('password123');
    // $usuario->save();

    // return $usuario;

    // --

    // $usuarios = User::all();

    // return $usuarios;

    // ---

    // $usuario = User::find(4);
    // // $usuario = User::findOrFail(4);

    // return $usuario;

    // ---

    // $usuario = User::where('email', 'maria.lopez@example.com')->first();
    // // $usuario = User::where('id', '>', 0)->latest()->first();

    // return $usuario;

    // ---

    // $usuario = User::find(4);

    // var_dump($usuario);

    // if ($usuario) {
    //     $usuario->name = 'María López Actualizada';
    //     $usuario->email = 'maria.lopez@example.com.ar';
    //     $usuario->save();
    // }

    // return $usuario;

    // ---

    // $usuario = User::find(1);

    // if ($usuario) {
    //     $usuario->delete();
    // }

    // return $usuario;

    // ---

    // $usuario = User::find(2);

    // $comentario = new Comentario();
    // $comentario->contenido = 'Un comentario de prueba para el usuario con id 2';
    // $comentario->user()->associate($usuario);
    // $comentario->save();

    // return $comentario;

    // ---

    // $comentario = Comentario::find(1);

    // return $comentario->user;

    // ---

    // $usuario = User::find(2);

    // return $usuario->comentarios;

    // ---

    $cantidadComentarios = Comentario::where('user_id', 2)->count();

    return "El usuario con id 2 tiene {$cantidadComentarios} comentarios.";
});

Route::get('/prueba-productos', function () {
    // $producto = Producto::find(2);

    // $producto->nombre = 'Producto Actualizado';
    // $producto->save();

    // $producto->update([
    //     'nombre' => 'Producto Actualizado desde update()',
    // ]);

    // $producto = Producto::create([
    //     'nombre' => 'Nuevo Producto',
    //     'descripcion' => 'Descripción del nuevo producto',
    //     'precio' => 19.99,
    //     'stock' => 100
    // ]);

    $producto = Producto::find(3);

    $producto->delete();

    return $producto;
});