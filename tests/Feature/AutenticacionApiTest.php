<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class AutenticacionApiTest extends TestCase
{
    use RefreshDatabase;

    public function test_una_persona_puede_registrarse(): void
    {
        // Arrange: Preparar los datos para el registro
        $usuario = [
            'name' => 'Ana Tienda',
            'email' => 'ana@tienda.test',
            'password' => 'password',
            'password_confirmation' => 'password',
        ];

        // Act: Realizar la solicitud de registro
        $response = $this->postJson('/api/v1/register', $usuario);

        // Assert: Verificar que la respuesta sea correcta
        $response->assertOk()
            ->assertJsonStructure([
                'access_token',
                'token_type',
                'expires_in',
                'user' => ['id', 'name', 'email'],
            ])
            ->assertJsonPath('user.email', 'ana@tienda.test')
            ->assertJsonMissingPath('user.password');

        $this->assertDatabaseHas('users', ['email' => 'ana@tienda.test']);
    }

    public function test_el_registro_rechaza_un_email_repetido(): void
    {
        User::factory()->create(['email' => 'ana@tienda.test']);

        $response = $this->postJson('/api/v1/register', [
            'name' => 'Ana Tienda',
            'email' => 'ana@tienda.test',
            'password' => 'password',
            'password_confirmation' => 'password',
        ]);

        $response->assertUnprocessable()
            ->assertJsonValidationErrors(['email']);
    }

    public function test_el_registro_rechaza_falta_el_email(): void
    {
        // Arrange: Preparar los datos incompletos para el registro
        $usuario = [
            'name' => 'User',
            'password' => '123454678',
            'password_confirmation' => '123454678',
        ];

        // Act: Realizar la solicitud de registro con datos incompletos
        $response = $this->postJson('/api/v1/register', $usuario);

        // Assert: Verificar que la respuesta sea de error por campos faltantes
        $response->assertUnprocessable()
            ->assertJsonValidationErrors(['email']);
    }

    public function test_una_persona_registrada_puede_iniciar_sesion(): void
    {
        // Arrange: Crear un usuario registrado
        User::factory()->create([
            'email' => 'ana@tienda.test',
            'password' => 'password',
        ]);

        // Act: Realizar la solicitud de inicio de sesión
        $response = $this->postJson('/api/v1/login', [
            'email' => 'ana@tienda.test',
            'password' => 'password',
        ]);

        $response->assertOk()
            ->assertJsonStructure(['access_token', 'token_type', 'expires_in', 'user'])
            ->assertJsonPath('token_type', 'bearer')
            ->assertJsonPath('user.email', 'ana@tienda.test')
            ->assertJsonMissingPath('user.password');
    }

    public function test_el_inicio_de_sesion_rechaza_credenciales_incorrectas(): void 
    {
        // Arrange: Crear un usuario registrado
        $usuario = [
            'email' => 'ana@tienda.test',
            'password' => 'contraseña_incorrecta',
        ];

        // Act: Realizar la solicitud de inicio de sesión con credenciales incorrectas
        $response = $this->postJson('/api/v1/login', $usuario);

        // Assert: Verificar que la respuesta sea de error
        $response->assertUnauthorized();
    }

    public function test_una_persona_autenticada_puede_ver_su_perfil(): void
    {
        $user = User::factory()->create();

        $token = auth('api')->login($user);

        $this->withToken($token)
            ->getJson('/api/v1/profile')
            ->assertOk()
            ->assertJsonPath('id', $user->id)
            ->assertJsonPath('email', $user->email)
            ->assertJsonMissingPath('password');
    }

    public function test_el_perfil_rechaza_peticiones_sin_token(): void
    {
        $this->getJson('/api/v1/profile')->assertUnauthorized();
    }
}
