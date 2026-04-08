<?php

namespace App\Http\Controllers;

use App\Models\Usuario;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UsuarioController extends Controller
{
    /**
     * Mostrar la lista de estudiantes para el administrador.
     */
    public function index()
    {
        $estudiantes = Usuario::where('rol', 'estudiante')->orderBy('semestre')->orderBy('nombre')->get();
        return view('usuarios.index', compact('estudiantes'));
    }

    /**
     * Promover un estudiante al siguiente semestre.
     */
    public function promover(Usuario $usuario)
    {
        // Lógica de Bloqueo: Comprobar si tiene herramientas pendientes
        // Por ahora, como no tenemos la tabla de préstamos terminada,
        // dejaremos este espacio para la futura validación.
        
        /* 
        if ($usuario->tieneHerramientasPendientes()) {
            return back()->with('error', "No se puede promover a {$usuario->nombre}: Tiene herramientas pendientes de devolución.");
        }
        */

        if ($usuario->semestre >= 6) {
            return back()->with('error', "El estudiante ya está en el último semestre.");
        }

        $usuario->update([
            'semestre' => $usuario->semestre + 1,
            'ultimo_cambio_semestre' => now(),
        ]);

        return back()->with('success', "¡{$usuario->nombre} ha sido promovido al " . $usuario->semestre . "° Semestre!");
    }
}
