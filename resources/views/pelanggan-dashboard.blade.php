<x-app-layout>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600&family=Poppins:wght@500;600;700&display=swap');
        
        .font-tegas { font-family: 'Poppins', sans-serif; }
        body { font-family: 'Inter', sans-serif; }

        .bg-grid-pattern {
            background-image: linear-gradient(to right, #f1f5f9 1px, transparent 1px), linear-gradient(to bottom, #f1f5f9 1px, transparent 1px);
            background-size: 3rem 3rem;
        }
    </style>

    <div class="relative min-h-screen bg-gray-50/50 pb-12">
        <div class="fixed inset-0 z-0 bg-grid-pattern opacity-60"></div>
        <div class="fixed top-0 right-0 w-[500px] h-[500px] bg-red-100/30 rounded-full blur-[120px] z-0"></div>
        <div class="fixed bottom-0 left-0 w-[500px] h-[500px] bg-blue-100/20 rounded-full blur-[120px] z-0"></div>

        <div class="relative z-10">
            <div class="bg-white/60 backdrop-blur-md border-b border-gray-100">
                <div class="max-w-7xl mx-auto py-6 sm:py-8 px-4 sm:px-6 lg:px-8">
                    <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-5">
                        <div>
                            <h2 class="text-xl sm:text-2xl font-bold text-gray-900 font-tegas">
                                Halo, {{ Auth::user()->name }}!
                            </h2>
                            <p class="text-xs sm:text-sm text-gray-500 mt-0.5 font-light">
                                Selamat datang di Portal Helpdesk PT Semeru Agung Mandiri.
                            </p>
                        </div>
                        
                        @if(!$tiketAktif)
                        <a href="{{ route('pengaduan.create') }}" class="inline-flex items-center justify-center px-6 py-3.5 bg-gray-900 hover:bg-red-600 text-white text-xs font-bold tracking-wider rounded-2xl shadow-lg shadow-gray-200 hover:shadow-red-200 transition-all duration-300 transform hover:-translate-y-1 w-full sm:w-auto">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                            BUAT TIKET GANGGUAN
                        </a>
                        @endif
                    </div>
                </div>
            </div>

            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mt-8 sm:mt-10">
                
                @if(session('success'))
                <div class="mb-8 bg-green-50 border border-green-100 rounded-2xl p-4 flex items-center gap-4 animate-fade-in-down">
                    <div class="bg-green-500 p-2 rounded-xl text-white shrink-0">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                    </div>
                    <div>
                        <h4 class="text-sm font-bold text-green-900">Berhasil!</h4>
                        <p class="text-xs text-green-700 font-light">{{ session('success') }}</p>
                    </div>
                </div>
                @endif

                <div class="mb-10">
                    <h4 class="text-[10px] font-bold text-gray-400 uppercase tracking-[0.2em] mb-4 ml-1">Status Pengaduan Aktif</h4>

                    @if($tiketAktif)
                    <div class="group relative bg-white/80 backdrop-blur-xl rounded-[2rem] sm:rounded-[2.5rem] border border-white shadow-2xl shadow-gray-200/50 overflow-hidden transition-all duration-500">
                        <div class="absolute top-0 left-0 w-full sm:w-2 h-1 sm:h-full bg-yellow-400"></div>
                        
                        <div class="p-6 sm:p-10">
                            <div class="flex flex-col lg:flex-row lg:items-center justify-between gap-6">
                                <div class="flex-1">
                                    <div class="flex items-center gap-3 mb-3">
                                        <span class="px-2.5 py-0.5 rounded-full bg-yellow-50 text-yellow-700 text-[9px] font-bold uppercase tracking-wider ring-1 ring-yellow-100">
                                            {{ $tiketAktif->status == 'menunggu verifikasi' ? 'menunggu' : $tiketAktif->status }}
                                        </span>
                                        <span class="text-xs text-gray-400 font-medium font-mono">#{{ $tiketAktif->nomor_tiket ?? $tiketAktif->id }}</span>
                                    </div>
                                    
                                    <h3 class="text-lg sm:text-2xl font-bold text-gray-900 font-tegas leading-tight">
                                        {{ $tiketAktif->judul }}
                                    </h3>
                                    <p class="text-xs text-gray-500 font-light mt-2 line-clamp-3 bg-gray-50/50 p-3 rounded-xl border border-gray-100/50 md:hidden">{{ $tiketAktif->deskripsi }}</p>
                                    
                                    <div class="mt-4 sm:mt-6 flex items-center gap-6 text-[11px] text-gray-400 font-light">
                                        <div class="flex items-center gap-1.5">
                                            <svg class="w-3.5 h-3.5 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                                            {{ $tiketAktif->created_at->format('d M Y, h:i') }}
                                        </div>
                                    </div>
                                </div>

                                @if($tiketAktif->status == 'menunggu verifikasi')
                                <div class="shrink-0 w-full lg:w-auto">
                                    <form action="{{ route('pengaduan.destroy', $tiketAktif->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin membatalkan laporan ini?');">
                                        @csrf @method('DELETE')
                                        <button type="submit" class="w-full px-5 py-3 rounded-xl bg-white border border-red-100 text-red-600 text-xs font-bold uppercase tracking-widest hover:bg-red-50 transition-all duration-300 shadow-sm">
                                            Batalkan Laporan
                                        </button>
                                    </form>
                                </div>
                                @endif
                            </div>
                        </div>

                        <div class="bg-gray-50/50 px-6 sm:px-8 py-3.5 border-t border-gray-100/50">
                            <p class="text-[10px] text-gray-400 italic font-medium">
                                * Pengajuan pengaduan baru dinonaktifkan sementara hingga tiket aktif ini selesai ditangani.
                            </p>
                        </div>
                    </div>

                    @else
                    <div class="bg-white/40 backdrop-blur-sm border-2 border-dashed border-gray-200 rounded-[2rem] p-8 sm:p-12 text-center group hover:border-red-200 transition-all duration-500">
                        <div class="w-12 h-12 bg-gray-100 rounded-xl flex items-center justify-center mx-auto mb-3 group-hover:bg-red-50 transition-all">
                            <svg class="w-6 h-6 text-gray-400 group-hover:text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                        </div>
                        <h5 class="text-sm font-bold text-gray-900 font-tegas">Jaringan Terpantau Normal</h5>
                        <p class="text-xs text-gray-400 font-light mt-0.5 mb-5">Anda tidak memiliki tiket gangguan berjalan. Klik tombol di bawah jika butuh bantuan teknis.</p>
                        <a href="{{ route('pengaduan.create') }}" class="inline-flex items-center px-6 py-2.5 bg-white border border-gray-200 rounded-full text-[10px] font-bold tracking-widest text-gray-500 hover:border-red-600 hover:text-red-600 transition-all shadow-sm">
                            MULAI ADUAN GANGGUAN
                        </a>
                    </div>
                    @endif
                </div>

                <div class="bg-white rounded-[2rem] shadow-xl shadow-gray-200/40 border border-gray-100 overflow-hidden">
                    <div class="px-6 py-5 border-b border-gray-50 flex items-center justify-between bg-gray-50/30">
                        <h3 class="text-xs font-bold uppercase tracking-wider text-gray-800 font-tegas">Arsip Riwayat Selesai</h3>
                        <span class="text-[9px] font-bold text-gray-400 bg-white px-2.5 py-0.5 rounded-full border border-gray-100 font-mono">{{ count($riwayatTiket) }} ITEMS</span>
                    </div>
                    
                    <div class="hidden md:block overflow-x-auto">
                        <table class="w-full text-left">
                            <thead>
                                <tr class="text-[10px] text-gray-400 uppercase tracking-[0.15em]">
                                    <th class="px-8 py-5 font-bold">No. Tiket</th>
                                    <th class="px-8 py-5 font-bold">Tanggal</th>
                                    <th class="px-8 py-5 font-bold">Deskripsi Keluhan</th>
                                    <th class="px-8 py-5 font-bold text-center">Status</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-50">
                                @forelse($riwayatTiket as $riwayat)
                                <tr class="hover:bg-gray-50/50 transition-all duration-200">
                                    <td class="px-8 py-5"><span class="text-xs font-bold text-gray-900 font-mono">#{{ $riwayat->nomor_tiket }}</span></td>
                                    <td class="px-8 py-5"><span class="text-xs text-gray-500 font-light">{{ $riwayat->created_at->format('d/m/Y') }}</span></td>
                                    <td class="px-8 py-5"><p class="text-xs text-gray-600 max-w-xs truncate">{{ $riwayat->deskripsi_keluhan ?? $riwayat->judul }}</p></td>
                                    <td class="px-8 py-5 text-center">
                                        <span class="px-2.5 py-0.5 rounded-full bg-green-50 text-green-600 text-[9px] font-bold uppercase tracking-wide ring-1 ring-green-100">Selesai</span>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="4" class="px-8 py-16 text-center text-xs font-light text-gray-400">Belum ada riwayat berkas penanganan selesai.</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <div class="block md:hidden divide-y divide-gray-100">
                        @forelse($riwayatTiket as $riwayat)
                        <div class="p-5 flex items-center justify-between gap-4">
                            <div>
                                <span class="text-[10px] font-mono text-gray-400 block">#{{ $riwayat->nomor_tiket }}</span>
                                <h5 class="text-xs font-bold text-gray-900 uppercase mt-0.5 tracking-wide">{{ Str::limit($riwayat->judul, 30) }}</h5>
                                <span class="text-[10px] text-gray-400 font-light block mt-1">{{ $riwayat->created_at->format('d M Y') }}</span>
                            </div>
                            <span class="px-2 py-0.5 rounded-full bg-green-50 text-green-600 text-[9px] font-bold uppercase tracking-wide shrink-0">Selesai</span>
                        </div>
                        @empty
                        <div class="p-8 text-center text-xs font-light text-gray-400">Belum ada riwayat berkas penanganan selesai.</div>
                        @endforelse
                    </div>

                </div>

            </div>
        </div>
    </div>
</x-app-layout>