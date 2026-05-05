<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\Usuario;
use Illuminate\Support\Facades\Hash;

class RoleAccessTest extends TestCase
{
    use RefreshDatabase;

    private function createUsuario($rol)
    {
        return Usuario::create([
            'nombre' => 'Test ' . $rol,
            'cedula' => '123456789' . rand(0, 9),
            'email' => $rol . rand(1, 1000) . '@test.com',
            'password' => Hash::make('password123'),
            'rol' => $rol,
            'asignatura' => $rol == 'docente' ? 'Mecánica' : null,
            'semestre' => $rol == 'estudiante' ? '1' : null,
        ]);
    }

    public function test_estudiante_puede_acceder_dashboard_estudiante()
    {
        $estudiante = $this->createUsuario('estudiante');

        $response = $this->actingAs($estudiante)->get('/dashboard');

        // Asumiendo que el middleware redirige o muestra la vista correcta
        $response->assertStatus(200);
    }

    public function test_docente_puede_acceder_dashboard_docente()
    {
        $docente = $this->createUsuario('docente');

        $response = $this->actingAs($docente)->get('/dashboard');

        $response->assertStatus(200);
    }

    public function test_coordinador_puede_acceder_dashboard_coordinador()
    {
        $coordinador = $this->createUsuario('admin');

        $response = $this->actingAs($coordinador)->get('/dashboard');

        $response->assertStatus(200);
    }

    public function test_estudiante_no_puede_acceder_rutas_de_coordinador()
    {
        $estudiante = $this->createUsuario('estudiante');

        // Intentar acceder a la gestión de usuarios, que suele ser de admin
        $response = $this->actingAs($estudiante)->get('/usuarios');

        // Si hay middleware de rol, debería dar 403 o redirigir
        $response->assertStatus(403);
    }
}
