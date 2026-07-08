<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\TiketController;
use App\Http\Controllers\TeknisiController;
use App\Http\Controllers\SuperAdminController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Models\Tiket;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// --- 1. RUTE UMUM / AUTENTIKASI ---
Route::get('/', function () {
    if (Auth::check()) {
        $role = Auth::user()->role;
        if ($role === 'pelanggan') return redirect('/pelanggan/dashboard');
        if ($role === 'admin') return redirect('/admin/dashboard');
        if ($role === 'teknisi') return redirect('/teknisi/dashboard');
        if ($role === 'pimpinan') return redirect('/pimpinan/dashboard');
        return redirect('/dashboard');
    }
    return view('welcome');
});

Route::get('/dashboard', function () {
    $role = Auth::user()->role ?? 'user';
    if ($role === 'pelanggan') return redirect('/pelanggan/dashboard');
    if ($role === 'admin') return redirect('/admin/dashboard');
    if ($role === 'teknisi') return redirect('/teknisi/dashboard');
    if ($role === 'superadmin' || $role === 'pimpinan') return redirect('/pimpinan/dashboard');

    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__ . '/auth.php';


// --- 2. RUTE KHUSUS ADMIN (CENTRALIZED DISPATCHING) ---
Route::middleware(['auth', 'admin', 'verified', 'no-cache'])->group(function () {
    
    // Dashboard Admin
    Route::get('/admin/dashboard', [AdminController::class, 'index'])->name('admin.dashboard');
    
    // Manajemen User oleh Admin (Pelanggan, Admin, Teknisi, Pimpinan)
    Route::get('/admin/users', [AdminController::class, 'users'])->name('admin.users'); // Menangani Tampilan, Pencarian, & Filter
    Route::post('/admin/users', [AdminController::class, 'store'])->name('admin.users.store'); // Disinkronkan ke method 'store'
    Route::get('/admin/users/{id}/edit', [AdminController::class, 'edit'])->name('admin.users.edit');
    Route::delete('/admin/users/{id}', [AdminController::class, 'destroyUser'])->name('admin.users.destroy'); // Disinkronkan ke method 'destroy'
    
    // Kendali Mutlak Manajemen Shift/Libur Teknisi oleh Admin
    Route::patch('/admin/users/{id}/update-hari-libur', [AdminController::class, 'updateHariLibur'])->name('admin.users.update-hari-libur');

    // Manajemen Tiket & Pendelegasian Tugas (Dispatching)
    Route::get('/admin/pengaduan/{id}', [AdminController::class, 'show'])->name('admin.pengaduan.show');
    Route::patch('/admin/pengaduan/{id}/status', [AdminController::class, 'updateStatus'])->name('admin.pengaduan.updateStatus');
    Route::patch('/admin/pengaduan/{id}/assign', [AdminController::class, 'assignTeknisi'])->name('admin.pengaduan.assign'); // Form Pilih Teknisi

    // Master Data Kategori
    Route::get('/admin/kategori', [AdminController::class, 'kategori'])->name('admin.kategori');
    Route::post('/admin/kategori', [AdminController::class, 'storeKategori'])->name('admin.kategori.store');
    Route::delete('/admin/kategori/{id}', [AdminController::class, 'destroyKategori'])->name('admin.kategori.destroy');

    // Cetak Laporan
    Route::get('/admin/laporan/pdf', [AdminController::class, 'cetakPDF'])->name('admin.cetak.pdf');
});


// --- 3. RUTE KHUSUS TEKNISI (FOKUS OPERASIONAL LAPANGAN) ---
Route::middleware(['auth', 'teknisi', 'approved', 'verified', 'no-cache'])->group(function () {
    // Halaman Dashboard Teknisi
    Route::get('/teknisi/dashboard', [TeknisiController::class, 'index'])->name('teknisi.dashboard');

    // Penyelesaian tugas lapangan (Wajib Upload Foto Bukti)
    Route::patch('/teknisi/pengaduan/{id}/selesai', [TeknisiController::class, 'selesaikanTugas'])->name('teknisi.pengaduan.selesai');
    
    // JALUR TOGGLE MANDIRI TEKNISI SUDAH DIHAPUS DEMI KEAMANAN SOP
});


// --- 4. RUTE KHUSUS PELANGGAN ---
Route::middleware(['auth', 'verified', 'no-cache'])->group(function () {
    Route::get('/pelanggan/dashboard', function () {
        $tiketAktif = Tiket::where('pelanggan_id', Auth::id())
            ->whereIn('status', ['menunggu verifikasi', 'diproses'])
            ->first();

        $riwayatTiket = Tiket::where('pelanggan_id', Auth::id())
            ->where('status', 'selesai')
            ->orderBy('created_at', 'desc')
            ->get();

        return view('pelanggan-dashboard', compact('tiketAktif', 'riwayatTiket'));
    })->name('pelanggan.dashboard');

    Route::get('/pelanggan/pengaduan/buat', [TiketController::class, 'create'])->name('pengaduan.create');
    Route::post('/pelanggan/pengaduan/simpan', [TiketController::class, 'store'])->name('pengaduan.store');
    Route::delete('/pelanggan/pengaduan/{id}', [TiketController::class, 'destroy'])->name('pengaduan.destroy');
});


// --- 5. RUTE KHUSUS PIMPINAN / SUPERADMIN ---
Route::middleware(['auth', 'pimpinan', 'verified', 'no-cache'])->group(function () {
    // Dashboard & Data Users
    Route::get('/pimpinan/dashboard', [SuperAdminController::class, 'index'])->name('pimpinan.dashboard');
    Route::get('/pimpinan/users/{role}', [SuperAdminController::class, 'daftarUser'])->name('pimpinan.users.list');

    // Rute Manajemen Pengguna (CRUD Pimpinan)
    Route::get('/pimpinan/pengguna/tambah', [SuperAdminController::class, 'create'])->name('pimpinan.users.create');
    Route::post('/pimpinan/pengguna', [SuperAdminController::class, 'store'])->name('pimpinan.users.store');
    Route::get('/pimpinan/pengguna/{id}/edit', [SuperAdminController::class, 'edit'])->name('pimpinan.users.edit');
    Route::put('/pimpinan/pengguna/{id}', [SuperAdminController::class, 'update'])->name('pimpinan.users.update');
    Route::delete('/pimpinan/pengguna/{id}', [SuperAdminController::class, 'destroy'])->name('pimpinan.users.destroy');
    
    // Rute Validasi Akun oleh Pimpinan
    Route::get('/pimpinan/validasi-teknisi', [SuperAdminController::class, 'validasiTeknisi'])->name('pimpinan.validasi.teknisi');
    Route::patch('/pimpinan/users/{id}/approve', [SuperAdminController::class, 'approveTeknisi'])->name('pimpinan.users.approve');
    
    // Rute verifikasi pimpinan
    Route::patch('/pimpinan/user/{id}/verifikasi', [AdminController::class, 'verifikasiUser'])->name('pimpinan.user.verifikasi');
    Route::patch('/pimpinan/user/{id}/tolak', [AdminController::class, 'tolakUser'])->name('pimpinan.user.tolak');

    // Management Tiket (God Mode Pimpinan)
    Route::get('/pimpinan/tiket', [SuperAdminController::class, 'allTiket'])->name('pimpinan.tiket.index');
    Route::get('/pimpinan/tiket/{id}/detail', [SuperAdminController::class, 'showTiket'])->name('pimpinan.tiket.show');
    Route::put('/pimpinan/tiket/{id}/reassign', [SuperAdminController::class, 'reassignTiket'])->name('pimpinan.tiket.reassign');
    Route::delete('/pimpinan/tiket/{id}/hapus', [SuperAdminController::class, 'destroyTiket'])->name('pimpinan.tiket.destroy');
    
    // Pengaturan Sistem
    Route::get('/pimpinan/pengaturan', [SuperAdminController::class, 'pengaturan'])->name('pimpinan.pengaturan');
    Route::put('/pimpinan/pengaturan', [SuperAdminController::class, 'updatePengaturan'])->name('pimpinan.pengaturan.update');
});