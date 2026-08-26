<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Http\Resources\Json\JsonResource;

class CarritoResource extends JsonResource
{
    public function __construct(
        private readonly Collection $items,
        private readonly array $resumen,
    ) {
        parent::__construct($items);
    }
    
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'items' => CarritoItemResource::collection($this->items),
            'resumen' => new CarritoResumenResource(
                $this->items,
                $this->resumen,
            ),
        ];
    }
}
