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

        $minutos = $request->input('minutos');
        if (is_string($minutos) && ctype_digit($minutos)) {
            $request->merge(['minutos' => (int) $minutos]);
        }

        $request->validate([
            'docente_id' => 'required|exists:usuarios,id',
            'asignatura' => 'required|string|max:255',
            'semestre_materia' => 'required|integer|min:1|max:6',
            'practica' => 'required|string|max:255',
            'horas' => 'required|integer|min:0|max:24',
            'minutos' => 'required|integer|min:0|max:59',
            'observaciones' => 'nullable|string',
        ]);

        $totalMinutos = 525600; // Un año de duración (efectivamente sin límite de tiempo)
        
        $horaIngreso = str_pad((string) $request->horas, 2, '0', STR_PAD_LEFT)
            . ':'
            . str_pad((string) $request->minutos, 2, '0', STR_PAD_LEFT);
        // Podemos guardar la hora de ingreso en las observaciones o en un campo nuevo si existiera.
        // Por ahora lo incluiremos en las observaciones automáticamente.
        $observaciones = "Hora de ingreso: {$horaIngreso}."
            . ($request->filled('observaciones') ? ' ' . $request->observaciones : '');

        $herramientas = Herramienta::whereIn('id', $cart)->get();

        foreach($herramientas as $h) {
            if ($h->estado !== 'disponible') {
                return back()->with('error', "La herramienta {$h->nombre} ya no está disponible.");
            }
        }

        \Illuminate\Support\Facades\DB::transaction(function() use ($request, $herramientas, $totalMinutos, $observaciones) {
            $peticion = Peticion::create([
                'usuario_id' => Auth::id(),
                'docente_id' => $request->docente_id,
                'docente' => Usuario::find($request->docente_id)->nombre, // Guardar el nombre por redundancia/conveniencia
                'asignatura' => $request->asignatura . ' (' . $request->semestre_materia . '° Semestre)',
                'practica' => $request->practica,
                'minutos_estimados' => $totalMinutos,
                'observaciones' => $observaciones,
                'estado' => 'enviado', // Esperando aprobación del docente
                'docente_aprueba' => false
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
        });

        session()->forget('carrito_peticion');

        return redirect()->route('dashboard')->with('success', 'Has enviado tu petición. Está a la espera de autorización por tu docente.');
    }

    public function entrega(Peticion $peticion)
    {
        if (Auth::user()->rol !== 'docente' && Auth::user()->rol !== 'admin') {
            abort(403, 'No autorizado.');
        }

        if ($peticion->estado !== 'enviado') {
            return redirect()->route('dashboard')->with('error', 'Esta petición no está pendiente de entrega.');
        }
        
        if (!$peticion->docente_aprueba) {
            return redirect()->route('dashboard')->with('error', 'Esta petición aún no ha sido autorizada por el docente.');
        }
        
        $peticion->load(['prestamos.herramienta', 'usuario']);
        return view('peticiones.entrega', compact('peticion'));
    }

    public function aprobarDocente(Peticion $peticion)
    {
        if (Auth::user()->rol !== 'docente' && Auth::user()->rol !== 'admin') {
            abort(403, 'No autorizado.');
        }

        if ($peticion->estado !== 'enviado') {
            return back()->with('error', 'La petición no está pendiente.');
        }

        $peticion->update(['docente_aprueba' => true]);

        return back()->with('success', 'Has autorizado la petición. El estudiante ahora puede retirar las herramientas en ventanilla.');
    }

    public function procesarEntrega(Request $request, Peticion $peticion)
    {
        if (Auth::user()->rol !== 'docente' && Auth::user()->rol !== 'admin') {
            abort(403, 'No autorizado.');
        }

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
