<?php

namespace App\Http\Controllers;

use App\Models\Tiket;
use Illuminate\Http\Request;
use App\Models\User;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Models\Kategori;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;

class AdminController extends Controller
{
    // --- TAMPILAN DASHBOARD UTAMA ADMIN ---
    public function index()
    {
        $stats = [
            'total' => Tiket::count(),
            'pending' => Tiket::where('status', 'menunggu verifikasi')->count(),
            'proses' => Tiket::where('status', 'diproses')->count(),
            'selesai' => Tiket::where('status', 'selesai')->count(),
        ];

        $semuaTiket = Tiket::with([
            'pelanggan',
            'teknisi',
            'kategori'
        ])->latest()->get();

        // Mengambil hari ini secara lokal Indonesia untuk filter kesibukan/libur di dashboard (jika diperlukan)
        $hariIni = \Carbon\Carbon::now()->locale('id')->isoFormat('dddd');

        // Mengambil semua data teknisi aktif beserta jumlah tugasnya yang berstatus 'diproses'
        $teknisi = User::where('role', 'teknisi')
            ->where('status', 'aktif')
            ->withCount(['tugasTeknisi as tugas_aktif' => function ($query) {
                $query->where('status', 'diproses');
            }])
            ->get();

        return view('admin-dashboard', compact('stats', 'semuaTiket', 'teknisi'));
    }

    // --- FUNGSI SHOW DETAIL TIKET & DISPATCHING TEKNISI (LOGIKA FILTER UTAMA) ---
    public function show($id)
    {
        // Mengambil data tiket beserta relasi pelanggan, teknisi, dan kategori
        $tiket = Tiket::with(['pelanggan', 'teknisi', 'kategori'])->findOrFail($id);
        
        // 1. Deteksi Otomatis Hari dan Jam Kerja
        $hariIni = \Carbon\Carbon::now()->locale('id')->isoFormat('dddd');
        $jamSekarang = \Carbon\Carbon::now('Asia/Jakarta')->format('H:i');
        $jamMasuk = '07:00';
        $jamPulang = '17:00';
        
        $isLuarJamKerja = ($jamSekarang < $jamMasuk || $jamSekarang > $jamPulang);

        // 2. Ambil Semua data Teknisi Aktif
        $allTeknisi = User::where('role', 'teknisi')
            ->where('status', 'aktif') // Menggunakan 'status' => 'aktif' agar sinkron dengan fungsi index()
            ->withCount(['tugasTeknisi as tugas_aktif' => function ($query) {
                $query->where('status', 'diproses');
            }])
            ->orderBy('tugas_aktif', 'asc')
            ->get();

        // 3. Ambil data kecamatan dari pelanggan yang membuat tiket/laporan
        $kecamatanPelanggan = $tiket->pelanggan ? $tiket->pelanggan->kecamatan : null;

        // 4. LOGIKA FILTER: Menyaring teknisi berdasarkan jam kerja, status libur, beban kerja, dan WILAYAH KECAMATAN
        if ($isLuarJamKerja) {
            // Jika di luar jam kerja, kosongkan pilihan (kecuali jika sudah ada teknisi yang ditugaskan di tiket ini)
            $teknisis = $allTeknisi->filter(function ($teknisi) use ($tiket) {
                return $teknisi->id == $tiket->teknisi_id;
            });
        } else {
            $teknisis = $allTeknisi->filter(function ($teknisi) use ($hariIni, $tiket, $kecamatanPelanggan) {
                $isLibur = ($teknisi->hari_libur === $hariIni);
                $isSibuk = ($teknisi->tugas_aktif > 0 && $tiket->teknisi_id != $teknisi->id);
                
                // LOGIKA IDE 2: Memeriksa apakah kecamatan tugas teknisi cocok dengan kecamatan rumah pelanggan
                $isSatuWilayah = false;
                if ($kecamatanPelanggan && $teknisi->kecamatan_tugas) {
                    // Menggunakan strtolower untuk menghindari error karena perbedaan huruf kapital (misal: "Jatiroto" vs "jatiroto")
                    $isSatuWilayah = (strtolower($teknisi->kecamatan_tugas) === strtolower($kecamatanPelanggan));
                }
                
                // SYARAT LOLOS SELEKSI TEKNISI DI DROPDOWN DETAIL TIKET:
                // 1. Dia adalah teknisi yang memang sudah ditugaskan di tiket ini sebelumnya (supaya namanya tidak hilang saat diedit), ATAU
                // 2. Dia berada di wilayah kecamatan yang sama, TIDAK sedang libur, dan TIDAK sedang sibuk memegang tiket 'diproses' lain.
                return ($teknisi->id == $tiket->teknisi_id) || ($isSatuWilayah && !$isLibur && !$isSibuk);
            });
        }

        return view('admin-tiket-detail', compact('tiket', 'teknisis', 'isLuarJamKerja'));
    }

    // --- FUNGSI UPDATE STATUS TIKET ---
    public function updateStatus(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:menunggu verifikasi,diproses,selesai',
            'teknisi_id' => 'nullable|exists:users,id'
        ]);

        $tiket = Tiket::findOrFail($id);

        $tiket->status = $request->status;
        
        // Hanya update teknisi_id jika ada dalam request
        if($request->has('teknisi_id')) {
            $tiket->teknisi_id = $request->teknisi_id;
        }

        if ($request->teknisi_id && $tiket->status == 'menunggu verifikasi') {
            $tiket->status = 'diproses';
        }

        $tiket->save();

        return redirect()
            ->route('admin.dashboard')
            ->with('success', 'Data tiket berhasil diperbarui!');
    }

    // --- FUNGSI ASSIGN TEKNISI (PENDELEGASIAN) ---
    public function assignTeknisi(Request $request, $id)
    {
        $request->validate([
            'teknisi_id' => 'required|exists:users,id'
        ]);
        
        $tiket = Tiket::findOrFail($id);
        $tiket->teknisi_id = $request->teknisi_id;
        $tiket->status = 'diproses';
        $tiket->save();
        
        return redirect()
            ->route('admin.dashboard')
            ->with('success', 'Tugas berhasil didelegasikan ke teknisi.');
    }

    // --- CETAK LAPORAN PDF ---
    public function cetakPDF(Request $request)
    {
        $bulan = $request->input('bulan');
        $tahun = $request->input('tahun', date('Y'));

        $query = Tiket::with([
            'pelanggan',
            'teknisi',
            'kategori'
        ]);

        if (!empty($bulan)) {
            $query->whereMonth('created_at', $bulan)
                  ->whereYear('created_at', $tahun);
            
            $periode = Carbon::createFromDate($tahun, $bulan, 1)->translatedFormat('F Y');
            $namaFile = 'Laporan_Pengaduan_' . Carbon::createFromDate($tahun, $bulan, 1)->format('m_Y');
        } else {
            $periode = 'Semua Waktu';
            $namaFile = 'Laporan_Pengaduan_Semua_Waktu_' . date('Y-m-d');
        }

        $tikets = $query->latest()->get();

        $pdf = Pdf::loadView(
            'admin-laporan-pdf',
            compact('tikets', 'periode')
        );

        $pdf->setPaper('a4', 'landscape');

        return $pdf->download($namaFile . '.pdf');
    }

    // --- MANAJEMEN KATEGORI ---
    public function kategori()
    {
        $semuaKategori = Kategori::latest()->get();
        return view('admin-kategori', compact('semuaKategori'));
    }

    public function storeKategori(Request $request)
    {
        $request->validate([
            'nama_kategori' => 'required|string|max:255|unique:kategoris,nama_kategori'
        ]);

        Kategori::create([
            'nama_kategori' => $request->nama_kategori
        ]);

        return back()->with('success', 'Kategori baru berhasil ditambahkan!');
    }

    public function destroyKategori($id)
    {
        $kategori = Kategori::findOrFail($id);
        $kategori->delete();

        return back()->with('success', 'Kategori berhasil dihapus!');
    }

    // --- MANAJEMEN PENGGUNA (USERS) ---
    public function users(Request $request)
    {
        $query = \App\Models\User::query();

        // Blokir akun admin utama agar tidak muncul di daftar kelola user
        $query->where('role', '!=', 'admin');
        
        // Filter Berdasarkan Role 
        if ($request->filled('role')) {
            $query->where('role', $request->role);
        }

        // Pencarian Berdasarkan Nama, Email, atau ID
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                ->orWhere('email', 'like', "%{$search}%")
                ->orWhere('id', 'like', "%{$search}%");
            });
        }

        $users = $query->orderBy('created_at', 'desc')->get();

        return view('admin-users', compact('users'));
    }

    // --- SIMPAN PENGGUNA BARU (PELANGGAN / TEKNISI) ---
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8',
            'role' => 'required|in:pelanggan,teknisi',
            'no_telepon' => 'nullable|string|max:20',
            'alamat_lengkap' => 'nullable|string',
            'latitude' => 'nullable|numeric',
            'longitude' => 'nullable|numeric',
            'kecamatan' => 'nullable|string',
            'kecamatan_tugas' => 'nullable|string',
        ]);

        $user = \App\Models\User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => \Illuminate\Support\Facades\Hash::make($request->password),
            'role' => $request->role,
            'no_telepon' => $request->no_telepon,
            'status' => 'aktif', // Otomatis aktif saat dibuat oleh admin
            
            // Logika Simpan Bersyarat: Pelanggan menyimpan koordinat & domisili, Teknisi hanya kecamatan tugas.
            'alamat_lengkap' => $request->role === 'pelanggan' ? $request->alamat_lengkap : null,
            'latitude' => $request->role === 'pelanggan' ? $request->latitude : null,
            'longitude' => $request->role === 'pelanggan' ? $request->longitude : null,
            'kecamatan' => $request->role === 'pelanggan' ? $request->kecamatan : null,
            'kecamatan_tugas' => $request->role === 'teknisi' ? $request->kecamatan_tugas : null,
        ]);

        return redirect()->route('admin.users')->with('success', 'Akun ' . ucfirst($request->role) . ' berhasil ditambahkan!');
    }

    public function destroyUser($id)
    {
        $user = User::findOrFail($id);

        if ($user->id == auth()->id()) {
            return back()->with('error', 'Anda tidak bisa menghapus akun sendiri.');
        }

        $user->delete();

        return back()->with('success', 'User berhasil dihapus.');
    }

    public function verifikasiUser($id)
    {
        $user = User::findOrFail($id);
        $user->status = 'aktif';
        $user->save();

        return back()->with('success', 'User berhasil diverifikasi.');
    }

    public function tolakUser($id)
    {
        $user = User::findOrFail($id);
        $user->status = 'ditolak';
        $user->save();

        return back()->with('success', 'User ditolak.');
    }

    // --- UPDATE JADWAL LIBUR TEKNISI ---
    public function updateHariLibur(Request $request, $id)
    {
        $user = \App\Models\User::findOrFail($id);

        if ($user->role !== 'teknisi') {
            return back()->with('error', 'Hanya teknisi yang memiliki jadwal libur rutin.');
        }

        $user->hari_libur = $request->hari_libur;
        $user->save();

        return back()->with('success', 'Jadwal libur rutin untuk teknisi ' . $user->name . ' berhasil diperbarui menjadi hari ' . $user->hari_libur . '.');
    }
}