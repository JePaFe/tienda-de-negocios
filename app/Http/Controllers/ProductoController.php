<?php

namespace App\Http\Controllers;

use App\Models\Producto;
use Illuminate\Http\Request;
use App\Http\Requests\StoreProductoRequest;
use App\Http\Requests\UpdateProductoRequest;

class ProductoController extends Controller
{
    public function index()
    {
        $productos = Producto::all();

        return response()->json($productos);
    }

    public function show(Producto $producto) {
        return response()->json($producto);
    }

    public function store(StoreProductoRequest $request) {
        $validatedData = $request->validated();

        $producto = Producto::create($validatedData);

        return response()->json($producto, 201);
    }

    public function update(UpdateProductoRequest $request, Producto $producto) 
    {
        $validatedData = $request->validated();

        $producto->update($validatedData);

        return response()->json($producto);
    }   

    public function destroy(Producto $producto) {

    }
}
