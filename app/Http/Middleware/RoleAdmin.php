<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RoleAdmin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Cek apakah dia sudah login dan apakah perannya 'admin'
        if (auth()->check() && auth()->user()->role === 'admin') {
            return $next($request); // Silakan masuk
        }

        // Jika bukan admin, tendang kembali ke dashboard biasa
        return redirect('/dashboard'); 
    }
}
