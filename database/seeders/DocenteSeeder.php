<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Usuario;
use Illuminate\Support\Facades\Hash;

class DocenteSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Usuario::updateOrCreate(
            ['cedula' => '1111111111'],
            [
                'nombre' => 'Ing. Docente Prueba',
                'email' => 'docente@ejemplo.com',
                'password' => Hash::make('1111111111'),
                'rol' => 'docente',
                'asignatura' => 'Autotrónica, Mecánica Básica',
            ]
        );
    }
}
