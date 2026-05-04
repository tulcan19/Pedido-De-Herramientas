<?php

namespace App\Http\Controllers;

use App\Models\Usuario;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UsuarioController extends Controller
{
    /**
     * Mostrar la lista de estudiantes para el coordinador.
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


        $usuario->update([
            'semestre' => $usuario->semestre + 1,
            'ultimo_cambio_semestre' => now(),
        ]);

        return back()->with('success', "¡{$usuario->nombre} ha sido promovido al " . $usuario->semestre . "° Semestre!");
    }

    /**
     * Actualizar información del estudiante.
     */
    public function estudiantesUpdate(Request $request, Usuario $usuario)
    {
        if ($usuario->rol !== 'estudiante') {
            return back()->with('error', 'Acción no permitida.');
        }

        $request->validate([
            'nombre' => 'required|string|max:255',
            'cedula' => 'required|string|max:10|unique:usuarios,cedula,' . $usuario->id,
            'email' => 'nullable|email|max:255|unique:usuarios,email,' . $usuario->id,
            'semestre' => 'required|integer|min:1',
            'password' => 'nullable|string|min:4',
        ], [
            'cedula.unique' => 'Esta cédula ya está registrada para otro usuario.',
            'email.unique' => 'Este correo electrónico ya está registrado para otro usuario.',
        ]);

        $dataToUpdate = [
            'nombre' => $request->nombre,
            'cedula' => $request->cedula,
            'email' => $request->email,
            'semestre' => $request->semestre,
        ];

        if ($request->filled('password')) {
            $dataToUpdate['password'] = Hash::make($request->password);
        } elseif ($usuario->cedula !== $request->cedula) {
            $dataToUpdate['password'] = Hash::make($request->cedula);
        }

        $usuario->update($dataToUpdate);

        return back()->with('success', 'Datos del estudiante actualizados correctamente.');
    }

    /**
     * Gestión de Docentes
     */
    public function docentesIndex()
    {
        $docentes = Usuario::where('rol', 'docente')->orderBy('nombre')->get();
        return view('usuarios.docentes', compact('docentes'));
    }

    public function docentesStore(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string|max:255',
            'cedula' => 'required|string|unique:usuarios,cedula|max:10',
            'asignatura' => 'required|string|max:255',
        ], [
            'cedula.unique' => 'Esta cédula ya está registrada en el sistema.',
        ]);

        Usuario::create([
            'nombre' => $request->nombre,
            'cedula' => $request->cedula,
            'asignatura' => $request->asignatura,
            'password' => Hash::make($request->cedula), // Contraseña genérica (Cédula)
            'rol' => 'docente',
        ]);

        return back()->with('success', 'Docente registrado exitosamente. La contraseña inicial es su número de cédula.');
    }

    public function docentesUpdate(Request $request, Usuario $usuario)
    {
        if ($usuario->rol !== 'docente') {
            return back()->with('error', 'Acción no permitida.');
        }

        $request->validate([
            'nombre' => 'required|string|max:255',
            'cedula' => 'required|string|max:10|unique:usuarios,cedula,' . $usuario->id,
            'asignatura' => 'required|string|max:255',
            'password' => 'nullable|string|min:4',
        ], [
            'cedula.unique' => 'Esta cédula ya está registrada para otro usuario.',
        ]);

        $dataToUpdate = [
            'nombre' => $request->nombre,
            'cedula' => $request->cedula,
            'asignatura' => $request->asignatura,
        ];

        if ($request->filled('password')) {
            $dataToUpdate['password'] = Hash::make($request->password);
        } elseif ($usuario->cedula !== $request->cedula) {
            $dataToUpdate['password'] = Hash::make($request->cedula);
        }

        $usuario->update($dataToUpdate);

        return back()->with('success', 'Datos del docente actualizados correctamente.');
    }

    public function docentesDestroy(Usuario $usuario)
    {
        if ($usuario->rol !== 'docente') {
            return back()->with('error', 'Solo se pueden eliminar cuentas de docentes desde esta sección.');
        }

        $usuario->delete();
        return back()->with('success', 'Docente eliminado del sistema.');
    }
}
