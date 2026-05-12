<?php

namespace App\Http\Controllers;

use App\Models\Tiket;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TeknisiController extends Controller
{
    // Menampilkan halaman dashboard teknisi
    public function index()
    {
        $teknisiId = Auth::id();

        // 1. Tiket yang SIAP DIAMBIL (Sudah divalidasi admin, belum ada teknisinya)
        $tiketTersedia = Tiket::with('user')
            ->where('status', 'diproses')
            ->whereNull('teknisi_id')
            ->orderBy('created_at', 'asc')
            ->get();

        // 2. Tiket yang SEDANG DIKERJAKAN oleh teknisi yang sedang login
        $tiketSaya = Tiket::with('user')
            ->where('teknisi_id', $teknisiId)
            ->where('status', 'diproses')
            ->orderBy('updated_at', 'desc')
            ->get();

        return view('teknisi-dashboard', compact('tiketTersedia', 'tiketSaya'));
    }

    // Fungsi untuk mengambil tiket
    public function ambilTiket($id)
    {
        $tiket = Tiket::findOrFail($id);

        // Validasi ganda: Pastikan tiket benar-benar belum diambil orang lain
        if ($tiket->teknisi_id !== null) {
            return redirect()->route('teknisi.dashboard')->with('error', 'Maaf, tiket ini baru saja diambil oleh teknisi lain!');
        }

        // Masukkan ID teknisi yang sedang login ke tiket ini
        $tiket->teknisi_id = Auth::id();
        $tiket->save();

        return redirect()->route('teknisi.dashboard')->with('success', 'Berhasil! Tiket masuk ke daftar tugas Anda.');
    }
}