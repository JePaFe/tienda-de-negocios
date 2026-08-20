<?php

namespace App\Http\Controllers\Api\V1;

use App\DTO\ProductoDTO;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreProductoRequest;
use App\Http\Requests\UpdateProductoRequest;
use App\Models\Producto;
use Illuminate\Http\Request;
use App\Exceptions\ApiException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use App\Http\Resources\ProductoResource;
use App\Services\ProductoService;

class ProductoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): AnonymousResourceCollection
    {
        // throw new ApiException('Error al obtener los productos', 500, ['error' => 'No se pudo obtener la lista de productos']);

        $productos = Producto::query()
                ->when($request->nombre, 
                    fn ($query, $nombre) => 
                        $query->where('nombre', 'like', "%{$nombre}%")
                )
                ->paginate();

        return ProductoResource::collection($productos);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreProductoRequest $request, ProductoService $productoService): JsonResponse {
        // $validatedData = $request->validated();

        // $productoDTO = new ProductoDTO(
        //     nombre: $validatedData['nombre'],
        //     descripcion: $validatedData['descripcion'] ?? null,
        //     precio: (float) $validatedData['precio'],
        //     stock: (int) $validatedData['stock'],
        //     categoria_id: (int) $validatedData['categoria_id'],
        // );

        $productoDTO = ProductoDTO::fromArray($request->validated());

        $producto = Producto::create($productoDTO->toArray());

        return response()->json(new ProductoResource($producto), 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Producto $producto): ProductoResource
    {
        return new ProductoResource($producto);
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
