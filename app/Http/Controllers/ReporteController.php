<?php

namespace App\Http\Controllers;

use App\Models\Peticion;
use App\Models\Prestamo;
use App\Models\Herramienta;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ReporteController extends Controller
{
    /**
     * Vista principal de reportes para el coordinador.
     */
    public function index()
    {
        return view('reportes.index');
    }

    /**
     * Dashboard interactivo de bitácoras.
     */
    public function bitacora(Request $request)
    {
        $query = Prestamo::with(['usuario', 'herramienta'])->latest();

        if ($request->filled('fecha')) {
            $query->whereDate('created_at', $request->fecha);
        }

        $prestamos = $query->paginate(20)->withQueryString();
        return view('reportes.bitacora', compact('prestamos'));
    }

    /**
     * Descargar el PDF de una petición individual (Solo Admin).
     */
    public function descargarPeticion(Peticion $peticion)
    {
        // Solo el coordinador puede descargar el reporte oficial
        if (!Auth::user()->esAdmin()) {
            abort(403, 'Acceso restringido.');
        }

        $peticion->load(['usuario', 'docente', 'prestamos.herramienta']);

        $pdf = Pdf::loadView('peticiones.pdf', compact('peticion'));
        
        return $pdf->download("Peticion_{$peticion->id}_{$peticion->usuario->nombre}.pdf");
    }

    /**
     * Generar reporte consolidado por periodo.
     */
    public function generarConsolidado(Request $request)
    {
        $request->validate([
            'fecha_inicio' => 'required|date',
            'fecha_fin' => 'required|date|after_or_equal:fecha_inicio',
        ]);

        $inicio = Carbon::parse($request->fecha_inicio)->startOfDay();
        $fin = Carbon::parse($request->fecha_fin)->endOfDay();

        // 1. Bitácora Cronológica de Actividad
        $peticiones = Peticion::with(['usuario', 'docente', 'prestamos.herramienta'])
            ->whereBetween('created_at', [$inicio, $fin])
            ->latest()
            ->get();

        // 2. Resumen Ejecutivo (Lo más usado)
        // Obtenemos las herramientas más prestadas en los préstamos vinculados a estas peticiones
        $herramientasMasUsadas = DB::table('prestamos')
            ->join('herramientas', 'prestamos.herramienta_id', '=', 'herramientas.id')
            ->join('peticiones', 'prestamos.peticion_id', '=', 'peticiones.id')
            ->select('herramientas.nombre', DB::raw('count(*) as total'))
            ->whereBetween('peticiones.created_at', [$inicio, $fin])
            ->groupBy('herramientas.id', 'herramientas.nombre')
            ->orderByDesc('total')
            ->limit(5)
            ->get();

        $pdf = Pdf::loadView('reportes.pdf_consolidado', [
            'peticiones' => $peticiones,
            'inicio' => $inicio->format('d/m/Y'),
            'fin' => $fin->format('d/m/Y'),
            'estadisticas' => $herramientasMasUsadas
        ]);

        return $pdf->download("Reporte_Periodo_{$inicio->format('d_m_Y')}_a_{$fin->format('d_m_Y')}.pdf");
    }

    /**
     * Generar reporte detallado del Inventario Técnico.
     */
    public function generarInventario()
    {
        if (!Auth::user()->esAdmin()) {
            abort(403);
        }

        $herramientas = Herramienta::orderBy('estado')->get();
        $total = $herramientas->count();
        $porEstado = $herramientas->groupBy('estado')->map->count();

        $pdf = Pdf::loadView('reportes.pdf_inventario', [
            'herramientas' => $herramientas,
            'total' => $total,
            'porEstado' => $porEstado,
            'fecha' => now()->format('d/m/Y H:i')
        ]);

        return $pdf->download("Reporte_Inventario_" . now()->format('d_m_Y') . ".pdf");
    }

    /**
     * Generar reporte de Historial de Préstamos (Filtro por Cédula/Semestre).
     */
    public function generarEstudiantil(Request $request)
    {
        if (!Auth::user()->esAdmin()) {
            abort(403);
        }

        $query = \App\Models\Usuario::where('rol', 'estudiante');

        if ($request->filled('cedula')) {
            $query->where('cedula', $request->cedula);
        }

        if ($request->filled('semestre')) {
            $query->where('semestre', $request->semestre);
        }

        $estudiantes = $query->with(['prestamos.herramienta'])->get();

        $pdf = Pdf::loadView('reportes.pdf_historial', [
            'estudiantes' => $estudiantes,
            'filtro_cedula' => $request->cedula,
            'filtro_semestre' => $request->semestre,
            'fecha' => now()->format('d/m/Y H:i')
        ]);

        return $pdf->download("Historial_Prestamos_" . now()->format('d_m_Y') . ".pdf");
    }
}

