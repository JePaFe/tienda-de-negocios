<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Resources\CarritoResource;
use App\Http\Requests\StoreCarritoItemRequest;
use App\Http\Requests\UpdateCarritoItemRequest;
use App\Models\CarritoItem;
use App\Models\Producto;
use App\Services\ResumenCarritoService;
use Illuminate\Http\Request;

class CarritoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(ResumenCarritoService $resumenCarritoService)
    {
        $user = auth('api')->user();
        $carritoItems = CarritoItem::where('user_id', $user->id)->with('producto')->get();

        return response()->json([
            'data' => new CarritoResource(
                $carritoItems,
                $resumenCarritoService->calcular($carritoItems)
            ),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreCarritoItemRequest $request)
    {
        $producto = Producto::findOrFail($request->integer('producto_id'));
        $cantidad = $request->integer('cantidad');

        $itemExistente = CarritoItem::where([
            'user_id' => auth('api')->id(),
            'producto_id' => $producto->id,
        ])->first();

        $nuevaCantidad = $cantidad + ($itemExistente?->cantidad ?? 0);

        if ($nuevaCantidad > $producto->stock) {
            return response()->json([
                'message' => 'Stock insuficiente.',
            ], 422);
        }

        $item = CarritoItem::updateOrCreate(
            [
                'user_id' => auth('api')->id(),
                'producto_id' => $producto->id,
            ],
            ['cantidad' => $nuevaCantidad],
        );

        return response()->json([
            'message' => 'Producto agregado al carrito.',
            'data' => $item->load('producto.categoria'),
        ], $itemExistente ? 200 : 201);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateCarritoItemRequest $request, CarritoItem $carritoItem)
    {
        if ($carritoItem->user_id !== auth('api')->id()) {
            return response()->json([
                'message' => 'El ítem no pertenece al carrito actual.',
            ], 403);
        }

        $cantidad = $request->integer('cantidad');
        $carritoItem->load('producto');

        if ($cantidad > $carritoItem->producto->stock) {
            return response()->json([
                'message' => 'Stock insuficiente.',
            ], 422);
        }

        $carritoItem->update(['cantidad' => $cantidad]);

        return response()->json([
            'message' => 'Cantidad actualizada.',
            'data' => $carritoItem->load('producto.categoria'),
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(CarritoItem $carritoItem)
    {
        if ($carritoItem->user_id !== auth('api')->id()) {
            return response()->json([
                'message' => 'El ítem no pertenece al carrito actual.',
            ], 403);
        }

        $carritoItem->delete();

        return response()->json([
            'message' => 'Producto eliminado del carrito.',
        ]);
    }

    public function clear()
    {
        CarritoItem::where('user_id', auth('api')->id())->delete();

        return response()->json([
            'message' => 'Carrito vaciado correctamente.',
        ]);
    }
}
