<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CarritoItemResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'producto' => $this->producto->nombre,
            'precio' => (float) $this->producto->precio,
            'cantidad' => $this->cantidad,
            'subtotal' => round(
                (float) $this->producto->precio * $this->cantidad,
                2
            ),
        ];
    }
}
