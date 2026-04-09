<?php

namespace App\Http\Controllers;

use App\Models\Herramienta;
use App\Models\Prestamo;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use App\Models\Usuario;
use App\Notifications\NuevaReservaNotification;

class PrestamoController extends Controller
{
    /**
     * Store a newly created reservation in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'herramienta_id' => 'required|exists:herramientas,id'
        ]);

        $herramienta = Herramienta::findOrFail($request->herramienta_id);

        if ($herramienta->estado !== 'disponible') {
            return back()->with('error', 'La herramienta no está disponible actualmente.');
        }

        // Crear la reserva (Préstamo)
        $prestamo = Prestamo::create([
            'usuario_id' => Auth::id(),
            'herramienta_id' => $herramienta->id,
            'fecha_reserva' => Carbon::now(),
            'fecha_devolucion_esperada' => Carbon::now()->addHour(), // Límite para retirar de 1 hora
            'estado' => 'reservado',
        ]);

        // Bloquear la herramienta en el inventario general
        $herramienta->update(['estado' => 'prestado']);

        // Notificar a todos los administradores
        $admins = Usuario::where('rol', 'admin')->get();
        foreach ($admins as $admin) {
            $admin->notify(new NuevaReservaNotification($prestamo));
        }

        return back()->with('success', '¡Herramienta separada! Tienes 1 hora para retirarla en ventanilla.');
    }

    /**
     * Show the checklist view for high value tools
     */
    public function devolver(Prestamo $prestamo)
    {
        if (Auth::user()->rol !== 'admin' && $prestamo->usuario_id !== Auth::id()) {
            abort(403, 'No tienes permiso para devolver esta herramienta.');
        }

        if ($prestamo->estado === 'devuelto') {
            return redirect()->route('dashboard')->with('error', 'El préstamo ya fue devuelto.');
        }

        if (!$prestamo->herramienta->es_alto_valor) {
            return back()->with('error', 'Esta herramienta no es de alto valor. Usa la devolución rápida.');
        }

        return view('prestamos.devolucion', compact('prestamo'));
    }

    /**
     * Process checklist return
     */
    public function procesarDevolucion(Request $request, Prestamo $prestamo)
    {
        if (Auth::user()->rol !== 'admin' && $prestamo->usuario_id !== Auth::id()) {
            abort(403, 'No tienes permiso para devolver esta herramienta.');
        }

        if ($prestamo->estado === 'devuelto') {
            return redirect()->route('dashboard')->with('error', 'El préstamo ya fue devuelto.');
        }

        $request->validate([
            'foto_devolucion' => 'required|image|mimes:jpg,jpeg,png,webp|max:4096',
        ], [
            'foto_devolucion.required' => 'Es obligatorio adjuntar o tomar una foto de la herramienta.',
        ]);

        $herramienta = $prestamo->herramienta;
        if (is_array($herramienta->accesorios) && count($herramienta->accesorios) > 0) {
            if (!$request->has('accesorios') || count($request->accesorios) !== count($herramienta->accesorios)) {
                return back()->with('error', 'Debes marcar TODOS los accesorios para recibir la herramienta.');
            }
        }

        $path = $request->file('foto_devolucion')->store('devoluciones', 'public');

        $prestamo->update([
            'foto_devolucion' => $path,
            'checklist_accesorios' => $request->has('accesorios') ? array_keys($request->accesorios) : [],
            'estado' => 'devuelto',
            'fecha_devolucion_real' => Carbon::now(),
        ]);

        $herramienta->update(['estado' => 'disponible']);

        // Cerrar la petición si todos los préstamos están devueltos
        if ($prestamo->peticion_id) {
            $peticion = $prestamo->peticion;
            if ($peticion->prestamos()->where('estado', '!=', 'devuelto')->count() === 0) {
                $peticion->update(['estado' => 'completado']);
            }
        }

        return redirect()->route('dashboard')->with('success', 'Checklist verificado y herramienta recibida.');
    }

    /**
     * Fast return for normal tools
     */
    public function devolucionRapida(Prestamo $prestamo)
    {
        if (Auth::user()->rol !== 'admin' && $prestamo->usuario_id !== Auth::id()) {
            abort(403, 'No tienes permiso para devolver esta herramienta.');
        }

        if ($prestamo->estado === 'devuelto') {
            return redirect()->route('dashboard')->with('error', 'El préstamo ya fue devuelto.');
        }

        if ($prestamo->herramienta->es_alto_valor) {
            return back()->with('error', 'Error: Herramienta de Alto Valor. Requiere checklist y firma fotográfica.');
        }

        $prestamo->update([
            'estado' => 'devuelto',
            'fecha_devolucion_real' => Carbon::now(),
        ]);

        $prestamo->herramienta->update(['estado' => 'disponible']);

        // Cerrar la petición si todos los préstamos están devueltos
        if ($prestamo->peticion_id) {
            $peticion = $prestamo->peticion;
            if ($peticion->prestamos()->where('estado', '!=', 'devuelto')->count() === 0) {
                $peticion->update(['estado' => 'completado']);
            }
        }

        return redirect()->route('dashboard')->with('success', 'Herramienta recibida e ingresada al sistema.');
    }
}
