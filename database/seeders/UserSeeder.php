<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::factory()->create([
            'name' => 'Cliente de Prueba',
            'email' => 'cliente@example.com',
        ]);

        User::factory()->create([
            'name' => 'Administrador de Prueba',
            'email' => 'admin@example.com',
            'is_admin' => true,
        ]);
    }
}
