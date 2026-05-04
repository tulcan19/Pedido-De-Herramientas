<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AdminMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if ($request->user()) {
            if ($request->user()->esAdmin()) {
                return $next($request);
            }

            if ($request->user()->esDocente()) {
                $allowedForDocentes = [
                    'usuarios.index',
                    'usuarios.promover',
                    'usuarios.update',
                    'reportes.bitacora',
                    'peticiones.entrega',
                    'peticiones.procesar-entrega',
                    'herramientas.status-update',
                    'herramientas.historial.destroy',
                ];

                if (in_array($request->route()->getName(), $allowedForDocentes)) {
                    return $next($request);
                }
            }
        }

        return redirect('/dashboard')->with('error', 'No tienes permisos para acceder a esta sección.');
    }
}
