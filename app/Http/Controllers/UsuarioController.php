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
    public function index(Request $request)
    {
        $allEstudiantes = Usuario::where('rol', 'estudiante')->get();
        $semestresDisponibles = $allEstudiantes->pluck('semestre')->unique()->sort();

        $query = Usuario::where('rol', 'estudiante');
        
        if ($request->filled('semestre')) {
            $query->where('semestre', $request->semestre);
        }

        $estudiantes = $query->orderBy('semestre')->orderBy('nombre')->get();
        $maxSemestres = \App\Models\Setting::get('max_semestres', 6);
        return view('usuarios.index', compact('estudiantes', 'allEstudiantes', 'semestresDisponibles', 'maxSemestres'));
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

        $maxSemestres = \App\Models\Setting::get('max_semestres', 6);
        if ($usuario->semestre >= $maxSemestres) {
            return back()->with('error', "No se puede promover a {$usuario->nombre}: El límite es de {$maxSemestres} semestres.");
        }


        $usuario->update([
            'semestre' => $usuario->semestre + 1,
            'ultimo_cambio_semestre' => now(),
        ]);

        return back()->with('success', "¡{$usuario->nombre} ha sido promovido al " . $usuario->semestre . "° Semestre!");
    }

    /**
     * Retroceder un estudiante al semestre anterior.
     */
    public function retroceder(Usuario $usuario)
    {
        if ($usuario->semestre <= 1) {
            return back()->with('error', "El estudiante ya está en el 1° Semestre, no puede retroceder más.");
        }

        $usuario->update([
            'semestre' => $usuario->semestre - 1,
            'ultimo_cambio_semestre' => now(),
        ]);

        return back()->with('success', "¡{$usuario->nombre} ha retrocedido al " . $usuario->semestre . "° Semestre!");
    }

    /**
     * Promover a todos los estudiantes listados al siguiente semestre.
     */
    public function promoverTodos(Request $request)
    {
        $query = Usuario::where('rol', 'estudiante');
        
        if ($request->filled('semestre')) {
            $query->where('semestre', $request->semestre);
        }

        $estudiantes = $query->get();
        
        if ($estudiantes->isEmpty()) {
            return back()->with('error', 'No hay estudiantes para promover en esta vista.');
        }
        
        $maxSemestres = \App\Models\Setting::get('max_semestres', 6);
        $count = 0;
        foreach ($estudiantes as $estudiante) {
            if ($estudiante->semestre < $maxSemestres) {
                $estudiante->update([
                    'semestre' => $estudiante->semestre + 1,
                    'ultimo_cambio_semestre' => now(),
                ]);
                $count++;
            }
        }

        $mensaje = $request->filled('semestre') 
            ? "¡{$count} estudiantes del {$request->semestre}° Semestre han sido promovidos!"
            : "¡{$count} estudiantes han sido promovidos al siguiente semestre!";

        return back()->with('success', $mensaje);
    }

    /**
     * Retroceder a todos los estudiantes listados al semestre anterior (revierte promover).
     */
    public function retrocederTodos(Request $request)
    {
        $query = Usuario::where('rol', 'estudiante');
        
        if ($request->filled('semestre')) {
            $query->where('semestre', $request->semestre);
        }

        $estudiantes = $query->get();
        
        if ($estudiantes->isEmpty()) {
            return back()->with('error', 'No hay estudiantes para retroceder en esta vista.');
        }
        
        $count = 0;
        foreach ($estudiantes as $estudiante) {
            if ($estudiante->semestre > 1) {
                $estudiante->update([
                    'semestre' => $estudiante->semestre - 1,
                    'ultimo_cambio_semestre' => now(),
                ]);
                $count++;
            }
        }

        if ($count === 0) {
            return back()->with('error', 'Ningún estudiante pudo ser retrocedido (ya están en 1° Semestre).');
        }

        $mensaje = $request->filled('semestre') 
            ? "¡{$count} estudiantes del {$request->semestre}° Semestre han retrocedido un semestre!"
            : "¡{$count} estudiantes han retrocedido un semestre!";

        return back()->with('success', $mensaje);
    }

    /**
     * Actualizar información del estudiante.
     */
    public function estudiantesUpdate(Request $request, Usuario $usuario)
    {
        if ($usuario->rol !== 'estudiante') {
            return back()->with('error', 'Acción no permitida.');
        }

        $maxSemestres = \App\Models\Setting::get('max_semestres', 6);
        $request->validate([
            'nombre' => 'required|string|max:255',
            'cedula' => 'required|string|max:10|unique:usuarios,cedula,' . $usuario->id,
            'email' => 'nullable|email|max:255|unique:usuarios,email,' . $usuario->id,
            'semestre' => 'required|integer|min:1|max:' . $maxSemestres,
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
        $docentes = Usuario::whereIn('rol', ['docente', 'admin'])->orderBy('rol')->orderBy('nombre')->get();
        return view('usuarios.docentes', compact('docentes'));
    }

    public function docentesStore(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string|max:255',
            'cedula' => 'required|regex:/^[0-9]+$/|unique:usuarios,cedula|max:10',
            'asignatura' => 'nullable|string|max:255',
            'rol' => 'required|in:docente,admin',
        ], [
            'cedula.unique' => 'Esta cédula ya está registrada en el sistema.',
            'cedula.regex' => 'La cédula solo debe contener números.',
        ]);

        Usuario::create([
            'nombre' => $request->nombre,
            'cedula' => $request->cedula,
            'asignatura' => $request->asignatura ?? 'N/A',
            'password' => Hash::make($request->cedula),
            'rol' => $request->rol,
        ]);

        return back()->with('success', 'Personal registrado exitosamente. La contraseña inicial es su número de cédula.');
    }

    public function docentesUpdate(Request $request, Usuario $usuario)
    {
        if (!in_array($usuario->rol, ['docente', 'admin'])) {
            return back()->with('error', 'Acción no permitida.');
        }

        $request->validate([
            'nombre' => 'required|string|max:255',
            'cedula' => 'required|regex:/^[0-9]+$/|max:10|unique:usuarios,cedula,' . $usuario->id,
            'asignatura' => 'nullable|string|max:255',
            'password' => 'nullable|string|min:4',
            'rol' => 'required|in:docente,admin',
        ], [
            'cedula.unique' => 'Esta cédula ya está registrada para otro usuario.',
            'cedula.regex' => 'La cédula solo debe contener números.',
        ]);

        $dataToUpdate = [
            'nombre' => $request->nombre,
            'cedula' => $request->cedula,
            'asignatura' => $request->asignatura ?? 'N/A',
            'rol' => $request->rol,
        ];

        if ($request->filled('password')) {
            $dataToUpdate['password'] = Hash::make($request->password);
        } elseif ($usuario->cedula !== $request->cedula) {
            $dataToUpdate['password'] = Hash::make($request->cedula);
        }

        $usuario->update($dataToUpdate);

        return back()->with('success', 'Datos del personal actualizados correctamente.');
    }

    public function docentesDestroy(Usuario $usuario)
    {
        if (!in_array($usuario->rol, ['docente', 'admin'])) {
            return back()->with('error', 'Solo se pueden eliminar cuentas de personal administrativo o docente.');
        }

        $usuario->delete();
        return back()->with('success', 'Docente eliminado del sistema.');
    }
}
