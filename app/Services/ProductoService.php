<?php

namespace App\Services;

use App\DTO\ProductoDTO;
use App\Models\Producto;

class ProductoService
{
    public function create(ProductoDTO $data): Producto
    {
        return Producto::create($data->toArray());
    }
}
