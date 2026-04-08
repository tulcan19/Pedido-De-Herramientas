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
}
