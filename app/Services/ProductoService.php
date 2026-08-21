<?php

namespace App\Services;

use App\DTO\CreateProductoDTO;
use App\DTO\UpdateProductoDTO;
use App\Models\Producto;

class ProductoService
{
    public function create(CreateProductoDTO $data): Producto
    {
        return Producto::create($data->toArray());
    }

    public function update(
        Producto $producto,
        UpdateProductoDTO $data,
    ): Producto {
        if (! $data->hasChanges()) {
            return $producto;
        }

        $producto->update($data->toArray());

        return $producto;
    }
}
