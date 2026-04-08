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
        $prestamos = \App\Models\Prestamo::with('herramienta')->whereIn('estado', ['reservado', 'activo', 'atrasado'])->latest()->get();
    } else {
        $prestamos = $user->prestamos()->with('herramienta')->whereIn('estado', ['reservado', 'activo', 'atrasado'])->latest()->get();
    }
    
    $prestamosTotales = $user->esAdmin() ? \App\Models\Prestamo::count() : $user->prestamos()->count();
    $alertas = $prestamos->filter(function($p) {
        return $p->estado == 'atrasado' || \Carbon\Carbon::now()->addMinutes(30)->gt($p->fecha_devolucion_esperada);
    })->count();

    return view('dashboard', compact('prestamos', 'prestamosTotales', 'alertas'));
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::middleware('admin')->group(function () {
        Route::resource('herramientas', HerramientaController::class)->except(['index', 'show']);
        Route::get('/usuarios', [\App\Http\Controllers\UsuarioController::class, 'index'])->name('usuarios.index');
        Route::post('/usuarios/{usuario}/promover', [\App\Http\Controllers\UsuarioController::class, 'promover'])->name('usuarios.promover');
    });

    Route::resource('herramientas', HerramientaController::class)->only(['index', 'show']);
    Route::post('/prestamos/reservar', [\App\Http\Controllers\PrestamoController::class, 'store'])->name('prestamos.store');
    
    Route::get('/notificaciones/{id}/leer', function($id) {
        $notification = auth()->user()->notifications()->findOrFail($id);
        $notification->markAsRead();
        return back()->with('success', 'Notificación marcada como leída');
    })->name('notificaciones.leer');
});

require __DIR__.'/auth.php';
