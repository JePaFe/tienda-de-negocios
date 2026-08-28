<?php

namespace Tests\Unit;

use App\Services\ResumenCarritoService;
use PHPUnit\Framework\TestCase;
use stdClass;

class ResumenCarritoServicioTest extends TestCase
{
    private function item(float $precio, int $cantidad): stdClass
    {
        $producto = new stdClass();
        $producto->precio = $precio;

        $item = new stdClass();
        $item->producto = $producto;
        $item->cantidad = $cantidad;

        return $item;
    }

    public function test_calcula_un_carrito_con_envio(): void
    {
        // Arrange: Crear un carrito con un solo item
        $items = collect([$this->item(50000, 1)]);

        // Act: Calcular el resumen del carrito
        $resumen = (new ResumenCarritoService())->calcular($items);

        // Assert: Verificar que el resumen calculado sea correcto
        $this->assertEquals([
            'subtotal' => 50000.0,
            'impuestos' => 10500.0,
            'envio' => 5000.0,
            'total' => 65500.0,
        ], $resumen);

        $this->assertEquals(5000, $resumen['envio']);
        $this->assertSame(5000.0, $resumen['envio']);

        $this->assertArrayHasKey('envio', $resumen);
        $this->assertCount(4, $resumen);

        $this->assertTrue($resumen['envio'] > 0);

        $this->assertArrayHasKey('total', $resumen);

        $this->assertEmpty("");

        $this->assertInstanceOf(\App\Services\ResumenCarritoService::class, new ResumenCarritoService());
    }

    public function test_ofrece_envio_gratis_justo_desde_el_monto_limite(): void
    {
        $resumen = (new ResumenCarritoService())->calcular(
            collect([$this->item(50000, 2)])
        );

        $this->assertEquals(0.0, $resumen['envio']);
        $this->assertEquals(121000.0, $resumen['total']);
    }

    public function test_cobra_gastos_envio_cuando_no_alcanza_el_envio_gratis_limite_inferior(): void
    {
        $resumen = (new ResumenCarritoService())->calcular(
            collect([$this->item(1, 1)])
        );

        $this->assertEquals(5000.0, $resumen['envio']);
        $this->assertEquals(5001.21, $resumen['total']);
    }

    public function test_cobra_gastos_envio_cuando_no_alcanza_el_envio_gratis_limite_superior(): void
    {
        $resumen = (new ResumenCarritoService())->calcular(
            collect([$this->item(99999, 1)])
        );

        $this->assertEquals(5000.0, $resumen['envio']);
        $this->assertEquals(125998.79, $resumen['total']);
    }

    public function test_suma_varias_lineas_antes_de_calcular_impuestos(): void
    {
        $items = collect([
            $this->item(10000, 2),
            $this->item(15000, 1),
        ]);

        $resumen = (new ResumenCarritoService())->calcular($items);

        $this->assertEquals(35000.0, $resumen['subtotal']);
        $this->assertEquals(7350.0, $resumen['impuestos']);
        $this->assertEquals(47350.0, $resumen['total']);
    }

    public function test_un_carrito_vacio_no_genera_cargos(): void
    {
        $resumen = (new ResumenCarritoService())->calcular(collect());

        $this->assertSame([
            'subtotal' => 0.0,
            'impuestos' => 0.0,
            'envio' => 0.0,
            'total' => 0.0,
        ], $resumen);
    }
}
