<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ProductoController extends Controller
{
    public function index()
    {
        $productos = [
            ['id' => 1, 'nombre' => 'Producto 1', 'precio' => 10.99],
            ['id' => 2, 'nombre' => 'Producto 2', 'precio' => 19.99],
            ['id' => 3, 'nombre' => 'Producto 3', 'precio' => 5.49],
        ];

        return response()->json($productos);
    }
}
