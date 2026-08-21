<?php

namespace App\Services;

use App\DTO\CreateProductoDTO;
use App\Models\Producto;

class ProductoService
{
    public function create(CreateProductoDTO $data): Producto
    {
        return Producto::create($data->toArray());
    }
}
