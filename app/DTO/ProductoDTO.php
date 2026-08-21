<?php

namespace App\DTO;

class ProductoDTO
{
    /**
     * Create a new class instance.
     */
    public function __construct(
        public readonly string $nombre,
        public readonly ?string $descripcion,
        public readonly float $precio,
        public readonly int $stock,
        public readonly int $categoria_id,
    ) {}

    public function toArray(): array
    {
        return [
            'nombre' => $this->nombre,
            'descripcion' => $this->descripcion,
            'precio' => $this->precio,
            'stock' => $this->stock,
            'categoria_id' => $this->categoria_id,
        ];
    }

    public static function fromArray(array $data): self
    {
        return new self(
            nombre: $data['nombre'],
            descripcion: $data['descripcion'] ?? null,
            precio: (float) $data['precio'],
            stock: (int) $data['stock'],
            categoria_id: (int) $data['categoria_id'],
        );
    }
}
