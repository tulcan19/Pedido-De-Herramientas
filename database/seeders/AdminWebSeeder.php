<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Usuario;
use Illuminate\Support\Facades\Hash;

class AdminWebSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Usuario::updateOrCreate(
            ['cedula' => 'admin'],
            [
                'nombre' => 'Coordinador del Taller',
                'password' => 'admin1719', // El modelo Usuario probablemente tiene un mutador o maneja el Hash, si no, usar Hash::make
                'rol' => 'admin',
            ]
        );
    }
}
