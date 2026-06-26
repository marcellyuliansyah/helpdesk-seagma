<x-app-layout>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600&family=Poppins:wght@500;600;700&display=swap');

        .font-tegas {
            font-family: 'Poppins', sans-serif;
        }

        body {
            font-family: 'Inter', sans-serif;
            background-color: #ffffff;
        }

        .bg-grid-pattern {
            background-image: linear-gradient(to right, #f1f5f9 1px, transparent 1px), linear-gradient(to bottom, #f1f5f9 1px, transparent 1px);
            background-size: 3rem 3rem;
        }
    </style>

    <div class="relative min-h-screen bg-gray-50/40 pb-20">
        <div class="fixed inset-0 z-0 bg-grid-pattern opacity-50"></div>
        <div
            class="fixed top-0 right-0 w-[600px] h-[600px] bg-red-50/20 rounded-full blur-[140px] z-0 pointer-events-none">
        </div>

        <div class="relative z-10">
            <div class="bg-white/60 backdrop-blur-md border-b border-gray-100">
                <div
                    class="max-w-7xl mx-auto py-8 px-4 sm:px-6 lg:px-8 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-5">
                    <div>
                        <h2 class="text-2xl font-bold text-gray-950 font-tegas leading-none">
                            Manajemen Pengaduan Global
                        </h2>
                        <p class="text-xs text-black mt-1.5 font-light">Pantau status, lakukan delegasi ulang regu
                            teknisi, dan kendalikan seluruh berkas laporan sistem.</p>
                    </div>

                    <a href="{{ route('pimpinan.dashboard') }}"
                        class="inline-flex items-center justify-center px-5 py-2.5 bg-white border border-gray-200 text-gray-600 hover:text-gray-900 text-xs font-semibold uppercase tracking-widest rounded-full shadow-sm hover:shadow-md transition-all duration-300 w-full sm:w-auto">
                        <svg class="w-3.5 h-3.5 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                        </svg>
                        Dashboard Utama
                    </a>
                </div>
            </div>

            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mt-10">

                @if (session('success'))
                    <div
                        class="mb-8 bg-green-50/80 border border-green-100 rounded-2xl p-4 flex items-center gap-3 animate-fade-in-down">
                        <div class="text-green-500 shrink-0">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </div>
                        <span class="text-xs font-semibold text-gray-900">{{ session('success') }}</span>
                    </div>
                @endif

                <div
                    class="bg-white rounded-[2rem] shadow-2xl shadow-gray-200/30 border border-gray-100/60 overflow-hidden">
                    <div class="px-8 py-5 border-b border-gray-50 bg-gray-50/20 flex items-center justify-between">
                        <h3 class="text-xs font-bold uppercase tracking-wider text-gray-800 font-tegas">Daftar  
                            Tiket</h3>
                    </div>

                    <div class="overflow-x-auto">
                        <table class="w-full text-left">
                            <thead>
                                <tr
                                    class="text-[10px] text-black uppercase tracking-[0.15em] bg-gray-50/30 border-b border-gray-50">
                                    <th class="px-8 py-4 font-bold">Rincian Keluhan &amp; Waktu</th>
                                    <th class="px-8 py-4 font-bold">Pelanggan</th>
                                    <th class="px-8 py-4 font-bold">Status Berkas</th>
                                    <th class="px-8 py-4 font-bold text-center w-64 bg-gray-50/10">Teknisi Yang Bertugas</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-50 text-sm text-gray-700">
                                @foreach ($tikets as $tiket)
                                    @php
                                        $pelanggan = $users->where('id', $tiket->pelanggan_id)->first();
                                        $namaPelanggan = $pelanggan ? $pelanggan->name : 'Akun Terhapus';

                                        $teknisiAssign = $users->where('id', $tiket->teknisi_id)->first();
                                        $namaTeknisi = $teknisiAssign ? $teknisiAssign->name : 'Belum Ada';
                                    @endphp
                                    <tr class="group hover:bg-gray-50/40 transition-all duration-200">
                                        <td class="px-8 py-5">
                                            <div class="text-[10px] font-mono font-medium text-black mb-1">
                                                {{ \Carbon\Carbon::parse($tiket->created_at)->format('d F Y, H:i') }}
                                                WIB
                                            </div>
                                            <div
                                                class="font-bold text-gray-900 uppercase tracking-wide text-xs font-tegas">
                                                {{ $tiket->judul }}
                                            </div>
                                            <div class="text-xs text-black font-light mt-1 max-w-md line-clamp-2">
                                                {{ $tiket->deskripsi }}
                                            </div>
                                        </td>

                                        <td
                                            class="px-8 py-5 font-semibold text-gray-900 uppercase tracking-wide text-xs">
                                            {{ $namaPelanggan }}
                                        </td>

                                        <td class="px-8 py-5">
                                            <span
                                                class="px-3 py-1 rounded-full text-[9px] font-bold uppercase tracking-wider ring-1
                                            @if ($tiket->status == 'selesai') bg-green-50 text-green-600 ring-green-100
                                            @elseif($tiket->status == 'proses') bg-blue-50 text-blue-600 ring-blue-100
                                            @else bg-yellow-50 text-yellow-600 ring-yellow-100 @endif">
                                                {{ $tiket->status }}
                                            </span>
                                        </td>

                                        <td class="px-6 py-5 bg-gray-50/20 text-center">
                                            <div class="max-w-xs mx-auto">
                                                <div
                                                    class="block w-full rounded-xl border-0 py-2 px-3 text-gray-900 shadow-sm ring-1 ring-gray-200 bg-gray-100 text-xs font-semibold">
                                                    {{ $namaTeknisi }}
                                                </div>
                                            </div>
                                        </td>

                                        {{-- <td class="px-8 py-5 text-center">
                                            <form action="{{ route('pimpinan.tiket.destroy', $tiket->id) }}"
                                                method="POST"
                                                onsubmit="return confirm('BAHAYA MUTLAK: Apakah Anda yakin ingin menghapus tiket ini secara PERMANEN dari database?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit"
                                                    class="text-[10px] font-bold text-red-400 hover:text-red-600 uppercase tracking-wider transition-colors duration-150">
                                                    Eliminasi
                                                </button>
                                            </form>
                                        </td> --}}
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>

            </div>
        </div>
    </div>
</x-app-layout>
