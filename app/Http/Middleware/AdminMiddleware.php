<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Session;

class AdminMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Si no hay sesión
        if (!Session::has('usuario')) {
            return redirect('/login');
        }

        $usuario = Session::get('usuario');

        // Si NO es admin
        if ($usuario->tipo !== 'admin') {
            return redirect('/prestamos'); // lo mandas a otra vista
        }

        return $next($request);
    }
}
