<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreProductoRequest;
use App\Http\Requests\UpdateProductoRequest;
use App\Models\Producto;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class ProductoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): JsonResponse
    {
        $productos = Producto::all();

        return response()->json($productos);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreProductoRequest $request): JsonResponse {
        $validatedData = $request->validated();

        $producto = Producto::create($validatedData);

        return response()->json($producto, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Producto $producto): JsonResponse
    {
        return response()->json($producto);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateProductoRequest $request, Producto $producto): JsonResponse
    {
        $validatedData = $request->validated();

        $producto->update($validatedData);

        return response()->json($producto);
    } 

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Producto $producto): JsonResponse
    {
        $producto->delete();

        return response()->json(null, 204);
    }
}
