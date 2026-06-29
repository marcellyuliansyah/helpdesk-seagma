<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Kategori;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\Tiket;
use Illuminate\Support\Str;
use App\Models\Pengaturan;
use Illuminate\Support\Facades\Storage;

class SuperAdminController extends Controller
{
    public function index(Request $request)
    {
        $totalAdmin = User::where('role', 'admin')->count();
        $totalTeknisi = User::where('role', 'teknisi')->count();
        $totalPelanggan = User::where('role', 'pelanggan')->count();
        
        $users = User::where('id', '!=', Auth::id())->latest()->get();
        
        // Ambil semua data kategori untuk dropdown filter
        $kategoris = Kategori::all();

        // Buat query dasar untuk tiket
        $query = Tiket::with(['pelanggan', 'kategori'])->latest();

        // Jika ada input pencarian nama pelanggan
        if ($request->filled('search')) {
            $search = $request->search;
            $query->whereHas('pelanggan', function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%");
            });
        }

        // Jika ada pilihan filter kategori
        if ($request->filled('kategori')) {
            $query->where('kategori_id', $request->kategori);
        }

        // Eksekusi query
        $tikets = $query->get();

        // Jangan lupa tambahkan 'kategoris' di dalam compact
        return view('pimpinan-dashboard', compact('totalAdmin', 'totalTeknisi', 'totalPelanggan', 'users', 'tikets', 'kategoris'));
    }

    // Fungsi untuk menampilkan form tambah pengguna
    public function create()
    {
        return view('pimpinan-user-create');
    }

    // Fungsi untuk memproses penyimpanan data ke database
    public function store(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8'],
            'ro
            le' => ['required', 'string'],
        ]);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password), // Enkripsi password
            'role' => $request->role,
            'is_approved' => $request->role === 'teknisi' ? false : true,
        ]);

        // Kembali ke dashboard dengan pesan sukses
        return redirect()->route('pimpinan.dashboard')->with('success', 'Pengguna baru berhasil ditambahkan!');
    }

    // Fungsi untuk menghapus pengguna dari database
    public function destroy($id)
    {
        // Cari pengguna berdasarkan ID, jika tidak ketemu langsung tampilkan error 404
        $user = User::findOrFail($id);

        // Hapus pengguna tersebut
        $user->delete();

        // Kembali ke dashboard dengan pesan sukses
        return redirect()->route('pimpinan.dashboard')->with('success', 'Pengguna berhasil dihapus permanen!');
    }

    // Menampilkan halaman form edit
    public function edit($id)
    {
        $user = User::findOrFail($id);
        return view('pimpinan-user-edit', compact('user'));
    }

    // Memproses pembaruan data ke database
    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);

        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            // Validasi email: harus unik KECUALI untuk email user ini sendiri
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email,' . $id],
            'role' => ['required', 'string'],
        ]);

        // Update data dasar
        $user->name = $request->name;
        $user->email = $request->email;
        $user->role = $request->role;

        // Jika form password diisi, berarti pimpinan ingin mereset password user ini
        if ($request->filled('password')) {
            $request->validate([
                'password' => ['string', 'min:8'],
            ]);
            $user->password = Hash::make($request->password);
        }

        $user->save();

        return redirect()->route('pimpinan.dashboard')->with('success', 'Data pengguna berhasil diperbarui!');
    }

    // --- FUNGSI MANAJEMEN TIKET ---

    // 1. Menampilkan semua tiket
    public function allTiket()
    {
        // Ambil semua tiket urut dari yang terbaru
        $tikets = Tiket::latest()->get();

        // Ambil data teknisi saja untuk pilihan menu dropdown Re-assign
        $teknisi = User::where('role', 'teknisi')
            ->where('is_approved', true)
            ->get();

        // Ambil semua user untuk mencocokkan nama pelanggan dan nama teknisi
        $users = User::all();

        return view('pimpinan-tiket', compact('tikets', 'teknisi', 'users'));
    }

    // 2. Memaksa pindah teknisi (Re-Assign)
    public function reassignTiket(Request $request, $id)
    {
        $tiket = Tiket::findOrFail($id);
        $tiket->teknisi_id = $request->teknisi_id;
        $tiket->save();

        return back()->with('success', 'Tiket berhasil dipindahkan ke teknisi lain!');
    }

    // 3. Menghapus tiket permanen (Spam/Testing)
    public function destroyTiket($id)
    {
        $tiket = Tiket::findOrFail($id);
        $tiket->delete();

        return back()->with('success', 'Data tiket berhasil dihapus permanen!');
    }

    // --- FUNGSI PENGATURAN SISTEM ---
    public function pengaturan()
    {
        // Cari data pengaturan, jika belum ada di database, buat otomatis
        $pengaturan = Pengaturan::firstOrCreate(['id' => 1], [
            'nama_aplikasi' => 'Sistem Helpdesk',
            'nama_perusahaan' => 'PT. Perusahaan Kita'
        ]);

        return view('pimpinan-pengaturan', compact('pengaturan'));
    }

    public function updatePengaturan(Request $request)
    {
        $pengaturan = Pengaturan::first();

        // Validasi input
        $request->validate([
            'nama_aplikasi' => 'required|string|max:255',
            'nama_perusahaan' => 'required|string|max:255',
            'logo' => 'nullable|image|mimes:jpeg,png,jpg|max:2048', // Maksimal 2MB
        ]);

        $pengaturan->nama_aplikasi = $request->nama_aplikasi;
        $pengaturan->nama_perusahaan = $request->nama_perusahaan;

        // Cek apakah ada file logo yang diupload
        if ($request->hasFile('logo')) {
            // Hapus logo lama jika ada
            if ($pengaturan->logo && Storage::exists('public/' . $pengaturan->logo)) {
                Storage::delete('public/' . $pengaturan->logo);
            }
            // Simpan logo baru di folder storage/app/public/logos
            $path = $request->file('logo')->store('logos', 'public');
            $pengaturan->logo = $path;
        }

        $pengaturan->save();

        return back()->with('success', 'Pengaturan sistem berhasil diperbarui!');
    }

    public function approveTeknisi($id)
    {
        // 1. Cari user berdasarkan ID
        $user = \App\Models\User::findOrFail($id);

        // 2. Ubah status is_approved menjadi true/1
        $user->is_approved = true;
        $user->save();

        // 3. Kembali ke halaman sebelumnya dengan pesan sukses
        return redirect()->back()->with('success', 'Akun teknisi berhasil divalidasi!');
    }

    public function validasiTeknisi()
    {
        $teknisi = User::where('role', 'teknisi')
            ->latest()
            ->get();

        return view('pimpinan-validasi-teknisi', compact('teknisi'));
    }

    public function daftarUser($role)
    {
        $roleValid = [
            'pelanggan',
            'teknisi',
            'admin'
        ];

        if (!in_array($role, $roleValid)) {
            abort(404);
        }

        $users = User::where('role', $role)
            ->latest()
            ->get();

        $judul = match ($role) {
            'pelanggan' => 'Data Pelanggan',
            'teknisi' => 'Data Teknisi',
            'admin' => 'Staf Operator Admin',
        };

        return view(
            'pimpinan-daftar-user',
            compact(
                'users',
                'judul',
                'role'
            )
        );
    }
}
