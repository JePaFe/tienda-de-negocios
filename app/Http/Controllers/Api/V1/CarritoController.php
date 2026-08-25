<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreCarritoItemRequest;
use App\Models\CarritoItem;
use App\Models\Producto;
use Illuminate\Http\Request;

class CarritoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user = auth('api')->user();
        $carritoItems = CarritoItem::where('user_id', $user->id)->with('producto')->get();

        return response()->json($carritoItems);
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
    public function update(Request $request, CarritoItem $carritoItem)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(CarritoItem $carritoItem)
    {
        //
    }

    public function clear()
    {
        //
    }
}
