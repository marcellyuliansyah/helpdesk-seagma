<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\TiketController;
use Illuminate\Support\Facades\Route;
use App\Models\Tiket;
use Illuminate\Support\Facades\Auth;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

Route::get('/', function () {
    if (Auth::check()) {
        $role = Auth::user()->role;
        if ($role === 'pelanggan') {
            return redirect('/pelanggan/dashboard');
        } elseif ($role === 'admin') {
            return redirect('/admin/dashboard'); 
        } elseif ($role === 'teknisi') {
            return redirect('/teknisi/dashboard');
        }
        return redirect('/dashboard');
    }
    return view('welcome');
});

Route::get('/dashboard', function () {
    $role = Auth::user()->role ?? 'user';
    
    if ($role === 'pelanggan') {
        return redirect('/pelanggan/dashboard');
    } elseif ($role === 'admin') {
        return redirect('/admin/dashboard');
    } elseif ($role === 'teknisi') {
        return redirect('/teknisi/dashboard');
    }

    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';

// --- RUTE KHUSUS ADMIN ---
Route::get('/admin/dashboard', [App\Http\Controllers\AdminController::class, 'index'])
    ->middleware(['auth', 'admin', 'verified', 'no-cache'])
    ->name('admin.dashboard');

// Tambahkan 2 rute ini:
Route::get('/admin/pengaduan/{id}', [App\Http\Controllers\AdminController::class, 'show'])
    ->middleware(['auth', 'admin', 'verified', 'no-cache'])
    ->name('admin.pengaduan.show');

Route::patch('/admin/pengaduan/{id}/status', [App\Http\Controllers\AdminController::class, 'updateStatus'])
    ->middleware(['auth', 'admin', 'verified', 'no-cache'])
    ->name('admin.pengaduan.updateStatus');

// --- RUTE KHUSUS TEKNISI ---
Route::get('/teknisi/dashboard', function () {
    return view('teknisi-dashboard'); 
})->middleware(['auth', 'teknisi', 'verified']);

// --- RUTE KHUSUS PELANGGAN ---
Route::get('/pelanggan/dashboard', function () {
    $tiketAktif = Tiket::where('pelanggan_id', Auth::id())
                       ->whereIn('status', ['menunggu verifikasi', 'diproses'])
                       ->first();

    $riwayatTiket = Tiket::where('pelanggan_id', Auth::id())
                         ->where('status', 'selesai')
                         ->orderBy('created_at', 'desc')
                         ->get();

    return view('pelanggan-dashboard', compact('tiketAktif', 'riwayatTiket'));
})->middleware(['auth', 'verified', 'no-cache'])->name('pelanggan.dashboard');

// Rute untuk menampilkan form pengaduan
Route::get('/pelanggan/pengaduan/buat', function () {
    return view('pengaduan-create');
})->middleware(['auth', 'verified', 'no-cache'])->name('pengaduan.create');

// Rute untuk menangani proses pengiriman form (POST)
Route::post('/pelanggan/pengaduan/simpan', [TiketController::class, 'store'])
    ->middleware(['auth', 'verified', 'no-cache'])
    ->name('pengaduan.store');

// Rute untuk membatalkan pengaduan
Route::delete('/pelanggan/pengaduan/{id}', [TiketController::class, 'destroy'])
    ->middleware(['auth', 'verified', 'no-cache'])
    ->name('pengaduan.destroy');