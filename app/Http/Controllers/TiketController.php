<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Tiket; // Memanggil model Tiket
use Illuminate\Support\Facades\Auth;
use App\Models\Kategori;

class TiketController extends Controller
{
    public function destroy($id)
    {
        // 1. Cari tiket berdasarkan ID
        $tiket = Tiket::findOrFail($id);

        // 2. Pastikan tiket ini milik user yang sedang login DAN statusnya masih 'menunggu verifikasi'
        if ($tiket->pelanggan_id == Auth::id() && $tiket->status == 'menunggu verifikasi') {
            $tiket->delete(); // Hapus tiket dari database
            return redirect()->route('pelanggan.dashboard')->with('success', 'Pengaduan berhasil dibatalkan dan dihapus.');
        }

        // 3. Jika gagal (misal status sudah diproses), tolak pembatalan
        return redirect()->route('pelanggan.dashboard')->with('error', 'Maaf, pengaduan tidak dapat dibatalkan karena sudah diproses oleh teknisi.');
    }

    public function create()
    {
        // Mengambil semua kategori untuk pilihan dropdown pelanggan
        $semuaKategori = Kategori::all();

        // Sesuaikan 'create-tiket' dengan nama file blade form pelanggan Anda
        return view('pengaduan-create', compact('semuaKategori'));
    }

    // Fungsi untuk menyimpan data ke database
    public function store(Request $request)
    {
        $request->validate([
            'judul' => 'required',
            'deskripsi' => 'required',
            'kategori_id' => 'required',
        ]);

        $user = Auth::user();

        Tiket::create([
            'pelanggan_id' => $user->id,
            'judul' => $request->judul,
            'deskripsi' => $request->deskripsi,
            'kategori_id' => $request->kategori_id,

            'latitude' => $user->latitude,
            'longitude' => $user->longitude,

            'status' => 'menunggu verifikasi',
        ]);

        return redirect()
            ->route('pelanggan.dashboard')
            ->with('success', 'Pengaduan berhasil dikirim');
    }

    // Fungsi untuk teknisi menyelesaikan tugas dan upload foto bukti
    public function selesai(Request $request, $id)
    {
        // 1. Validasi input file dari form kamera teknisi
        $request->validate([
            'foto_bukti' => 'required|image|mimes:jpeg,png,jpg|max:5120', // Maksimal 5MB
        ]);

        // 2. Cari tiket berdasarkan ID
        $tiket = Tiket::findOrFail($id);

        // 3. Proses upload foto ke folder storage/app/public/bukti_selesai
        if ($request->hasFile('foto_bukti')) {
            $file = $request->file('foto_bukti');
            $path = $file->store('bukti_selesai', 'public');
            
            // Simpan lokasi file (path) ke database
            $tiket->foto_bukti = $path;
        }

        // 4. Ubah status tiket menjadi selesai (sesuaikan penulisan status dengan sistemmu)
        $tiket->status = 'selesai'; 
        $tiket->save();

        // 5. Kembalikan teknisi ke halaman dashboard dengan pesan sukses
        return redirect()->back()->with('success', 'Tugas berhasil diselesaikan! Bukti foto sudah tersimpan untuk Admin.');
    }
}
