<?php

namespace App\Http\Controllers;

use App\Models\Producto;
use Illuminate\Http\Request;

class ProductoController extends Controller
{
    public function index()
    {
        $productos = Producto::all();

        return response()->json($productos);
    }

    public function store() {
        $producto = new Producto();

        $producto->nombre = 'Nuevo Producto de Prueba';
        $producto->descripcion = 'Descripción del nuevo producto';
        $producto->precio = 5.99;
        $producto->stock = 20;

        $producto->save();

        return response()->json($producto);
    }
}
