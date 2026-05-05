<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\Usuario;
use App\Models\Herramienta;
use App\Models\Peticion;
use Illuminate\Support\Facades\Hash;

class PeticionWorkflowTest extends TestCase
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

    private function createHerramienta()
    {
        return Herramienta::create([
            'codigo_qr' => 'QR' . rand(1000, 9999),
            'nombre' => 'Llave Inglesa',
            'descripcion' => 'Herramienta de prueba',
            'categoria' => 'Herramientas de Mano',
            'estado' => 'disponible',
            'marca' => 'Truper',
            'es_alto_valor' => false,
            'tiene_accesorios' => false,
        ]);
    }

    public function test_estudiante_puede_crear_peticion()
    {
        $estudiante = $this->createUsuario('estudiante');
        $docente = $this->createUsuario('docente');
        $herramienta = $this->createHerramienta();

        // Simular que añadió al carrito en sesión
        $this->withSession(['cart' => [
            $herramienta->id => [
                'id' => $herramienta->id,
                'nombre' => $herramienta->nombre,
                'codigo' => $herramienta->codigo_qr,
                'accesorios' => []
            ]
        ]]);

        $response = $this->actingAs($estudiante)->post(route('peticiones.store'), [
            'docente_id' => $docente->id,
            'asignatura' => 'Mecánica Básica',
            'practica' => 'Uso de llaves',
            'minutos_estimados' => 120,
        ]);

        $response->assertRedirect(route('dashboard'));
        $this->assertDatabaseHas('peticiones', [
            'usuario_id' => $estudiante->id,
            'docente_id' => $docente->id,
            'estado' => 'pendiente', // Por defecto cuando se crea, o dependiendo del flujo
            'asignatura' => 'Mecánica Básica',
        ]);
    }

    public function test_docente_puede_aprobar_peticion()
    {
        $estudiante = $this->createUsuario('estudiante');
        $docente = $this->createUsuario('docente');

        $peticion = Peticion::create([
            'usuario_id' => $estudiante->id,
            'docente_id' => $docente->id,
            'asignatura' => 'Mecánica',
            'practica' => 'Practica 1',
            'minutos_estimados' => 60,
            'estado' => 'pendiente',
            'docente_aprueba' => false,
        ]);

        $response = $this->actingAs($docente)->post(route('peticiones.aprobar-docente', $peticion->id));

        $response->assertRedirect();
        
        $peticion->refresh();
        $this->assertTrue((bool) $peticion->docente_aprueba);
        $this->assertEquals('enviado', $peticion->estado); // Generalmente cambia a 'enviado' para el coordinador
    }
}
