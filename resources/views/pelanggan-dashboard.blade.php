<x-app-layout>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&family=Poppins:wght@500;600;700&display=swap');
        
        .font-tegas { font-family: 'Poppins', sans-serif; }
        body { font-family: 'Inter', sans-serif; }

        .bg-grid-pattern {
            background-image: linear-gradient(to right, #e2e8f0 1px, transparent 1px), linear-gradient(to bottom, #e2e8f0 1px, transparent 1px);
            background-size: 40px 40px;
        }
    </style>

    <div class="relative min-h-screen bg-[#fafafc] pb-12">
        <div class="fixed inset-0 z-0 bg-grid-pattern opacity-60"></div>

        <div class="relative z-10 max-w-[1400px] mx-auto px-4 sm:px-6 lg:px-8 pt-8 sm:pt-10">
            
            <div class="flex flex-col md:flex-row md:items-center justify-between gap-6 mb-10">
                <div class="flex items-center gap-4 sm:gap-5">
                    <div class="w-12 h-12 sm:w-[3.25rem] sm:h-[3.25rem] bg-[#ea3a3d] rounded-2xl flex items-center justify-center text-white shadow-lg shadow-red-200/50 shrink-0">
                        <svg class="w-6 h-6 sm:w-7 sm:h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                    </div>
                    <div>
                        <h2 class="text-xl sm:text-[26px] font-bold text-gray-900 font-tegas leading-tight">
                            Halo, {{ Auth::user()->name }}!
                        </h2>
                        <p class="text-xs sm:text-sm text-gray-500 mt-1 font-medium">
                            Selamat datang di Portal Helpdesk PT Semeru Agung Mandiri.
                        </p>
                    </div>
                </div>
                
                <div class="flex items-center gap-3 w-full md:w-auto">
                    <div class="hidden sm:flex items-center gap-2 px-5 py-2.5 bg-[#fef2f2] text-[#ea3a3d] rounded-full text-xs font-semibold border border-[#fee2e2]">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                        {{ \Carbon\Carbon::now()->translatedFormat('l, d F Y') }}
                    </div>

                    @if(!$tiketAktif)
                    <a href="{{ route('pengaduan.create') }}" class="flex-1 sm:flex-none flex items-center justify-center px-6 py-3 bg-[#ea3a3d] hover:bg-red-700 text-white text-[11px] font-bold tracking-wider rounded-full shadow-md transition-all duration-300">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                        BUAT TIKET GANGGUAN
                    </a>
                    @endif
                </div>
            </div>

            @if(session('success'))
            <div class="mb-8 bg-green-50 border border-green-100 rounded-2xl p-4 flex items-center gap-4 animate-fade-in-down">
                <div class="bg-[#10b981] p-2 rounded-xl text-white shrink-0">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                </div>
                <div>
                    <h4 class="text-sm font-bold text-green-900">Berhasil!</h4>
                    <p class="text-xs text-green-700 font-medium">{{ session('success') }}</p>
                </div>
            </div>
            @endif

            <div class="mb-10">
                <h4 class="text-[11px] font-bold text-gray-800 uppercase tracking-wider mb-4 ml-1 flex items-center gap-2">
                    <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    Status Pengaduan Aktif
                </h4>

                @if($tiketAktif)
                <div class="bg-white rounded-[2rem] border border-gray-100 shadow-sm overflow-hidden transition-all duration-500 relative">
                    <div class="absolute top-0 left-0 w-full sm:w-2 h-1 sm:h-full {{ $tiketAktif->status == 'menunggu verifikasi' ? 'bg-[#ea3a3d]' : 'bg-[#10b981]' }}"></div>
                    
                    <div class="p-6 sm:p-10">
                        <div class="flex flex-col lg:flex-row lg:items-center justify-between gap-6">
                            <div class="flex-1 sm:pl-4">
                                <div class="flex items-center gap-3 mb-3">
                                    <span class="px-3 py-1 rounded-full {{ $tiketAktif->status == 'menunggu verifikasi' ? 'bg-[#fef2f2] text-[#ea3a3d] border border-[#fee2e2]' : 'bg-green-50 text-[#10b981] border border-green-100' }} text-[10px] font-bold uppercase tracking-wide">
                                        {{ $tiketAktif->status == 'menunggu verifikasi' ? 'menunggu' : $tiketAktif->status }}
                                    </span>
                                    <span class="text-xs text-gray-400 font-bold font-mono">#{{ $tiketAktif->nomor_tiket ?? $tiketAktif->id }}</span>
                                </div>
                                
                                <h3 class="text-lg sm:text-[22px] font-bold text-gray-900 font-tegas leading-tight">
                                    {{ $tiketAktif->judul }}
                                </h3>
                                <p class="text-xs text-gray-500 font-medium mt-2 line-clamp-3 md:hidden">{{ $tiketAktif->deskripsi }}</p>
                                
                                <div class="mt-4 sm:mt-5 flex items-center gap-6 text-[11px] text-gray-500 font-medium">
                                    <div class="flex items-center gap-1.5">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                                        {{ $tiketAktif->created_at->format('d M Y, h:i') }}
                                    </div>
                                </div>
                            </div>

                            @if($tiketAktif->status == 'menunggu verifikasi')
                            <div class="shrink-0 w-full lg:w-auto">
                                <form action="{{ route('pengaduan.destroy', $tiketAktif->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin membatalkan laporan ini?');">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="w-full px-6 py-3 rounded-full bg-white border border-[#fee2e2] text-[#ea3a3d] text-[11px] font-bold uppercase tracking-widest hover:bg-[#fef2f2] transition-all duration-300">
                                        Batalkan Laporan
                                    </button>
                                </form>
                            </div>
                            @endif
                        </div>
                    </div>

                    <div class="bg-gray-50/50 px-6 sm:px-10 py-4 border-t border-gray-50">
                        <p class="text-[11px] text-gray-500 font-medium flex items-center gap-2">
                            <span class="w-1.5 h-1.5 rounded-full bg-gray-400"></span>
                            Pengajuan pengaduan baru dinonaktifkan sementara hingga tiket aktif ini selesai ditangani.
                        </p>
                    </div>
                </div>
                @else
                <div class="bg-white border border-gray-100 rounded-[2rem] p-8 sm:p-12 text-center group hover:shadow-md transition-all duration-500 shadow-sm">
                    <div class="w-14 h-14 bg-gray-50 rounded-2xl flex items-center justify-center mx-auto mb-4 group-hover:bg-[#fef2f2] transition-all">
                        <svg class="w-7 h-7 text-gray-400 group-hover:text-[#ea3a3d]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                    </div>
                    <h5 class="text-base font-bold text-gray-900 font-tegas">Jaringan Terpantau Normal</h5>
                    <p class="text-[13px] text-gray-500 font-medium mt-1 mb-6">Anda tidak memiliki tiket gangguan berjalan. Klik tombol di bawah jika butuh bantuan teknis.</p>
                    <a href="{{ route('pengaduan.create') }}" class="inline-flex items-center px-8 py-3 bg-white border border-gray-200 rounded-full text-[11px] font-bold tracking-widest text-gray-700 hover:border-[#ea3a3d] hover:text-[#ea3a3d] transition-all">
                        MULAI ADUAN GANGGUAN
                    </a>
                </div>
                @endif
            </div>

            <div class="bg-white rounded-[2rem] shadow-sm border border-gray-100 overflow-hidden mb-10 p-6 sm:p-8">
                <div class="flex items-center justify-between mb-6">
                    <h3 class="text-sm font-bold text-gray-800 font-tegas">Arsip Riwayat Selesai</h3>
                    <span class="text-[10px] font-bold text-gray-500 bg-gray-50 px-3 py-1 rounded-full border border-gray-100">{{ count($riwayatTiket) }} TIKET</span>
                </div>
                
                <div class="hidden md:block overflow-x-auto">
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr class="text-[11px] text-gray-400 font-bold uppercase tracking-wider border-b border-gray-100">
                                <th class="px-4 py-4 w-32">No. Tiket</th>
                                <th class="px-4 py-4 w-40">Tanggal</th>
                                <th class="px-4 py-4">Deskripsi Keluhan</th>
                                <th class="px-4 py-4 w-32 text-center">Status</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-50">
                            @forelse($riwayatTiket as $riwayat)
                            <tr class="hover:bg-gray-50/50 transition-all duration-200">
                                <td class="px-4 py-4"><span class="text-[13px] font-bold text-gray-600 font-mono">#{{ $riwayat->nomor_tiket }}</span></td>
                                <td class="px-4 py-4"><span class="text-[13px] text-gray-500 font-medium">{{ $riwayat->created_at->format('d/m/Y') }}</span></td>
                                <td class="px-4 py-4"><p class="text-[13px] font-bold text-gray-800 max-w-md truncate">{{ $riwayat->deskripsi_keluhan ?? $riwayat->judul }}</p></td>
                                <td class="px-4 py-4 text-center">
                                    <span class="px-4 py-1.5 rounded-full bg-[#10b981] text-white text-[10px] font-bold tracking-wide shadow-sm">SELESAI</span>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="4" class="px-4 py-12 text-center text-[13px] font-medium text-gray-400">Belum ada riwayat berkas penanganan selesai.</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <div class="block md:hidden divide-y divide-gray-50">
                    @forelse($riwayatTiket as $riwayat)
                    <div class="py-4 flex items-center justify-between gap-4">
                        <div>
                            <span class="text-[11px] font-mono font-bold text-gray-400 block">#{{ $riwayat->nomor_tiket }}</span>
                            <h5 class="text-[13px] font-bold text-gray-800 mt-0.5">{{ Str::limit($riwayat->judul, 30) }}</h5>
                            <span class="text-[11px] text-gray-500 font-medium block mt-1">{{ $riwayat->created_at->format('d M Y') }}</span>
                        </div>
                        <span class="px-3 py-1 rounded-full bg-[#10b981] text-white text-[9px] font-bold tracking-wide shrink-0 shadow-sm">SELESAI</span>
                    </div>
                    @empty
                    <div class="py-8 text-center text-xs font-medium text-gray-400">Belum ada riwayat berkas penanganan selesai.</div>
                    @endforelse
                </div>
            </div>

        </div>
    </div>
</x-app-layout>