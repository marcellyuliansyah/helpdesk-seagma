<?php

namespace App\Http\Controllers;

use App\Models\Tiket;
use Illuminate\Http\Request;
use App\Models\User;
use Barryvdh\DomPDF\Facade\Pdf; // <-- Alat pembuat PDF
use App\Models\Kategori;

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
        $semuaTiket = Tiket::with('user')->orderBy('created_at', 'desc')->get();

        return view('admin-dashboard', compact('stats', 'semuaTiket'));
    }

    // Fungsi untuk melihat detail pengaduan beserta peta lokasi
    public function show($id)
    {
        $tiket = Tiket::with('user')->findOrFail($id);
        return view('admin-tiket-detail', compact('tiket'));
    }

    // Fungsi untuk memperbarui status tiket
    public function updateStatus(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:menunggu verifikasi,diproses,selesai'
        ]);

        $tiket = Tiket::findOrFail($id);
        $tiket->status = $request->status;
        $tiket->save();

        return redirect()->route('admin.dashboard')->with('success', 'Status laporan berhasil diperbarui!');
    }

    public function cetakPDF()
    {
        // Ambil semua data tiket dan user
        $tikets = Tiket::latest()->get();
        $users = User::all();

        // Kirim data ke tampilan khusus PDF
        $pdf = Pdf::loadView('admin-laporan-pdf', compact('tikets', 'users'));
        
        // Atur ukuran kertas ke A4 (Landscape/memanjang agar tabel muat)
        $pdf->setPaper('a4', 'landscape');

        // Download otomatis dengan nama file yang rapi
        return $pdf->download('Laporan_Pengaduan_'.date('Y-m-d').'.pdf');
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
}