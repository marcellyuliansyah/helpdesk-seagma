<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RoleTeknisi
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Cek apakah dia sudah login dan apakah perannya 'teknisi'
        if (auth()->check() && auth()->user()->role === 'teknisi') {
            return $next($request); // Silakan masuk
        }

        // Jika bukan teknisi, tendang ke dashboard pelanggan
        return redirect('/pelanggan/dashboard'); 
    }
}
