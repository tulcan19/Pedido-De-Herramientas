<?php

namespace App\Http\Controllers;

use App\Models\Herramienta;
use Illuminate\Http\Request;

class HerramientaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $herramientas = Herramienta::all();
        return view('herramientas.index', compact('herramientas'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $lastTool = Herramienta::where('codigo_qr', 'like', 'HTA-%')->latest('id')->first();
        $nextNum = 1;
        if ($lastTool) {
            $lastNum = (int) str_replace('HTA-', '', $lastTool->codigo_qr);
            $nextNum = $lastNum + 1;
        }
        $nextCode = 'HTA-' . str_pad($nextNum, 3, '0', STR_PAD_LEFT);

        return view('herramientas.create', compact('nextCode'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nombre' => 'required|string|max:255',
            'descripcion' => 'nullable|string',
            'codigo_qr' => 'nullable|string|unique:herramientas,codigo_qr',
            'estado' => 'required|in:disponible,prestado,mantenimiento,perdido',
            'ubicacion' => 'nullable|string|max:255',
            'imagen' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:10240',
            'accesorios' => 'nullable|array',
        ]);

        $validated['es_alto_valor'] = $request->has('es_alto_valor');
        
        if ($request->has('accesorios') && is_array($request->accesorios)) {
            $processed = [];
            foreach ($request->accesorios as $item) {
                if (!empty($item['nombre'])) {
                    $processed[] = [
                        'nombre' => trim($item['nombre']),
                        'estado' => $item['estado'] ?? 'disponible'
                    ];
                }
            }
            $validated['accesorios'] = !empty($processed) ? $processed : null;
        } else {
            $validated['accesorios'] = null;
        }

        if ($request->hasFile('imagen')) {
            $validated['imagen'] = $request->file('imagen')->store('herramientas', 'public');
        }

        Herramienta::create($validated);

        return redirect()->route('herramientas.index')
            ->with('success', 'Herramienta creada exitosamente.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Herramienta $herramienta)
    {
        return view('herramientas.show', compact('herramienta'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Herramienta $herramienta)
    {
        $herramienta->load('historialQr');
        
        $lastTool = Herramienta::where('codigo_qr', 'like', 'HTA-%')->latest('id')->first();
        $nextNum = 1;
        if ($lastTool) {
            $lastNum = (int) str_replace('HTA-', '', $lastTool->codigo_qr);
            $nextNum = $lastNum + 1;
        }
        $nextCode = 'HTA-' . str_pad($nextNum, 3, '0', STR_PAD_LEFT);

        return view('herramientas.edit', compact('herramienta', 'nextCode'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Herramienta $herramienta)
    {
        $validated = $request->validate([
            'nombre' => 'required|string|max:255',
            'descripcion' => 'nullable|string',
            'codigo_qr' => 'nullable|string|unique:herramientas,codigo_qr,' . $herramienta->id,
            'estado' => 'required|in:disponible,prestado,mantenimiento,perdido',
            'ubicacion' => 'nullable|string|max:255',
            'imagen' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:10240',
            'accesorios' => 'nullable|array',
        ], [
            'codigo_qr.unique' => 'CONFLICTO: Este código ya está en uso. Revisa la herramienta: ' . 
                (\App\Models\Herramienta::where('codigo_qr', $request->codigo_qr)->first()->nombre ?? 'Desconocida'),
        ]);

        if ($request->hasFile('imagen')) {
            // Eliminar imagen anterior si existe
            if ($herramienta->imagen) {
                \Storage::disk('public')->delete($herramienta->imagen);
            }
            $validated['imagen'] = $request->file('imagen')->store('herramientas', 'public');
        }

        $validated['es_alto_valor'] = $request->has('es_alto_valor');
        
        if ($request->has('accesorios') && is_array($request->accesorios)) {
            $processed = [];
            foreach ($request->accesorios as $item) {
                if (!empty($item['nombre'])) {
                    $processed[] = [
                        'nombre' => trim($item['nombre']),
                        'estado' => $item['estado'] ?? 'disponible'
                    ];
                }
            }
            $validated['accesorios'] = !empty($processed) ? $processed : null;
        } else {
            $validated['accesorios'] = null;
        }

        $herramienta->update($validated);

        return redirect()->route('herramientas.index')
            ->with('success', 'Herramienta actualizada exitosamente.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Herramienta $herramienta)
    {
        if ($herramienta->imagen) {
            \Storage::disk('public')->delete($herramienta->imagen);
        }
        
        $herramienta->delete();

        return redirect()->route('herramientas.index')
            ->with('success', 'Herramienta eliminada exitosamente.');
    }

    /**
     * Update only the status of the tool (Fast Update).
     */
    public function actualizarEstado(Request $request, Herramienta $herramienta)
    {
        $request->validate([
            'estado' => 'required|in:disponible,prestado,mantenimiento,perdido',
        ]);

        $herramienta->update(['estado' => $request->estado]);

        return back()->with('success', 'Estado de la herramienta actualizado a: ' . ucfirst($request->estado));
    }

    /**
     * Remove the specified history item.
     */
    public function destroyHistory(\App\Models\HistorialQr $historial)
    {
        $historial->delete();
        return back()->with('success', 'Registro de historial eliminado.');
    }
}
