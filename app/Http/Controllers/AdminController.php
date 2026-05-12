<?php

namespace App\Http\Controllers;

use App\Models\Tiket;
use Illuminate\Http\Request;

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
}