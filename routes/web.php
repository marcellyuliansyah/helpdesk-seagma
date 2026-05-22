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
        } elseif ($role === 'pimpinan') { 
            return redirect('/pimpinan/dashboard');
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
    } elseif ($role === 'superadmin') { // <-- TAMBAHAN UNTUK SUPER ADMIN
        return redirect('/superadmin/dashboard');
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

    Route::get('/admin/laporan/pdf', [App\Http\Controllers\AdminController::class, 'cetakPDF'])->name('admin.laporan.pdf');

    // --- RUTE MASTER DATA KATEGORI ---
    // --- RUTE MASTER DATA KATEGORI ---
Route::middleware(['auth', 'admin', 'verified', 'no-cache'])->group(function () {
    Route::get('/admin/kategori', [App\Http\Controllers\AdminController::class, 'kategori'])->name('admin.kategori');
    Route::post('/admin/kategori', [App\Http\Controllers\AdminController::class, 'storeKategori'])->name('admin.kategori.store');
    Route::delete('/admin/kategori/{id}', [App\Http\Controllers\AdminController::class, 'destroyKategori'])->name('admin.kategori.destroy');
});

// --- RUTE KHUSUS TEKNISI ---
Route::middleware(['auth', 'teknisi', 'verified', 'no-cache'])->group(function () {
    
    // Halaman Dashboard Teknisi
    Route::get('/teknisi/dashboard', [App\Http\Controllers\TeknisiController::class, 'index'])->name('teknisi.dashboard');
    
    // Rute untuk "Ambil Tiket"
    Route::patch('/teknisi/pengaduan/{id}/ambil', [App\Http\Controllers\TeknisiController::class, 'ambilTiket'])->name('teknisi.pengaduan.ambil');

    // Rute untuk "Selesaikan Tiket" (TAMBAHKAN BARIS INI)
    Route::patch('/teknisi/pengaduan/{id}/selesai', [App\Http\Controllers\TeknisiController::class, 'selesaikanTiket'])->name('teknisi.pengaduan.selesai');
});

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
Route::get('/pelanggan/pengaduan/buat', [TiketController::class, 'create'])
    ->middleware(['auth', 'verified', 'no-cache'])
    ->name('pengaduan.create');

// Rute untuk menangani proses pengiriman form (POST)
Route::post('/pelanggan/pengaduan/simpan', [TiketController::class, 'store'])
    ->middleware(['auth', 'verified', 'no-cache'])
    ->name('pengaduan.store');

// Rute untuk membatalkan pengaduan
Route::delete('/pelanggan/pengaduan/{id}', [TiketController::class, 'destroy'])
    ->middleware(['auth', 'verified', 'no-cache'])
    ->name('pengaduan.destroy');

// --- RUTE KHUSUS PIMPINAN ---
Route::middleware(['auth', 'pimpinan', 'verified', 'no-cache'])->group(function () {
    Route::get('/pimpinan/dashboard', [App\Http\Controllers\SuperAdminController::class, 'index'])->name('pimpinan.dashboard');
});

// --- RUTE KHUSUS PIMPINAN ---
Route::middleware(['auth', 'pimpinan', 'verified', 'no-cache'])->group(function () {
    Route::get('/pimpinan/dashboard', [App\Http\Controllers\SuperAdminController::class, 'index'])->name('pimpinan.dashboard');
    
    // Rute untuk Tambah Pengguna
    Route::get('/pimpinan/pengguna/tambah', [App\Http\Controllers\SuperAdminController::class, 'create'])->name('pimpinan.users.create');
    Route::post('/pimpinan/pengguna', [App\Http\Controllers\SuperAdminController::class, 'store'])->name('pimpinan.users.store');
    Route::delete('/pimpinan/pengguna/{id}', [App\Http\Controllers\SuperAdminController::class, 'destroy'])->name('pimpinan.users.destroy');
    Route::get('/pimpinan/pengguna/{id}/edit', [App\Http\Controllers\SuperAdminController::class, 'edit'])->name('pimpinan.users.edit');
    Route::put('/pimpinan/pengguna/{id}', [App\Http\Controllers\SuperAdminController::class, 'update'])->name('pimpinan.users.update');
    // --- RUTE MANAJEMEN TIKET (GOD MODE) ---
    Route::get('/pimpinan/tiket', [App\Http\Controllers\SuperAdminController::class, 'allTiket'])->name('pimpinan.tiket.index');
    Route::put('/pimpinan/tiket/{id}/reassign', [App\Http\Controllers\SuperAdminController::class, 'reassignTiket'])->name('pimpinan.tiket.reassign');
    Route::delete('/pimpinan/tiket/{id}/hapus', [App\Http\Controllers\SuperAdminController::class, 'destroyTiket'])->name('pimpinan.tiket.destroy');
    // --- RUTE PENGATURAN SISTEM ---
    Route::get('/pimpinan/pengaturan', [App\Http\Controllers\SuperAdminController::class, 'pengaturan'])->name('pimpinan.pengaturan');
    Route::put('/pimpinan/pengaturan', [App\Http\Controllers\SuperAdminController::class, 'updatePengaturan'])->name('pimpinan.pengaturan.update');
});