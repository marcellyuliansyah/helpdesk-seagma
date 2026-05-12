<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RoleMiddleware
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next, $role): Response
    {
        // Cek apakah user sudah login dan apakah role-nya sesuai
        if ($request->user() && $request->user()->role !== $role) {
            
            // HAPUS KATA 'return' DI BAWAH INI
            abort(403, 'Maaf, Anda tidak memiliki akses ke halaman ini.');
            
        }

        return $next($request);
    }
}