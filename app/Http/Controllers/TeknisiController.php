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

        // 1. HANYA mengambil tiket yang SEDANG DIKERJAKAN (yang sudah ditunjuk oleh Admin)
        $tiketSaya = Tiket::with('pelanggan')
            ->where('teknisi_id', $teknisiId)
            ->where('status', 'diproses')
            ->orderBy('updated_at', 'desc')
            ->get();

        // 2. Menghitung total tiket yang SUDAH SELESAI dikerjakan oleh teknisi ini (untuk statistik dashboard)
        $totalSelesai = Tiket::where('teknisi_id', $teknisiId)
            ->where('status', 'selesai')
            ->count();

        return view('teknisi-dashboard', compact('tiketSaya', 'totalSelesai'));
    }

    // Fungsi utama untuk menyelesaikan tugas wajib dengan foto bukti lapangan
    public function selesaikanTugas(Request $request, $id)
    {
        $request->validate([
            // Validasi file maksimal 5MB aman untuk jepretan kamera HP resolusi tinggi
            'foto_bukti' => 'required|image|mimes:jpeg,png,jpg|max:5120', 
        ]);

        // Cari tiket dan pastikan tiket ini memang milik teknisi yang sedang login
        $tiket = Tiket::where('id', $id)
                      ->where('teknisi_id', Auth::id())
                      ->firstOrFail();

        // Proses upload foto bukti ke dalam storage
        if ($request->hasFile('foto_bukti')) {
            $file = $request->file('foto_bukti');
            $filename = time() . '_' . $file->getClientOriginalName();
            $file->storeAs('public/bukti_selesai', $filename);
            
            $tiket->foto_bukti = $filename;
        }

        // Ubah status tiket menjadi selesai
        $tiket->status = 'selesai';
        $tiket->save();

        return redirect()->route('teknisi.dashboard')->with('success', 'Luar biasa! Tugas lapangan telah diselesaikan dan bukti berhasil diunggah.');
    }

    public function toggleStatus()
    {
        $user = auth()->user();
        $user->status = ($user->status === 'libur') ? 'aktif' : 'libur';
        $user->save();

        return back()->with('success', 'Status ketersediaan Anda berhasil diperbarui.');
    }
}