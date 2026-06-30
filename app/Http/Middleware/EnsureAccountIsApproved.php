<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class EnsureAccountIsApproved
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Cek apakah pengguna sudah login
        if (Auth::check()) {
            $user = Auth::user();

            // Jika dia adalah teknisi DAN belum disetujui (is_approved == false)
            if ($user->role === 'teknisi' && !$user->is_approved) {
                // Paksa logout
                Auth::logout();

                // Batalkan sesi saat ini agar aman
                $request->session()->invalidate();
                $request->session()->regenerateToken();

                // Lempar kembali ke halaman login dengan pesan error
                return redirect()->route('login')->with('error', 'Akun Teknisi Anda belum divalidasi oleh Pimpinan. Silakan hubungi pihak terkait.');
            }
        }

        return $next($request);
    }
}