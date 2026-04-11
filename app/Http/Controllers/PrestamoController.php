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
            'foto_devolucion' => 'required|image|mimes:jpg,jpeg,png,webp|max:10240',
            'observaciones' => 'nullable|string|max:1000',
        ], [
            'foto_devolucion.required' => 'Es obligatorio adjuntar o tomar una foto de la herramienta.',
        ]);

        $herramienta = $prestamo->herramienta;
        $tieneIncidencia = false;

        // Validar checklist si la herramienta tiene accesorios
        if (!empty($herramienta->accesorios)) {
            $accesoriosOriginales = $herramienta->accesorios_formateados;
            $recibidosIndices = $request->input('accesorios_recibidos', []);
            $nuevosAccesorios = [];
            
            foreach ($accesoriosOriginales as $index => $acc) {
                // Si el accesorio ya estaba perdido, lo dejamos como estaba (o podríamos reincorporarlo si se marca, pero la vista los filtra)
                if ($acc['estado'] == 'perdido') {
                    $nuevosAccesorios[] = $acc;
                    continue;
                }

                // Si no se recibió en este retorno, pasa a 'perdido'
                if (!in_array($index, $recibidosIndices)) {
                    $acc['estado'] = 'perdido';
                    $tieneIncidencia = true;
                }
                
                $nuevosAccesorios[] = $acc;
            }
            
            // Actualizar la herramienta con los nuevos estados de accesorios
            $herramienta->update(['accesorios' => $nuevosAccesorios]);
        }

        // Si el usuario escribió algo en observaciones, marcamos como incidencia
        if (!empty($request->observaciones)) {
            $tieneIncidencia = true;
        }

        $path = $request->file('foto_devolucion')->store('devoluciones', 'public');

        $prestamo->update([
            'foto_devolucion' => $path,
            'checklist_accesorios' => $request->input('accesorios_recibidos', []),
            'observaciones' => $request->observaciones,
            'estado' => 'devuelto',
            'fecha_devolucion_real' => Carbon::now(),
        ]);

        // Si hay incidencia (faltan piezas o hay reporte), o si el admin lo marcó manualmente, la herramienta va a mantenimiento
        $nuevoEstado = $request->estado_final ?? ($tieneIncidencia ? 'mantenimiento' : 'disponible');
        $herramienta->update(['estado' => $nuevoEstado]);

        // Cerrar la petición si todos los préstamos están devueltos
        if ($prestamo->peticion_id) {
            $peticion = $prestamo->peticion;
            if ($peticion->prestamos()->where('estado', '!=', 'devuelto')->count() === 0) {
                $peticion->update(['estado' => 'completado']);
            }
        }

        $msg = $tieneIncidencia 
            ? 'Devolución registrada con NOVEDADES. La herramienta ha sido enviada a mantenimiento para revisión.' 
            : 'Checklist verificado y herramienta recibida correctamente.';

        return redirect()->route('dashboard')->with('success', $msg);
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
