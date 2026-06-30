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
        $tiketTersedia = Tiket::with('pelanggan')
            ->where('status', 'diproses')
            ->whereNull('teknisi_id')
            ->orderBy('created_at', 'asc')
            ->get();

        // 2. Tiket yang SEDANG DIKERJAKAN oleh teknisi yang sedang login
        $tiketSaya = Tiket::with('pelanggan')
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
    
    // Fungsi untuk menyelesaikan tiket
    public function selesaikanTiket($id)
    {
        // Cari tiket yang ID-nya cocok dan pastikan tiket ini memang dipegang oleh teknisi yang sedang login
        $tiket = Tiket::where('id', $id)
                      ->where('teknisi_id', Auth::id())
                      ->firstOrFail();

        // Ubah status menjadi selesai
        $tiket->status = 'selesai';
        $tiket->save();

        return redirect()->route('teknisi.dashboard')->with('success', 'Kerja bagus! Laporan telah berhasil diselesaikan.');
    }

    public function selesaikanTugas(Request $request, $id)
{
    $request->validate([
        'foto_bukti' => 'required|image|mimes:jpeg,png,jpg|max:2048',
    ]);

    $tiket = Tiket::findOrFail($id);

    if ($request->hasFile('foto_bukti')) {
        $file = $request->file('foto_bukti');
        $filename = time() . '_' . $file->getClientOriginalName();
        $file->storeAs('public/bukti_selesai', $filename);
        
        // Simpan nama file ke database Anda
        $tiket->foto_bukti = $filename;
    }

    $tiket->status = 'selesai';
    $tiket->save();

    return redirect()->back()->with('success', 'Tugas berhasil diselesaikan beserta foto bukti!');
}
}