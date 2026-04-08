<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        \App\Models\Usuario::create([
            'nombre' => 'Javier Tulcán',
            'cedula' => '1727430066',
            'password' => 'G@mer2.0',
            'rol' => 'admin',
        ]);
        
        // Estudiante de prueba para demostrar el panel
        \App\Models\Usuario::create([
            'nombre' => 'Estudiante de Prueba',
            'cedula' => '0000000000',
            'password' => 'G@mer2.0',
            'rol' => 'estudiante',
            'semestre' => 1,
        ]);
    }
}
