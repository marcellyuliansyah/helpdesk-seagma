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
            background-image: linear-gradient(to right, #e2e8f0 1px, transparent 1px), linear-gradient(to bottom, #e2e8f0 1px, transparent 1px);
            background-size: 3rem 3rem;
        }

        .no-scrollbar::-webkit-scrollbar { display: none; }
        .no-scrollbar { -ms-overflow-style: none; scrollbar-width: none; }
    </style>

    <div class="relative min-h-screen bg-slate-50 pb-16 overflow-hidden">
        <div class="fixed inset-0 z-0 bg-grid-pattern opacity-60"></div>
        <div class="fixed top-[-10%] right-[-5%] w-[600px] h-[600px] bg-red-400/10 rounded-full blur-[120px] z-0 pointer-events-none"></div>
        <div class="fixed bottom-[-10%] left-[-5%] w-[600px] h-[600px] bg-rose-400/10 rounded-full blur-[120px] z-0 pointer-events-none"></div>
        <div class="fixed top-[25%] left-[35%] w-[420px] h-[420px] bg-slate-400/10 rounded-full blur-[110px] z-0 pointer-events-none"></div>

        <div class="relative z-10">
            {{-- HEADER --}}
            <div class="bg-white/80 backdrop-blur-md border-b border-slate-200 shadow-sm shadow-slate-200/50">
                <div class="max-w-7xl mx-auto py-8 px-4 sm:px-6 lg:px-8 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                    <div class="flex items-center gap-4">
                        <div class="w-12 h-12 rounded-2xl bg-gradient-to-br from-red-600 to-rose-600 flex items-center justify-center shadow-lg shadow-red-200 shrink-0">
                            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.111 16.404a5.5 5.5 0 017.778 0M12 20h.01M4.929 12.929a9 9 0 0114.142 0M1.343 9.343a13 13 0 0121.314 0" />
                            </svg>
                        </div>
                        <div>
                            <h2 class="text-2xl font-bold text-slate-800 font-tegas">
                                Panel Kendali Admin
                            </h2>
                            <p class="text-sm text-slate-500 mt-1 font-light">Pusat kendali pemantauan infrastruktur dan tiket gangguan masuk.</p>
                        </div>
                    </div>

                    <div class="flex flex-wrap items-center gap-3">
                        <span class="hidden md:inline-flex items-center gap-2 px-4 py-2.5 bg-red-50 text-red-700 text-xs font-semibold rounded-2xl ring-1 ring-red-100">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                            </svg>
                            {{ now()->locale('id')->translatedFormat('l, d F Y') }}
                        </span>

                        {{-- TOMBOL KELOLA KATEGORI (SUDAH DIPERBAIKI) --}}
                        <a href="{{ route('admin.kategori') }}"
                            class="inline-flex items-center gap-2 px-5 py-3 bg-slate-800 hover:bg-slate-900 text-white text-xs font-bold uppercase tracking-widest rounded-2xl shadow-lg shadow-slate-300 transition-all">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-6l-2-2H5a2 2 0 00-2 2z" />
                            </svg>
                            Kelola Kategori Masalah
                        </a>

                        {{-- TOMBOL KELOLA AKUN (SUDAH DIPERBAIKI) --}}
                        <a href="{{ route('admin.users') }}"
                            class="inline-flex items-center gap-2 px-5 py-3 bg-red-600 hover:bg-red-700 text-white text-xs font-bold uppercase tracking-widest rounded-2xl shadow-lg shadow-red-300 transition-all">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a4 4 0 00-3-3.87M9 20H4v-2a4 4 0 013-3.87m6-6.13a4 4 0 11-8 0 4 4 0 018 0zm6 4a4 4 0 10-8 0" />
                            </svg>
                            Kelola Akun
                        </a>
                    </div>
                </div>
            </div>

            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mt-10">

                @php
                    $totalTiket   = $stats['total'] ?? 0;
                    $pendingTiket = $stats['pending'] ?? 0;
                    $prosesTiket  = $stats['proses'] ?? 0;
                    $selesaiTiket = $stats['selesai'] ?? 0;

                    $pendingPct = $totalTiket > 0 ? round(($pendingTiket / $totalTiket) * 100) : 0;
                    $prosesPct  = $totalTiket > 0 ? round(($prosesTiket / $totalTiket) * 100) : 0;
                    $selesaiPct = $totalTiket > 0 ? round(($selesaiTiket / $totalTiket) * 100) : 0;

                    $stopSelesai = $selesaiPct;
                    $stopProses  = $selesaiPct + $prosesPct;
                    $stopPending = min($selesaiPct + $prosesPct + $pendingPct, 100);
                @endphp

                {{-- STAT CARDS --}}
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5 mb-6">
                    <div class="relative overflow-hidden bg-gradient-to-br from-slate-800 to-slate-900 rounded-[2rem] p-6 shadow-xl shadow-slate-300 border border-slate-700/50 group transform hover:-translate-y-1 transition-all duration-300">
                        <svg class="absolute -right-5 -bottom-5 w-32 h-32 text-white/5 group-hover:scale-110 transition-transform duration-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                        </svg>
                        <div class="relative flex items-center justify-between">
                            <div>
                                <p class="text-[10px] font-bold text-slate-300 uppercase tracking-widest">Total Tiket</p>
                                <p class="text-3xl font-extrabold text-white font-tegas mt-1">{{ $totalTiket }}</p>
                            </div>
                            <div class="w-12 h-12 rounded-2xl bg-white/10 backdrop-blur-sm flex items-center justify-center text-white ring-1 ring-white/20 group-hover:rotate-6 transition-transform">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                                </svg>
                            </div>
                        </div>
                        <p class="relative text-[10px] text-slate-400 font-medium mt-4 pt-3 border-t border-slate-700">Seluruh tiket yang tercatat di sistem</p>
                    </div>

                    <div class="relative overflow-hidden bg-gradient-to-br from-red-500 to-rose-600 rounded-[2rem] p-6 shadow-xl shadow-red-200 border border-red-400/30 group transform hover:-translate-y-1 transition-all duration-300">
                        <svg class="absolute -right-5 -bottom-5 w-32 h-32 text-white/10 group-hover:scale-110 transition-transform duration-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        <div class="relative flex items-center justify-between">
                            <div>
                                <p class="text-[10px] font-bold text-red-100 uppercase tracking-widest">Menunggu Verifikasi</p>
                                <p class="text-3xl font-extrabold text-white font-tegas mt-1">{{ $pendingTiket }}</p>
                            </div>
                            <div class="w-12 h-12 rounded-2xl bg-white/20 backdrop-blur-sm flex items-center justify-center text-white ring-1 ring-white/30 group-hover:rotate-6 transition-transform">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                            </div>
                        </div>
                        <p class="relative text-[10px] text-red-100/80 font-medium mt-4 pt-3 border-t border-white/15">{{ $pendingPct }}% dari total tiket</p>
                    </div>

                    <div class="relative overflow-hidden bg-gradient-to-br from-slate-500 to-slate-600 rounded-[2rem] p-6 shadow-xl shadow-slate-200 border border-slate-400/30 group transform hover:-translate-y-1 transition-all duration-300">
                        <svg class="absolute -right-5 -bottom-5 w-32 h-32 text-white/10 group-hover:scale-110 transition-transform duration-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                        </svg>
                        <div class="relative flex items-center justify-between">
                            <div>
                                <p class="text-[10px] font-bold text-slate-100 uppercase tracking-widest">Dalam Proses</p>
                                <p class="text-3xl font-extrabold text-white font-tegas mt-1">{{ $prosesTiket }}</p>
                            </div>
                            <div class="w-12 h-12 rounded-2xl bg-white/20 backdrop-blur-sm flex items-center justify-center text-white ring-1 ring-white/30 group-hover:rotate-6 transition-transform">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                </svg>
                            </div>
                        </div>
                        <p class="relative text-[10px] text-slate-200 font-medium mt-4 pt-3 border-t border-white/15">{{ $prosesPct }}% dari total tiket</p>
                    </div>

                    <div class="relative overflow-hidden bg-gradient-to-br from-emerald-500 to-teal-600 rounded-[2rem] p-6 shadow-xl shadow-emerald-200 border border-emerald-400/30 group transform hover:-translate-y-1 transition-all duration-300">
                        <svg class="absolute -right-5 -bottom-5 w-32 h-32 text-white/10 group-hover:scale-110 transition-transform duration-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        <div class="relative flex items-center justify-between">
                            <div>
                                <p class="text-[10px] font-bold text-emerald-100 uppercase tracking-widest">Selesai Diperbaiki</p>
                                <p class="text-3xl font-extrabold text-white font-tegas mt-1">{{ $selesaiTiket }}</p>
                            </div>
                            <div class="w-12 h-12 rounded-2xl bg-white/20 backdrop-blur-sm flex items-center justify-center text-white ring-1 ring-white/30 group-hover:rotate-6 transition-transform">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                            </div>
                        </div>
                        <p class="relative text-[10px] text-emerald-100/80 font-medium mt-4 pt-3 border-t border-white/15">{{ $selesaiPct }}% dari total tiket</p>
                    </div>
                </div>

                {{-- INSIGHT ROW --}}
                @php
                    $categoryCounts = [];
                    foreach ($semuaTiket as $t) {
                        $catName = $t->kategori->nama_kategori ?? 'Tanpa Kategori';
                        $categoryCounts[$catName] = ($categoryCounts[$catName] ?? 0) + 1;
                    }
                    arsort($categoryCounts);
                    $categoryCounts = array_slice($categoryCounts, 0, 5);
                    $maxCategoryCount = !empty($categoryCounts) ? max($categoryCounts) : 1;
                    $categoryBarColors = ['bg-red-500', 'bg-slate-800', 'bg-rose-400', 'bg-slate-500', 'bg-red-300'];
                @endphp

                <div class="grid grid-cols-1 lg:grid-cols-3 gap-5 mb-10">
                    <div class="bg-white rounded-[2rem] shadow-xl shadow-slate-200/50 border border-slate-100 p-7 flex flex-col">
                        <div class="flex items-center gap-2 mb-6">
                            <div class="w-8 h-8 rounded-xl bg-red-100 flex items-center justify-center text-red-600">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 3.055A9 9 0 1020.945 13H11V3.055z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.488 9H15V3.512A9.025 9.025 0 0120.488 9z" />
                                </svg>
                            </div>
                            <h3 class="text-sm font-bold text-slate-800 font-tegas">Distribusi Status Tiket</h3>
                        </div>

                        <div class="relative w-44 h-44 mx-auto rounded-full"
                            style="background: conic-gradient(#10b981 0% {{ $stopSelesai }}%, #64748b {{ $stopSelesai }}% {{ $stopProses }}%, #ef4444 {{ $stopProses }}% {{ $stopPending }}%, #e2e8f0 {{ $stopPending }}% 100%);">
                            <div class="absolute inset-[16px] bg-white rounded-full flex flex-col items-center justify-center shadow-[inset_0_2px_10px_rgba(0,0,0,0.05)]">
                                <span class="text-3xl font-extrabold text-slate-800 font-tegas">{{ $totalTiket }}</span>
                                <span class="text-[9px] uppercase tracking-widest text-slate-400 font-bold mt-1">Tiket</span>
                            </div>
                        </div>

                        <div class="mt-7 space-y-3">
                            <div class="flex items-center justify-between text-xs">
                                <span class="flex items-center gap-2 font-semibold text-slate-600">
                                    <span class="w-2.5 h-2.5 rounded-full bg-emerald-500"></span>Selesai
                                </span>
                                <span class="font-bold text-slate-800">{{ $selesaiTiket }} <span class="text-slate-400 font-medium">({{ $selesaiPct }}%)</span></span>
                            </div>
                            <div class="flex items-center justify-between text-xs">
                                <span class="flex items-center gap-2 font-semibold text-slate-600">
                                    <span class="w-2.5 h-2.5 rounded-full bg-slate-500"></span>Diproses
                                </span>
                                <span class="font-bold text-slate-800">{{ $prosesTiket }} <span class="text-slate-400 font-medium">({{ $prosesPct }}%)</span></span>
                            </div>
                            <div class="flex items-center justify-between text-xs">
                                <span class="flex items-center gap-2 font-semibold text-slate-600">
                                    <span class="w-2.5 h-2.5 rounded-full bg-red-500"></span>Menunggu
                                </span>
                                <span class="font-bold text-slate-800">{{ $pendingTiket }} <span class="text-slate-400 font-medium">({{ $pendingPct }}%)</span></span>
                            </div>
                        </div>
                    </div>

                    <div class="lg:col-span-2 bg-white rounded-[2rem] shadow-xl shadow-slate-200/50 border border-slate-100 p-7">
                        <div class="flex items-center gap-2 mb-6">
                            <div class="w-8 h-8 rounded-xl bg-slate-100 flex items-center justify-center text-slate-800">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z" />
                                </svg>
                            </div>
                            <h3 class="text-sm font-bold text-slate-800 font-tegas">Kategori Gangguan Teratas</h3>
                        </div>

                        @if (count($categoryCounts) > 0)
                            <div class="space-y-5">
                                @foreach ($categoryCounts as $catName => $count)
                                    @php
                                        $colorClass = $categoryBarColors[$loop->index % count($categoryBarColors)];
                                        $widthPct = $maxCategoryCount > 0 ? round(($count / $maxCategoryCount) * 100) : 0;
                                    @endphp
                                    <div>
                                        <div class="flex items-center justify-between mb-1.5">
                                            <span class="text-xs font-semibold text-slate-700">{{ $catName }}</span>
                                            <span class="text-xs font-bold text-slate-500">{{ $count }} tiket</span>
                                        </div>
                                        <div class="w-full h-2.5 bg-slate-100 rounded-full overflow-hidden">
                                            <div class="h-full {{ $colorClass }} rounded-full transition-all duration-700" style="width: {{ $widthPct }}%"></div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @else
                            <div class="flex flex-col items-center justify-center py-10 opacity-40">
                                <p class="text-xs font-semibold tracking-wide text-slate-500 uppercase">Belum ada data kategori</p>
                            </div>
                        @endif
                    </div>
                </div>

                {{-- TABEL PENGADUAN --}}
                <div class="bg-white rounded-[2rem] shadow-xl shadow-slate-200/50 border border-slate-100 overflow-hidden" x-data="{ search: '', statusFilter: 'all' }">
    <div class="px-8 py-6 flex flex-col lg:flex-row lg:items-center justify-between gap-4 bg-gradient-to-r from-slate-800 to-slate-900 border-b border-slate-700">
        
        {{-- JUDUL TABEL --}}
        <h3 class="flex items-center gap-2 text-sm font-bold uppercase tracking-wider text-white font-tegas whitespace-nowrap">
            <svg class="w-4 h-4 text-red-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17V7m0 10a2 2 0 01-2 2H5a2 2 0 01-2-2V7a2 2 0 012-2h2a2 2 0 012 2m0 10a2 2 0 002 2h2a2 2 0 002-2M9 7a2 2 0 012-2h2a2 2 0 012 2m0 10V7m0 10a2 2 0 002 2h2a2 2 0 002-2V7a2 2 0 00-2-2h-2a2 2 0 00-2 2" />
            </svg>
            Daftar Pengaduan Jaringan
        </h3>
        
        {{-- FORM CETAK LAPORAN --}}
        <form action="{{ route('admin.cetak.pdf') }}" method="GET" class="flex flex-wrap items-center gap-3">
            
            {{-- Dropdown Bulan (Background Putih, Teks Gelap) --}}
            <select name="bulan" class="bg-white border border-slate-300 text-slate-800 text-sm font-medium rounded-xl px-4 py-2 focus:ring-red-500 focus:border-red-500 outline-none shadow-sm cursor-pointer transition-all w-32 md:w-40">
                <option value="">Pilih Bulan</option>
                <option value="1">Januari</option>
                <option value="2">Februari</option>
                <option value="3">Maret</option>
                <option value="4">April</option>
                <option value="5">Mei</option>
                <option value="6">Juni</option>
                <option value="7">Juli</option>
                <option value="8">Agustus</option>
                <option value="9">September</option>
                <option value="10">Oktober</option>
                <option value="11">November</option>
                <option value="12">Desember</option>
            </select>
            
            {{-- Dropdown Tahun (Background Putih, Teks Gelap) --}}
            <select name="tahun" class="bg-white border border-slate-300 text-slate-800 text-sm font-medium rounded-xl px-4 py-2 focus:ring-red-500 focus:border-red-500 outline-none shadow-sm cursor-pointer transition-all w-32 md:w-40">
                <option value="">Pilih Tahun</option>
                @foreach(range(date('Y'), date('Y') - 5) as $year)
                    <option value="{{ $year }}">{{ $year }}</option>
                @endforeach
            </select>

            {{-- Tombol Submit --}}
            <button type="submit"
                class="inline-flex items-center justify-center px-4 py-2 bg-red-600 hover:bg-red-500 border border-transparent text-white text-xs font-bold uppercase tracking-widest rounded-xl transition-all duration-300 shadow-sm cursor-pointer">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z" />
                </svg>
                Cetak PDF
            </button>
            
        </form>
    </div>

                    <div class="px-8 py-4 bg-slate-50/70 border-b border-slate-100 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
                        <div class="relative w-full sm:w-72">
                            <svg class="w-4 h-4 text-slate-400 absolute left-3 top-1/2 -translate-y-1/2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-5.197-5.197m0 0A7.5 7.5 0 105.196 5.196a7.5 7.5 0 0010.607 10.607z" />
                            </svg>
                            <input type="text" x-model="search" placeholder="Cari pelanggan atau tiket teknisi"
                                class="w-full pl-9 pr-4 py-2.5 text-xs bg-white border border-slate-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-red-300 focus:border-red-300 placeholder:text-slate-400">
                        </div>

                        <div class="flex items-center gap-2 overflow-x-auto no-scrollbar">
                            <button type="button" @click="statusFilter = 'all'"
                                :class="statusFilter === 'all' ? 'bg-slate-800 text-white border-slate-800' : 'bg-white text-slate-600 border-slate-200 hover:border-slate-300'"
                                class="px-3 py-1.5 text-[10px] font-bold uppercase tracking-wider rounded-lg border transition-all whitespace-nowrap">
                                Semua ({{ $totalTiket }})
                            </button>
                            <button type="button" @click="statusFilter = 'menunggu verifikasi'"
                                :class="statusFilter === 'menunggu verifikasi' ? 'bg-red-500 text-white border-red-500' : 'bg-white text-slate-600 border-slate-200 hover:border-red-300'"
                                class="px-3 py-1.5 text-[10px] font-bold uppercase tracking-wider rounded-lg border transition-all whitespace-nowrap">
                                Menunggu ({{ $pendingTiket }})
                            </button>
                            <button type="button" @click="statusFilter = 'diproses'"
                                :class="statusFilter === 'diproses' ? 'bg-slate-600 text-white border-slate-600' : 'bg-white text-slate-600 border-slate-200 hover:border-slate-400'"
                                class="px-3 py-1.5 text-[10px] font-bold uppercase tracking-wider rounded-lg border transition-all whitespace-nowrap">
                                Diproses ({{ $prosesTiket }})
                            </button>
                            <button type="button" @click="statusFilter = 'selesai'"
                                :class="statusFilter === 'selesai' ? 'bg-emerald-500 text-white border-emerald-500' : 'bg-white text-slate-600 border-slate-200 hover:border-emerald-300'"
                                class="px-3 py-1.5 text-[10px] font-bold uppercase tracking-wider rounded-lg border transition-all whitespace-nowrap">
                                Selesai ({{ $selesaiTiket }})
                            </button>
                        </div>
                    </div>

                    <div class="overflow-x-auto">
                        <table class="w-full text-left">
                            <thead>
                                <tr class="text-[10px] text-slate-500 uppercase tracking-[0.15em] bg-slate-50 border-b border-slate-100">
                                    <th class="px-8 py-4 font-bold">Pelanggan</th>
                                    <th class="px-8 py-4 font-bold">Detail Gangguan</th>
                                    <th class="px-8 py-4 font-bold">Status</th>
                                    <th class="px-8 py-4 font-bold">Tgl. Masuk</th>
                                    <th class="px-8 py-4 font-bold">Teknisi Penanggung Jawab</th>
                                    <th class="px-8 py-4 font-bold text-center">Tindakan</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-slate-50">
                                @forelse($semuaTiket as $tiket)
                                    @php
                                        $custName = $tiket->pelanggan->name ?? 'User Hilang';
                                        $avatarPalette = ['bg-red-500', 'bg-slate-700', 'bg-rose-500', 'bg-emerald-500', 'bg-slate-500', 'bg-red-400'];
                                        $avatarColor = $avatarPalette[crc32($custName) % count($avatarPalette)];
                                        $initial = strtoupper(substr($custName, 0, 1));

                                        $rowAccent = match ($tiket->status) {
                                            'menunggu verifikasi' => 'border-l-red-400',
                                            'diproses' => 'border-l-slate-400',
                                            default => 'border-l-emerald-400',
                                        };

                                        $categoryBadgePalette = [
                                            'bg-red-50 text-red-700 ring-red-200',
                                            'bg-slate-50 text-slate-700 ring-slate-200',
                                            'bg-rose-50 text-rose-700 ring-rose-200',
                                            'bg-neutral-50 text-neutral-700 ring-neutral-200',
                                        ];
                                        $categoryBadgeClass = $tiket->kategori
                                            ? $categoryBadgePalette[crc32($tiket->kategori->nama_kategori) % count($categoryBadgePalette)]
                                            : 'bg-slate-100 text-slate-500 ring-slate-200';

                                        $searchHaystack = Str::lower($custName . ' ' . $tiket->judul . ' ' . ($tiket->nomor_tiket ?? $tiket->id));
                                    @endphp
                                    <tr
                                        data-search="{{ $searchHaystack }}"
                                        data-status="{{ $tiket->status }}"
                                        x-show="(search === '' || $el.dataset.search.includes(search.toLowerCase())) && (statusFilter === 'all' || statusFilter === $el.dataset.status)"
                                        class="group hover:bg-red-50/40 transition-all duration-200 border-l-4 {{ $rowAccent }}"
                                    >
                                        <td class="px-8 py-4">
                                            <div class="flex items-center gap-3">
                                                <div class="w-9 h-9 rounded-full {{ $avatarColor }} flex items-center justify-center text-white text-xs font-bold shrink-0 ring-2 ring-white shadow-sm">
                                                    {{ $initial }}
                                                </div>
                                                <div>
                                                    <p class="text-xs font-bold text-slate-900 uppercase tracking-wide">{{ $custName }}</p>
                                                    <p class="text-[10px] text-slate-500 font-mono mt-0.5">#{{ $tiket->nomor_tiket ?? $tiket->id }}</p>
                                                </div>
                                            </div>
                                        </td>

                                        <td class="px-8 py-4">
                                            <p class="text-xs font-semibold text-slate-800">
                                                {{ Str::limit($tiket->judul, 35) }}</p>
                                            <p class="text-[11px] text-slate-500 font-light mt-0.5 max-w-xs truncate">
                                                {{ $tiket->deskripsi }}</p>

                                            @if ($tiket->kategori)
                                                <span class="inline-flex mt-1.5 text-[8px] {{ $categoryBadgeClass }} px-2 py-0.5 rounded-full font-bold uppercase tracking-wider ring-1">
                                                    {{ $tiket->kategori->nama_kategori }}
                                                </span>
                                            @else
                                                <span class="inline-flex mt-1.5 text-[8px] bg-slate-100 text-slate-500 px-2 py-0.5 rounded-full font-medium uppercase tracking-wider italic ring-1 ring-slate-200">
                                                    Kosong
                                                </span>
                                            @endif
                                        </td>

                                        <td class="px-8 py-4">
                                            @if ($tiket->status == 'menunggu verifikasi')
                                                <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full bg-red-50 text-red-700 text-[9px] font-bold uppercase tracking-tight ring-1 ring-red-200">
                                                    <span class="w-1.5 h-1.5 rounded-full bg-red-500 animate-pulse"></span>Menunggu
                                                </span>
                                            @elseif($tiket->status == 'diproses')
                                                <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full bg-slate-100 text-slate-700 text-[9px] font-bold uppercase tracking-tight ring-1 ring-slate-200">
                                                    <span class="w-1.5 h-1.5 rounded-full bg-slate-500"></span>Diproses
                                                </span>
                                            @else
                                                <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full bg-emerald-50 text-emerald-700 text-[9px] font-bold uppercase tracking-tight ring-1 ring-emerald-200">
                                                    <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span>Selesai
                                                </span>
                                            @endif
                                        </td>

                                        <td class="px-8 py-4">
                                            <span class="text-[11px] text-slate-500 font-medium">{{ $tiket->created_at->format('d M Y H:i') ?? '-' }}</span>
                                        </td>

                                        <td class="px-8 py-4">
                                            <span class="text-xs font-bold text-slate-700">{{ $tiket->teknisi->name ?? 'Belum Ditugaskan' }}</span>
                                        </td>

                                        {{-- TOMBOL DETAIL TIKET (SUDAH DIPERBAIKI) --}}
                                        <td class="px-8 py-4 text-center">
                                            <a href="{{ route('admin.pengaduan.show', $tiket->id) }}" class="inline-flex items-center justify-center w-8 h-8 rounded-full bg-white text-slate-400 hover:text-slate-700 hover:bg-slate-100 ring-1 ring-slate-200 shadow-sm transition-all duration-200" title="Lihat Detail">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                                </svg>
                                            </a>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="px-8 py-12 text-center">
                                            <div class="flex flex-col items-center justify-center text-slate-400">
                                                <svg class="w-10 h-10 mb-3 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0a2 2 0 01-2 2H6a2 2 0 01-2-2m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4" />
                                                </svg>
                                                <p class="text-sm font-semibold text-slate-500">Belum ada data pengaduan masuk.</p>
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