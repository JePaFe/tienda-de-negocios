<?php

namespace App\DTO;

final readonly class UpdateProductoDTO
{
    /**
     * @param list<string> $providedFields
     */
    public function __construct(
        public ?string $sku = null,
        public ?int $categoriaId = null,
        public ?string $nombre = null,
        public ?string $descripcion = null,
        public ?string $precio = null,
        public ?int $stock = null,
        public array $providedFields = [],
    ) {}

    public function hasChanges(): bool
    {
        return $this->providedFields !== [];
    }

    /**
     * @return array<string, int|string|null>
     */
    public function toArray(): array
    {
        $values = [
            'sku' => $this->sku,
            'categoria_id' => $this->categoriaId,
            'nombre' => $this->nombre,
            'descripcion' => $this->descripcion,
            'precio' => $this->precio,
            'stock' => $this->stock,
        ];

        return array_intersect_key(
            $values,
            array_flip($this->providedFields),
        );
    }
}
