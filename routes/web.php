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
    } else {
        $peticiones = $user->peticiones()->with('prestamos.herramienta')->whereIn('estado', ['enviado'])->latest()->get();
        $prestamos = $user->prestamos()->with('herramienta')->whereIn('estado', ['reservado', 'activo', 'atrasado'])->latest()->get();
    }
    
    $prestamosTotales = $user->esAdmin() ? \App\Models\Prestamo::count() : $user->prestamos()->count();
    $alertas = $prestamos->filter(function($p) {
        return $p->estado == 'atrasado' || \Carbon\Carbon::now()->addMinutes(30)->gt($p->fecha_devolucion_esperada);
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

        // Recepción de Formato (Peticiones)
        Route::post('/peticion/{peticion}/aprobar', [\App\Http\Controllers\PeticionController::class, 'aprobar'])->name('peticiones.aprobar');

        // Gestión de Docentes
        Route::get('/docentes', [\App\Http\Controllers\UsuarioController::class, 'docentesIndex'])->name('docentes.index');
        Route::post('/docentes', [\App\Http\Controllers\UsuarioController::class, 'docentesStore'])->name('docentes.store');
        Route::delete('/docentes/{usuario}', [\App\Http\Controllers\UsuarioController::class, 'docentesDestroy'])->name('docentes.destroy');

        // Reportes PDF
        Route::get('/reportes', [\App\Http\Controllers\ReporteController::class, 'index'])->name('reportes.index');
        Route::get('/reporte-peticion/{peticion}/pdf', [\App\Http\Controllers\ReporteController::class, 'descargarPeticion'])->name('reportes.peticion');
        Route::post('/reporte-periodo', [\App\Http\Controllers\ReporteController::class, 'generarConsolidado'])->name('reportes.consolidado');
        Route::post('/reporte-inventario', [\App\Http\Controllers\ReporteController::class, 'generarInventario'])->name('reportes.inventario');
        Route::post('/reporte-historial', [\App\Http\Controllers\ReporteController::class, 'generarEstudiantil'])->name('reportes.historial');
    });

    Route::resource('herramientas', HerramientaController::class)->only(['index', 'show']);
    Route::post('/prestamos/reservar', [\App\Http\Controllers\PrestamoController::class, 'store'])->name('prestamos.store');
    
    Route::get('/notificaciones/{id}/leer', function($id) {
        $notification = auth()->user()->notifications()->findOrFail($id);
        $notification->markAsRead();
        return back()->with('success', 'Notificación marcada como leída');
    })->name('notificaciones.leer');

    // Devoluciones (Accesible por Estudiante y Admin)
    Route::get('/prestamos/{prestamo}/devolver', [\App\Http\Controllers\PrestamoController::class, 'devolver'])->name('prestamos.devolver');
    Route::post('/prestamos/{prestamo}/procesar-devolucion', [\App\Http\Controllers\PrestamoController::class, 'procesarDevolucion'])->name('prestamos.procesar-devolucion');
    Route::post('/prestamos/{prestamo}/devolucion-rapida', [\App\Http\Controllers\PrestamoController::class, 'devolucionRapida'])->name('prestamos.devolucion-rapida');

    // Carrito de Solicitud (Peticiones)
    Route::post('/peticion/add/{herramienta}', [\App\Http\Controllers\PeticionController::class, 'addCart'])->name('peticiones.add');
    Route::post('/peticion/remove/{herramienta}', [\App\Http\Controllers\PeticionController::class, 'removeCart'])->name('peticiones.remove');
    Route::get('/peticion/crear', [\App\Http\Controllers\PeticionController::class, 'create'])->name('peticiones.create');
    Route::post('/peticion/store', [\App\Http\Controllers\PeticionController::class, 'store'])->name('peticiones.store');
});

require __DIR__.'/auth.php';
