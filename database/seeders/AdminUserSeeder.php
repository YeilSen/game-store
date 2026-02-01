<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User; // Asegúrate de importar el modelo User
use Illuminate\Support\Facades\Hash; // Importa el facade de Hash

class AdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create([
            'name' => 'Admin Principal',
            'email' => 'admin@tiendajuegos.com', // <<--- Email de Acceso
            'password' => Hash::make('password'), // <<--- Contraseña de Acceso (¡Cámbiala!)
            'is_admin' => true, // <<--- Campo clave para el rol
            'email_verified_at' => now(),
        ]);
        
        // Opcional: crea un usuario de prueba normal
        User::create([
            'name' => 'Usuario de Prueba',
            'email' => 'user@tiendajuegos.com',
            'password' => Hash::make('password'),
            'is_admin' => false,
            'email_verified_at' => now(),
        ]);
    }
}