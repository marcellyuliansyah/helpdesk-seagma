<x-app-layout>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600&family=Poppins:wght@500;600;700&display=swap');

        .font-tegas {
            font-family: 'Poppins', sans-serif;
        }

        body {
            font-family: 'Inter', sans-serif;
        }

        .bg-grid-pattern {
            background-image: linear-gradient(to right, #f1f5f9 1px, transparent 1px), linear-gradient(to bottom, #f1f5f9 1px, transparent 1px);
            background-size: 3rem 3rem;
        }
    </style>

    <div class="relative min-h-screen bg-gray-50/50 pb-16">
        <div class="fixed inset-0 z-0 bg-grid-pattern opacity-60"></div>
        <div
            class="fixed top-0 right-0 w-[600px] h-[600px] bg-red-50/30 rounded-full blur-[130px] z-0 pointer-events-none">
        </div>

        <div class="relative z-10">
            <div class="bg-white/60 backdrop-blur-md border-b border-gray-100">
                <div
                    class="max-w-7xl mx-auto py-8 px-4 sm:px-6 lg:px-8 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                    <div>
                        <h2 class="text-2xl font-bold text-gray-900 font-tegas">
                            Panel Kendali Admin
                        </h2>
                        <p class="text-sm text-black mt-1 font-light">Pusat kendali pemantauan infrastruktur dan tiket
                            gangguan masuk.</p>
                    </div>

                    <div class="flex gap-3">

                        <a href="{{ route('admin.kategori') }}"
                            class="inline-flex items-center justify-center px-5 py-3 bg-gray-900 hover:bg-red-600 text-white text-xs font-bold uppercase tracking-widest rounded-2xl shadow-lg">

                            Kelola Kategori Masalah
                        </a>

                        <a href="{{ route('admin.users') }}"
                            class="inline-flex items-center justify-center px-5 py-3 bg-blue-600 hover:bg-blue-700 text-white text-xs font-bold uppercase tracking-widest rounded-2xl shadow-lg">

                            Kelola Akun
                        </a>

                    </div>
                </div>
            </div>

            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mt-10">

                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5 mb-10">
                    <div
                        class="bg-white rounded-[2rem] p-6 shadow-xl shadow-gray-200/30 border border-gray-100/50 flex items-center justify-between group">
                        <div>
                            <p class="text-[10px] font-bold text-black uppercase tracking-widest">Total Tiket</p>
                            <p class="text-3xl font-extrabold text-gray-900 font-tegas mt-1">{{ $stats['total'] }}</p>
                        </div>
                        <div
                            class="w-12 h-12 rounded-2xl bg-gray-50 flex items-center justify-center text-gray-500 ring-1 ring-gray-100">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                            </svg>
                        </div>
                    </div>
                    <div
                        class="bg-white rounded-[2rem] p-6 shadow-xl shadow-gray-200/30 border border-gray-100/50 flex items-center justify-between relative overflow-hidden">
                        <div class="absolute top-0 left-0 w-1.5 h-full bg-yellow-400"></div>
                        <div>
                            <p class="text-[10px] font-bold text-yellow-600 uppercase tracking-widest">Menunggu
                                Verifikasi</p>
                            <p class="text-3xl font-extrabold text-gray-900 font-tegas mt-1">{{ $stats['pending'] }}</p>
                        </div>
                        <div
                            class="w-12 h-12 rounded-2xl bg-yellow-50 text-yellow-600 flex items-center justify-center ring-1 ring-yellow-100">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </div>
                    </div>
                    <div
                        class="bg-white rounded-[2rem] p-6 shadow-xl shadow-gray-200/30 border border-gray-100/50 flex items-center justify-between relative overflow-hidden">
                        <div class="absolute top-0 left-0 w-1.5 h-full bg-blue-500"></div>
                        <div>
                            <p class="text-[10px] font-bold text-blue-600 uppercase tracking-widest">Dalam Proses</p>
                            <p class="text-3xl font-extrabold text-gray-900 font-tegas mt-1">{{ $stats['proses'] }}</p>
                        </div>
                        <div
                            class="w-12 h-12 rounded-2xl bg-blue-50 text-blue-600 flex items-center justify-center ring-1 ring-blue-100">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                            </svg>
                        </div>
                    </div>
                    <div
                        class="bg-white rounded-[2rem] p-6 shadow-xl shadow-gray-200/30 border border-gray-100/50 flex items-center justify-between relative overflow-hidden">
                        <div class="absolute top-0 left-0 w-1.5 h-full bg-green-500"></div>
                        <div>
                            <p class="text-[10px] font-bold text-green-600 uppercase tracking-widest">Selesai Diperbaiki
                            </p>
                            <p class="text-3xl font-extrabold text-gray-900 font-tegas mt-1">{{ $stats['selesai'] }}</p>
                        </div>
                        <div
                            class="w-12 h-12 rounded-2xl bg-green-50 text-green-600 flex items-center justify-center ring-1 ring-green-100">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </div>
                    </div>
                </div>

                {{-- <div class="bg-white rounded-3xl p-6 shadow mb-6">
                    <h3 class="font-bold text-lg mb-4">
                        Tambah Akun Pelanggan / Teknisi
                    </h3>

                    <form action="{{ route('admin.users.store') }}" method="POST"
                        class="grid grid-cols-1 md:grid-cols-4 gap-3">

                        @csrf

                        <input type="text" name="name" placeholder="Nama" required
                            class="rounded-lg border-gray-300">

                        <input type="email" name="email" placeholder="Email" required
                            class="rounded-lg border-gray-300">

                        <input type="password" name="password" placeholder="Password" required
                            class="rounded-lg border-gray-300">

                        <select name="role" required class="rounded-lg border-gray-300">

                            <option value="pelanggan">Pelanggan</option>
                            <option value="teknisi">Teknisi</option>

                        </select>

                        <button type="submit" class="col-span-full bg-blue-600 text-white py-2 rounded-lg">
                            Tambah Akun
                        </button>

                    </form>
                </div> --}}

                <div
                    class="bg-white rounded-[2rem] shadow-2xl shadow-gray-200/30 border border-gray-100 overflow-hidden">
                    <div
                        class="px-8 py-6 border-b border-gray-50 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 bg-gray-50/20">
                        <h3 class="text-sm font-bold uppercase tracking-wider text-gray-800 font-tegas">Daftar Pengaduan
                            Jaringan</h3>

                        <a href="{{ route('admin.laporan.pdf') }}"
                            class="inline-flex items-center justify-center px-4 py-2 bg-white border border-red-200 text-red-600 text-xs font-bold uppercase tracking-widest rounded-xl hover:bg-red-50 transition-colors shadow-sm">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z" />
                            </svg>
                            Cetak Laporan PDF
                        </a>
                    </div>

                    <div class="overflow-x-auto">
                        <table class="w-full text-left">
                            <thead>
                                <tr
                                    class="text-[10px] text-black uppercase tracking-[0.15em] bg-gray-50/50 border-b border-gray-50">
                                    <th class="px-8 py-4 font-bold">Pelanggan</th>
                                    <th class="px-8 py-4 font-bold">Detail Gangguan</th>
                                    <th class="px-8 py-4 font-bold">Status</th>
                                    <th class="px-8 py-4 font-bold">Tgl. Masuk</th>
                                    <th class="px-8 py-4 font-bold">Teknisi Penanggung Jawab</th>
                                    <th class="px-8 py-4 font-bold text-center">Tindakan</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-50">
                                @forelse($semuaTiket as $tiket)
                                    <tr class="group hover:bg-gray-50/40 transition-all duration-200">
                                        <td class="px-8 py-4">
                                            <p class="text-xs font-bold text-gray-900 uppercase tracking-wide">
                                                {{ $tiket->pelanggan->name ?? 'User Hilang' }}</p>
                                            <p class="text-[10px] text-black font-mono mt-0.5">
                                                #{{ $tiket->nomor_tiket ?? $tiket->id }}</p>
                                        </td>

                                        <td class="px-8 py-4">
                                            <p class="text-xs font-semibold text-gray-800">
                                                {{ Str::limit($tiket->judul, 35) }}</p>
                                            <p class="text-[11px] text-black font-light mt-0.5 max-w-xs truncate">
                                                {{ $tiket->deskripsi }}</p>

                                            @if ($tiket->kategori)
                                                <span
                                                    class="inline-flex mt-1.5 text-[8px] bg-purple-50 text-purple-700 px-2 py-0.5 rounded-full font-bold uppercase tracking-wider ring-1 ring-purple-100">
                                                    {{ $tiket->kategori->nama_kategori }}
                                                </span>
                                            @else
                                                <span
                                                    class="inline-flex mt-1.5 text-[8px] bg-gray-50 text-black px-2 py-0.5 rounded-full font-medium uppercase tracking-wider italic ring-1 ring-gray-100">
                                                    Kosong
                                                </span>
                                            @endif
                                        </td>

                                        <td class="px-8 py-4">
                                            @if ($tiket->status == 'menunggu verifikasi')
                                                <span
                                                    class="px-2.5 py-1 rounded-full bg-yellow-50 text-yellow-700 text-[9px] font-bold uppercase tracking-tight ring-1 ring-yellow-100">Menunggu</span>
                                            @elseif($tiket->status == 'diproses')
                                                <span
                                                    class="px-2.5 py-1 rounded-full bg-blue-50 text-blue-700 text-[9px] font-bold uppercase tracking-tight ring-1 ring-blue-100">Diproses</span>
                                            @else
                                                <span
                                                    class="px-2.5 py-1 rounded-full bg-green-50 text-green-700 text-[9px] font-bold uppercase tracking-tight ring-1 ring-green-100">Selesai</span>
                                            @endif
                                        </td>

                                        <td class="px-8 py-4 text-xs text-black font-light">
                                            {{ $tiket->created_at->format('d M Y H:i') }}
                                        </td>

                                        <td class="px-8 py-4">
                                            @if ($tiket->teknisi)
                                                <span
                                                    class="text-xs font-semibold text-gray-700 bg-gray-50 px-2.5 py-1 rounded-xl border border-gray-100">
                                                    {{ $tiket->teknisi->name }}
                                                </span>
                                            @else
                                                <span
                                                    class="text-[9px] bg-gray-50 text-black px-2.5 py-1 rounded-xl font-medium uppercase tracking-wider italic border border-dashed border-gray-200">
                                                    Belum Ditunjuk
                                                </span>
                                            @endif
                                        </td>

                                        <td class="px-8 py-4 text-center">
                                            <a href="{{ route('admin.pengaduan.show', $tiket->id) }}"
                                                class="inline-flex items-center px-4 py-1.5 bg-gray-50 hover:bg-gray-900 border border-gray-200 text-gray-700 hover:text-white text-[10px] font-bold uppercase tracking-wider rounded-xl transition-all duration-300">
                                                Periksa
                                            </a>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="px-8 py-20 text-center">
                                            <div class="flex flex-col items-center opacity-30">
                                                <svg class="w-12 h-12 mb-2 text-gray-400" fill="none"
                                                    stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        stroke-width="2"
                                                        d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0a2 2 0 01-2 2H6a2 2 0 01-2-2m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4" />
                                                </svg>
                                                <p class="text-xs font-semibold tracking-wide text-gray-500 uppercase">
                                                    Belum ada pengaduan tiket masuk.</p>
                                            </div>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>

            </div>
        </div>
    </div>
</x-app-layout>
