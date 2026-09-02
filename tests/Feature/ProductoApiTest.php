<?php

namespace Tests\Feature;

use App\Models\Categoria;
use App\Models\Producto;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ProductoApiTest extends TestCase
{
    use RefreshDatabase;

    public function test_cualquier_persona_puede_listar_productos(): void
    {
        Producto::factory()->count(3)->create();

        $response = $this->getJson('/api/v1/productos');

        $response->assertOk()
            ->assertJsonCount(3, 'data')
            ->assertJsonStructure([
                'data' => [
                    '*' => ['id', 'sku', 'nombre', 'precio', 'stock', 'disponible'],
                ],
            ]);
    }

    public function test_una_persona_admin_puede_crear_un_producto(): void {
         $admin = User::factory()->create(['is_admin' => true]);

         $token = auth('api')->login($admin);

         $categoria = Categoria::factory()->create();

         $producto = [
            'sku' => 'PROD1001',
            'nombre' => 'Mouse inalámbrico',
            'descripcion' => 'Mouse para la tienda',
            'precio' => 15000,
            'stock' => 8,
            'categoria_id' => $categoria->id,
        ];

        $response = $this->withToken($token)->postJson('/api/v1/productos', $producto);

         $response->assertCreated()
            ->assertJsonPath('nombre', 'Mouse inalámbrico')
            ->assertJsonPath('stock', 8);

         $this->assertDatabaseHas('productos', [
            'sku' => 'PROD1001',
            'nombre' => 'Mouse inalámbrico',
        ]);
    }

    public function test_una_persona_sin_token_no_puede_crear_productos(): void {
        $categoria = Categoria::factory()->create();

        $producto = [
            'sku' => 'PROD1003',
            'nombre' => 'Monitor inalámbrico',
            'descripcion' => 'Monitor para la tienda',
            'precio' => 30000,
            'stock' => 3,
            'categoria_id' => $categoria->id,
        ];

        $response = $this->postJson('/api/v1/productos', $producto);

        $response->assertUnauthorized();

        $this->assertDatabaseCount('productos', 0);
    }

    public function test_una_persona_no_admin_no_puede_crear_productos(): void {
        $user = User::factory()->create(['is_admin' => false]);

        $token = auth('api')->login($user);

        $categoria = Categoria::factory()->create();

        $producto = [
            'sku' => 'PROD1002',
            'nombre' => 'Teclado inalámbrico',
            'descripcion' => 'Teclado para la tienda',
            'precio' => 20000,
            'stock' => 5,
            'categoria_id' => $categoria->id,
        ];

        $response = $this->withToken($token)->postJson('/api/v1/productos', $producto);

        $response->assertForbidden();

        $this->assertDatabaseCount('productos', 0);
    }
}
