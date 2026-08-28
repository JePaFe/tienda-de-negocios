<?php

namespace App\Services;

use Illuminate\Support\Collection;

class ResumenCarritoService
{
    private const TASA_IMPUESTO = 0.21;
    private const ENVIO_GRATIS_DESDE = 100000;
    private const COSTO_ENVIO = 5000;

    public function calcular(Collection $items): array
    {
        $subtotal = $items->sum(
            fn($item) => (float) $item->producto->precio * $item->cantidad
        );

        $impuestos = $subtotal * self::TASA_IMPUESTO;

        // $envio = $subtotal == 0.0
        //     ? 0
        //     : ($subtotal >= self::ENVIO_GRATIS_DESDE ? 0 : self::COSTO_ENVIO);

        $envio = 0;

        if ($subtotal > 0.0 && $subtotal < self::ENVIO_GRATIS_DESDE) {
            $envio = self::COSTO_ENVIO;
        }

        return [
            'subtotal' => round($subtotal, 2),
            'impuestos' => round($impuestos, 2),
            'envio' => round($envio, 2), // Envio sin impuestos
            'total' => round($subtotal + $impuestos + $envio, 2),
        ];
    }
}
