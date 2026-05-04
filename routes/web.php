<?php

use App\Http\Controllers\HerramientaController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    $user = auth()->user();
    
    if ($user->esAdmin()) {
        $peticiones = \App\Models\Peticion::with(['prestamos.herramienta', 'usuario'])->whereIn('estado', ['enviado'])->latest()->get();
        $prestamos = \App\Models\Prestamo::with('herramienta')->whereIn('estado', ['reservado', 'activo', 'atrasado'])->latest()->get();
        $prestamosTotales = \App\Models\Prestamo::count();
    } elseif ($user->esDocente()) {
        $peticiones = $user->peticionesAsignadas()->with(['prestamos.herramienta', 'usuario'])->latest()->get();
        $prestamos = collect();
        foreach($peticiones as $peticion) {
            foreach($peticion->prestamos as $prestamo) {
                if (in_array($prestamo->estado, ['reservado', 'activo', 'atrasado'])) {
                    $prestamos->push($prestamo);
                }
            }
        }
        $prestamosTotales = $prestamos->count();
    } else {
        $peticiones = $user->peticiones()->with('prestamos.herramienta')->whereIn('estado', ['enviado'])->latest()->get();
        $prestamos = $user->prestamos()->with('herramienta')->whereIn('estado', ['reservado', 'activo', 'atrasado'])->latest()->get();
        $prestamosTotales = $user->prestamos()->count();
    }
    
    $alertas = $prestamos->filter(function($p) {
        return $p->herramienta->es_alto_valor;
    })->count();

    return view('dashboard', compact('prestamos', 'peticiones', 'prestamosTotales', 'alertas'));
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::middleware('admin')->group(function () {
        Route::resource('herramientas', HerramientaController::class)->except(['index', 'show']);
        Route::get('/usuarios', [\App\Http\Controllers\UsuarioController::class, 'index'])->name('usuarios.index');
        Route::post('/usuarios/{usuario}/promover', [\App\Http\Controllers\UsuarioController::class, 'promover'])->name('usuarios.promover');
        Route::put('/usuarios/{usuario}', [\App\Http\Controllers\UsuarioController::class, 'estudiantesUpdate'])->name('usuarios.update');

        // Recepción de Formato (Peticiones)
        // Salida de Herramientas (Entregas)
        Route::get('/peticion/{peticion}/entrega', [\App\Http\Controllers\PeticionController::class, 'entrega'])->name('peticiones.entrega');
        Route::post('/peticion/{peticion}/procesar-entrega', [\App\Http\Controllers\PeticionController::class, 'procesarEntrega'])->name('peticiones.procesar-entrega');
        Route::post('/herramientas/{herramienta}/status', [\App\Http\Controllers\HerramientaController::class, 'actualizarEstado'])->name('herramientas.status-update');
        Route::delete('/herramientas/historial/{historial}', [\App\Http\Controllers\HerramientaController::class, 'destroyHistory'])->name('herramientas.historial.destroy');

        // Gestión de Docentes
        Route::get('/docentes', [\App\Http\Controllers\UsuarioController::class, 'docentesIndex'])->name('docentes.index');
        Route::post('/docentes', [\App\Http\Controllers\UsuarioController::class, 'docentesStore'])->name('docentes.store');
        Route::put('/docentes/{usuario}', [\App\Http\Controllers\UsuarioController::class, 'docentesUpdate'])->name('docentes.update');
        Route::delete('/docentes/{usuario}', [\App\Http\Controllers\UsuarioController::class, 'docentesDestroy'])->name('docentes.destroy');

        // Reportes PDF
        Route::get('/reportes', [\App\Http\Controllers\ReporteController::class, 'index'])->name('reportes.index');
        Route::get('/bitacora', [\App\Http\Controllers\ReporteController::class, 'bitacora'])->name('reportes.bitacora');
        Route::get('/reporte-peticion/{peticion}/pdf', [\App\Http\Controllers\ReporteController::class, 'descargarPeticion'])->name('reportes.peticion');
        Route::post('/reporte-periodo', [\App\Http\Controllers\ReporteController::class, 'generarConsolidado'])->name('reportes.consolidado');
        Route::post('/reporte-inventario', [\App\Http\Controllers\ReporteController::class, 'generarInventario'])->name('reportes.inventario');
        Route::post('/reporte-historial', [\App\Http\Controllers\ReporteController::class, 'generarEstudiantil'])->name('reportes.historial');
    });

    Route::resource('herramientas', HerramientaController::class)->only(['index', 'show']);
    Route::post('/prestamos/reservar', [\App\Http\Controllers\PrestamoController::class, 'store'])->name('prestamos.store');
    
    Route::get('/notificaciones', [\App\Http\Controllers\NotificationController::class, 'index'])->name('notificaciones.index');
    Route::get('/notificaciones/{id}/leer', [\App\Http\Controllers\NotificationController::class, 'read'])->name('notificaciones.leer');

    // Devoluciones (Accesible por Estudiante y Admin)
    Route::get('/prestamos/{prestamo}/devolver', [\App\Http\Controllers\PrestamoController::class, 'devolver'])->name('prestamos.devolver');
    Route::get('/prestamos/{prestamo}/comprobante', [\App\Http\Controllers\PrestamoController::class, 'comprobante'])->name('prestamos.comprobante');
    Route::post('/prestamos/auditar-todos', [\App\Http\Controllers\PrestamoController::class, 'auditarTodos'])->name('prestamos.auditar-todos');
    Route::post('/prestamos/{prestamo}/auditar', [\App\Http\Controllers\PrestamoController::class, 'auditar'])->name('prestamos.auditar');
    Route::post('/prestamos/{prestamo}/procesar-devolucion', [\App\Http\Controllers\PrestamoController::class, 'procesarDevolucion'])->name('prestamos.procesar-devolucion');
    Route::post('/prestamos/{prestamo}/devolucion-rapida', [\App\Http\Controllers\PrestamoController::class, 'devolucionRapida'])->name('prestamos.devolucion-rapida');

    // Carrito de Solicitud (Peticiones)
    Route::post('/peticion/add/{herramienta}', [\App\Http\Controllers\PeticionController::class, 'addCart'])->name('peticiones.add');
    Route::get('/peticion/qr-add/{herramienta}', [\App\Http\Controllers\PeticionController::class, 'qrAddCart'])->name('peticiones.qr-add');
    Route::post('/peticion/remove/{herramienta}', [\App\Http\Controllers\PeticionController::class, 'removeCart'])->name('peticiones.remove');
    Route::get('/peticion/crear', [\App\Http\Controllers\PeticionController::class, 'create'])->name('peticiones.create');
    Route::post('/peticion/store', [\App\Http\Controllers\PeticionController::class, 'store'])->name('peticiones.store');
    Route::post('/peticion/{peticion}/aprobar', [\App\Http\Controllers\PeticionController::class, 'aprobarDocente'])->name('peticiones.aprobar-docente');
});

require __DIR__.'/auth.php';

// Ruta de emergencia para servir imágenes en servidores sin storage:link
Route::get('/storage/{path}', function ($path) {
    $path = str_replace('..', '', $path); // Seguridad básica
    if (!\Illuminate\Support\Facades\Storage::disk('public')->exists($path)) {
        abort(404);
    }
    
    $file = \Illuminate\Support\Facades\Storage::disk('public')->get($path);
    $type = \Illuminate\Support\Facades\Storage::disk('public')->mimeType($path);
    
    return response($file)->header('Content-Type', $type);
})->where('path', '.*');
