<?php

namespace App\Http\Controllers\Api\V1;

use App\DTO\CreateProductoDTO;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreProductoRequest;
use App\Http\Requests\UpdateProductoRequest;
use App\Models\Producto;
use Illuminate\Http\Request;
use App\Exceptions\ApiException;
use App\Http\Resources\ProductoResource;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
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

        // $productoDTO = new CreateProductoDTO(
        //     nombre: $validatedData['nombre'],
        //     descripcion: $validatedData['descripcion'] ?? null,
        //     precio: (float) $validatedData['precio'],
        //     stock: (int) $validatedData['stock'],
        //     categoria_id: (int) $validatedData['categoria_id'],
        // );

        // if (!auth('api')->user()->is_admin) {
        //     return response()->json(['error' => 'No tienes permisos para crear productos'], 403);
        // }

        $producto = $productoService->create($request->toDTO());

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
    public function update(UpdateProductoRequest $request, Producto $producto, ProductoService $productoService): JsonResponse
    {
        $producto = $productoService->update($producto, $request->toDto());

        return ProductoResource::make($producto)->response()->setStatusCode(200);
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
