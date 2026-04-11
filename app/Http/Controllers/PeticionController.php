<?php

namespace App\Http\Controllers;

use App\Models\Peticion;
use App\Models\Prestamo;
use App\Models\Herramienta;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use App\Models\Usuario;

class PeticionController extends Controller
{
    public function addCart(Request $request, Herramienta $herramienta)
    {
        if ($herramienta->estado !== 'disponible') {
            return response()->json(['error' => 'No disponible'], 400);
        }

        $cart = session()->get('carrito_peticion', []);
        
        if (!in_array($herramienta->id, $cart)) {
            $cart[] = $herramienta->id;
            session()->put('carrito_peticion', $cart);
        }

        return response()->json(['success' => true, 'count' => count($cart)]);
    }

    public function qrAddCart(Herramienta $herramienta)
    {
        if ($herramienta->estado !== 'disponible') {
            return redirect()->route('herramientas.index')->with('error', 'La herramienta ' . $herramienta->nombre . ' no está disponible para préstamo en este momento.');
        }

        $cart = session()->get('carrito_peticion', []);
        
        if (!in_array($herramienta->id, $cart)) {
            $cart[] = $herramienta->id;
            session()->put('carrito_peticion', $cart);
        }

        return redirect()->route('peticiones.create')->with('success', '¡' . $herramienta->nombre . ' añadida a tu petición rápidamente a través de QR!');
    }


    public function removeCart(Request $request, Herramienta $herramienta)
    {
        $cart = session()->get('carrito_peticion', []);
        
        if (($key = array_search($herramienta->id, $cart)) !== false) {
            unset($cart[$key]);
            session()->put('carrito_peticion', array_values($cart));
        }

        return back()->with('success', 'Herramienta removida.'); // Usually done via page reload in cart
    }

    public function create()
    {
        $cart = session()->get('carrito_peticion', []);
        if (empty($cart)) {
            return redirect()->route('herramientas.index')->with('error', 'No tienes herramientas en tu petición actual.');
        }

        $herramientas = Herramienta::whereIn('id', $cart)->get();
        $docentes = Usuario::where('rol', 'docente')->orderBy('nombre')->get();
        return view('peticiones.create', compact('herramientas', 'docentes'));
    }

    public function store(Request $request)
    {
        $cart = session()->get('carrito_peticion', []);
        if (empty($cart)) {
            return redirect()->route('herramientas.index')->with('error', 'El carrito está vacío.');
        }

        $request->validate([
            'docente_id' => 'required|exists:usuarios,id',
            'asignatura' => 'required|string|max:255',
            'practica' => 'required|string|max:255',
            'horas' => 'required|integer|min:0|max:24',
            'minutos' => 'required|integer|min:0|max:59',
            'observaciones' => 'nullable|string',
        ]);

        $totalMinutos = ($request->horas * 60) + $request->minutos;
        
        if ($totalMinutos <= 0) {
            return back()->with('error', 'El tiempo de uso debe ser mayor a 0 minutos.');
        }

        $herramientas = Herramienta::whereIn('id', $cart)->get();

        foreach($herramientas as $h) {
            if ($h->estado !== 'disponible') {
                return back()->with('error', "La herramienta {$h->nombre} ya no está disponible.");
            }
        }

        $peticion = Peticion::create([
            'usuario_id' => Auth::id(),
            'docente_id' => $request->docente_id,
            'docente' => Usuario::find($request->docente_id)->nombre, // Guardar el nombre por redundancia/conveniencia
            'asignatura' => $request->asignatura,
            'practica' => $request->practica,
            'minutos_estimados' => $totalMinutos,
            'observaciones' => $request->observaciones,
            'estado' => 'enviado' // Significa reservado y esperando recojo en ventanilla
        ]);

        foreach($herramientas as $herramienta) {
            Prestamo::create([
                'peticion_id' => $peticion->id,
                'usuario_id' => Auth::id(),
                'herramienta_id' => $herramienta->id,
                'fecha_reserva' => Carbon::now(),
                'fecha_devolucion_esperada' => Carbon::now()->addMinutes($totalMinutos),
                'estado' => 'reservado',
            ]);
            $herramienta->update(['estado' => 'prestado']);
        }

        session()->forget('carrito_peticion');

        return redirect()->route('dashboard')->with('success', 'Has enviado tu Formato de Petición exitosamente.');
    }

    public function entrega(Peticion $peticion)
    {
        if ($peticion->estado !== 'enviado') {
            return redirect()->route('dashboard')->with('error', 'Esta petición no está pendiente de entrega.');
        }
        
        $peticion->load(['prestamos.herramienta', 'usuario']);
        return view('peticiones.entrega', compact('peticion'));
    }

    public function procesarEntrega(Request $request, Peticion $peticion)
    {
        if ($peticion->estado !== 'enviado') {
             return redirect()->route('dashboard')->with('error', 'Esta petición no está pendiente de entrega.');
        }

        $request->validate([
            'foto_entrega' => 'required|image|mimes:jpg,jpeg,png,webp|max:10240',
        ], [
            'foto_entrega.required' => 'Es obligatorio capturar una fotografía de la entrega (Salida).',
        ]);

        $path = $request->file('foto_entrega')->store('entregas', 'public');

        $peticion->update([
            'estado' => 'aprobado', // En tu sistema 'aprobado' significa 'entregado/activo'
            'foto_entrega' => $path
        ]);

        foreach($peticion->prestamos as $prestamo) {
            $prestamo->update([
                'estado' => 'activo',
                'fecha_devolucion_esperada' => Carbon::now()->addMinutes($peticion->minutos_estimados),
            ]);
            // El estado de la herramienta ya debería estar como 'prestado' por PeticionController@store
            // Pero nos aseguramos:
            $prestamo->herramienta->update(['estado' => 'prestado']);
        }

        return redirect()->route('dashboard')->with('success', 'Formato de Salida procesado. Herramientas entregadas correctamente.');
    }
}
