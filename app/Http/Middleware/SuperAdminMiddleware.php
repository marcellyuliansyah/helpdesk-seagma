<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class SuperAdminMiddleware
{
    public function handle(Request $request, Closure $next): Response
    {
        // Ubah pengecekan menjadi 'pimpinan'
        if (Auth::check() && Auth::user()->role === 'pimpinan') {
            return $next($request);
        }

        return redirect('/dashboard');
    }
}