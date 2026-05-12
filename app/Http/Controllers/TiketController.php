<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Tiket; // Memanggil model Tiket
use Illuminate\Support\Facades\Auth;

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
    // Fungsi untuk menyimpan data ke database
    public function store(Request $request)
    {
        $request->validate([
            'judul' => 'required|string|max:255',
            'deskripsi' => 'required|string',
            'latitude' => 'required',
            'longitude' => 'required',
        ]);

        Tiket::create([
            'pelanggan_id' => Auth::id(),
            'judul' => $request->judul,
            'deskripsi' => $request->deskripsi,
            'status' => 'menunggu verifikasi',
            'latitude' => $request->latitude,   // Simpan Latitude
            'longitude' => $request->longitude, // Simpan Longitude
        ]);

        return redirect()->route('pelanggan.dashboard')->with('success', 'Tiket berhasil dikirim!');
    }
}