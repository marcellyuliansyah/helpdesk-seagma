<?php

namespace App\Http\Controllers;

use App\Models\Tiket;
use Illuminate\Http\Request;
use App\Models\User;
use Barryvdh\DomPDF\Facade\Pdf; // <-- Alat pembuat PDF
use App\Models\Kategori;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;

class AdminController extends Controller
{
    public function index()
    {
        // Ambil statistik untuk kotak informasi
        $stats = [
            'total' => Tiket::count(),
            'pending' => Tiket::where('status', 'menunggu verifikasi')->count(),
            'proses' => Tiket::where('status', 'diproses')->count(),
            'selesai' => Tiket::where('status', 'selesai')->count(),
        ];

        // Ambil semua tiket yang masuk (terbaru di atas)
        $semuaTiket = Tiket::with([
            'pelanggan',
            'teknisi',
            'kategori'
        ])->latest()->get();

        $teknisi = User::where('role', 'teknisi')
            ->where('status', 'aktif')
            ->get();

        return view('admin-dashboard', compact('stats', 'semuaTiket', 'teknisi'));
    }

    // Fungsi untuk melihat detail pengaduan beserta peta lokasi
    public function show($id)
    {
        $tiket = Tiket::with([
            'pelanggan',
            'teknisi',
            'kategori'
        ])->findOrFail($id);

        $teknisis = User::where('role', 'teknisi')
            ->where('is_approved', true)
            ->get();

        return view('admin-tiket-detail', compact('tiket', 'teknisis'));
    }

    // Fungsi untuk memperbarui status tiket
    public function updateStatus(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:menunggu verifikasi,diproses,selesai',
            'teknisi_id' => 'nullable|exists:users,id'
        ]);

        $tiket = Tiket::findOrFail($id);

        $tiket->status = $request->status;
        $tiket->teknisi_id = $request->teknisi_id; // 👈 TAMBAH INI

        // optional: kalau teknisi dipilih otomatis jadi diproses
        if ($request->teknisi_id && $tiket->status == 'menunggu verifikasi') {
            $tiket->status = 'diproses';
        }

        $tiket->save();

        return redirect()
            ->route('admin.dashboard')
            ->with('success', 'Data tiket berhasil diperbarui!');
    }

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
            ->with('success', 'Teknisi berhasil ditugaskan.');
    }

    /**
     * Fungsi Cetak PDF dengan Filter Bulan & Tahun Opsional
     */
    public function cetakPDF(Request $request)
    {
        // Mengambil parameter input filter bulan dan tahun dari form/URL request
        $bulan = $request->input('bulan');
        $tahun = $request->input('tahun', date('Y')); // Default menggunakan tahun saat ini jika kosong

        $query = Tiket::with([
            'pelanggan',
            'teknisi',
            'kategori'
        ]);

        // Logika pengecekan pemfilteran data
        if (!empty($bulan)) {
            $query->whereMonth('created_at', $bulan)
                  ->whereYear('created_at', $tahun);
            
            // Konversi angka bulan & tahun menjadi string teks nama bulan Indonesia (Contoh: "Juli 2026")
            $periode = Carbon::createFromDate($tahun, $bulan, 1)->translatedFormat('F Y');
            $namaFile = 'Laporan_Pengaduan_' . Carbon::createFromDate($tahun, $bulan, 1)->format('m_Y');
        } else {
            $periode = 'Semua Waktu';
            $namaFile = 'Laporan_Pengaduan_Semua_Waktu_' . date('Y-m-d');
        }

        // Ambil data berdasarkan filter yang ditentukan
        $tikets = $query->latest()->get();

        // Kirim variabel $tikets dan $periode ke view PDF
        $pdf = Pdf::loadView(
            'admin-laporan-pdf',
            compact('tikets', 'periode')
        );

        $pdf->setPaper('a4', 'landscape');

        return $pdf->download($namaFile . '.pdf');
    }

    // --- FUNGSI MASTER DATA KATEGORI ---
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

    public function users()
    {
        $users = User::latest()->get();

        return view('admin-users', compact('users'));
    }

    public function storeUser(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:6',
            'role' => 'required|in:pelanggan,teknisi',

            'alamat_lengkap' => 'nullable|string',
            'no_telepon' => 'nullable|string',

            'latitude' => 'nullable',
            'longitude' => 'nullable',
        ]);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => $request->role,
            'status' => 'pending',

            'no_telepon' => $request->no_telepon,
            'alamat_lengkap' => $request->alamat_lengkap,

            'latitude' => $request->latitude,
            'longitude' => $request->longitude,

            'is_approved' => $request->role === 'teknisi' ? false : true,
        ]);

        return back()->with(
            'success',
            'Akun berhasil dibuat.'
        );
    }

    public function destroyUser($id)
    {
        $user = User::findOrFail($id);

        // cegah admin menghapus dirinya sendiri
        if ($user->id == auth()->id()) {
            return back()->with(
                'error',
                'Anda tidak bisa menghapus akun sendiri.'
            );
        }

        $user->delete();

        return back()->with(
            'success',
            'User berhasil dihapus.'
        );
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
}