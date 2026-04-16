<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CheckActiveSession
{
    public function handle(Request $request, Closure $next)
    {
        // Verificar si el usuario está autenticado
        if (!Auth::check()) {
            // Limpiar carrito
            $request->session()->forget('cart');
            
            // Guardar mensaje
            session()->flash('error', 'Tu sesión ha expirado. Por favor, inicia sesión nuevamente.');
            
            // Redirigir al login
            return redirect()->route('login');
        }
        
        return $next($request);
    }
}