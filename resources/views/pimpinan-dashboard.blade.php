<x-app-layout>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600&family=Poppins:wght@400;500;600;700;800&display=swap');

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

        .stat-glow::after {
            content: '';
            position: absolute;
            inset: 0;
            border-radius: inherit;
            box-shadow: 0 30px 60px -20px rgba(0,0,0,0.25);
            opacity: 0;
            transition: opacity .3s ease;
            pointer-events: none;
        }
        .stat-glow:hover::after { opacity: 1; }
    </style>

    <div class="relative min-h-screen bg-white bg-gradient-to-b from-white via-white to-slate-100/50 pb-16">

        <div class="fixed inset-0 z-0 bg-grid-pattern opacity-50"></div>
        <div class="fixed top-[-5%] right-[-5%] w-[600px] h-[600px] bg-red-50/30 rounded-full blur-[130px] z-0 pointer-events-none"></div>

        <div class="relative z-10">

            {{-- ================= TITLE / ACTIONS ================= --}}
            <div class="bg-white/70 backdrop-blur-md border-b border-gray-100">
                <div class="max-w-7xl mx-auto py-8 px-4 sm:px-6 lg:px-8 flex flex-col lg:flex-row lg:items-center lg:justify-between gap-5">

                    <div class="flex items-center gap-4">
                        <div class="w-14 h-14 rounded-2xl bg-red-600 flex items-center justify-center shadow-lg shadow-red-200 shrink-0">
                            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 10-8 0v4M5 11h14l1 9H4l1-9z" />
                            </svg>
                        </div>
                        <div>
                            <span class="text-[9px] font-bold text-red-600 uppercase tracking-[0.2em] block mb-1 font-tegas">
                                Sistem Hak Akses Utama
                            </span>
                            <h2 class="text-2xl font-bold text-gray-950 font-tegas leading-none">
                                Dashboard Pimpinan
                            </h2>
                            <p class="text-xs text-gray-500 mt-1.5 font-light">
                                Pusat kendali otentikasi dan ekosistem pengguna PT Seagma.
                            </p>
                        </div>
                    </div>

                    <div class="flex flex-wrap items-center gap-3">
                        <span class="inline-flex items-center gap-2 px-4 py-2.5 bg-red-50 text-red-600 text-xs font-bold rounded-full border border-red-100">
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                            </svg>
                            {{ \Carbon\Carbon::now()->translatedFormat('l, d F Y') }}
                        </span>

                        <a href="{{ route('pimpinan.validasi.teknisi') }}"
                            class="inline-flex items-center justify-center px-5 py-2.5 bg-gray-950 hover:bg-red-600 text-white text-xs font-bold uppercase tracking-widest rounded-full shadow-lg transition-all duration-300 transform hover:-translate-y-0.5">
                            Validasi Teknisi
                        </a>
                        <a href="{{ route('pimpinan.pengaturan') }}"
                            class="inline-flex items-center justify-center px-5 py-2.5 bg-red-600 hover:bg-gray-950 text-white text-xs font-semibold uppercase tracking-widest rounded-full shadow-md hover:shadow-lg transition-all duration-300">
                            <svg class="w-3.5 h-3.5 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                            </svg>
                            Sistem Pengaturan
                        </a>
                    </div>
                </div>
            </div>

            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mt-10">

                @if (session('success'))
                    <div class="mb-8 bg-green-50/80 border border-green-100 rounded-2xl p-4 flex items-center gap-3">
                        <div class="text-green-500 shrink-0">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </div>
                        <span class="text-xs font-semibold text-gray-900">{{ session('success') }}</span>
                    </div>
                @endif

                {{-- ================= STAT CARDS ================= --}}
                <div class="grid grid-cols-1 sm:grid-cols-3 gap-6 mb-10 relative z-20">

                    {{-- TOTAL PELANGGAN — dark navy card --}}
                    <a href="{{ route('pimpinan.users.list', 'pelanggan') }}"
                        class="stat-glow relative overflow-hidden bg-gray-950 rounded-[2rem] p-6 shadow-xl flex items-center justify-between hover:-translate-y-1 duration-300 transition block">
                        <div class="absolute -right-6 -bottom-8 w-28 h-28 rounded-full bg-white/5"></div>
                        <div class="relative z-10">
                            <p class="text-[10px] font-bold text-gray-400 uppercase tracking-widest">
                                Total Akun Pelanggan
                            </p>
                            <p class="text-4xl font-extrabold text-white font-tegas mt-1">
                                {{ $totalPelanggan }}
                            </p>
                            <p class="text-[10px] text-gray-400 mt-2 font-medium">
                                Seluruh pelanggan terdaftar
                            </p>
                        </div>
                        <div class="relative z-10 w-12 h-12 rounded-2xl bg-white/10 flex items-center justify-center text-white shrink-0">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                            </svg>
                        </div>
                    </a>

                    {{-- DATA TEKNISI — red card --}}
                    <a href="{{ route('pimpinan.users.list', 'teknisi') }}"
                        class="stat-glow relative overflow-hidden bg-red-600 rounded-[2rem] p-6 shadow-xl shadow-red-200/40 flex items-center justify-between hover:-translate-y-1 duration-300 transition block">
                        <div class="absolute -right-6 -bottom-8 w-28 h-28 rounded-full bg-white/10"></div>
                        <div class="relative z-10">
                            <p class="text-[10px] font-bold text-white/80 uppercase tracking-widest">
                                Data Teknisi
                            </p>
                            <p class="text-4xl font-extrabold text-white font-tegas mt-1">
                                {{ $totalTeknisi }}
                            </p>
                            <p class="text-[10px] text-white/80 mt-2 font-medium">
                                Klik untuk validasi &amp; kelola
                            </p>
                        </div>
                        <div class="relative z-10 w-12 h-12 rounded-2xl bg-white/15 flex items-center justify-center text-white shrink-0">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                            </svg>
                        </div>
                    </a>

                    {{-- DATA ADMIN — emerald card --}}
                    <a href="{{ route('pimpinan.users.list', 'admin') }}"
                        class="stat-glow relative overflow-hidden bg-emerald-600 rounded-[2rem] p-6 shadow-xl shadow-emerald-200/40 flex items-center justify-between hover:-translate-y-1 duration-300 transition block">
                        <div class="absolute -right-6 -bottom-8 w-28 h-28 rounded-full bg-white/10"></div>
                        <div class="relative z-10">
                            <p class="text-[10px] font-bold text-white/80 uppercase tracking-widest">
                                Staf Operator Admin
                            </p>
                            <p class="text-4xl font-extrabold text-white font-tegas mt-1">
                                {{ $totalAdmin }}
                            </p>
                            <p class="text-[10px] text-white/80 mt-2 font-medium">
                                Klik untuk melihat data
                            </p>
                        </div>
                        <div class="relative z-10 w-12 h-12 rounded-2xl bg-white/15 flex items-center justify-center text-white shrink-0">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                            </svg>
                        </div>
                    </a>

                </div>

                {{-- ================= DISTRIBUSI STATUS & KATEGORI ================= --}}
                @php
                    // NORMALISASI: Hapus spasi berlebih, jadikan huruf kecil, lalu beri huruf kapital di awal setiap kata
                    $statusGroups = collect($tikets)->groupBy(function($item) {
                        return ucwords(strtolower(trim($item->status)));
                    });
                    
                    $totalTiketTampil = collect($tikets)->count();

                    // PEMETAAN VARIASI STATUS (BAHASA INGGRIS DAN INDONESIA)
                    $statusMeta = [
                        'Open'                => ['label' => 'Menunggu Verifikasi', 'color' => '#ef4444'],
                        'Pending'             => ['label' => 'Menunggu Verifikasi', 'color' => '#ef4444'],
                        'Menunggu'            => ['label' => 'Menunggu Verifikasi', 'color' => '#ef4444'],
                        'Menunggu Verifikasi' => ['label' => 'Menunggu Verifikasi', 'color' => '#ef4444'],

                        'In Progress'         => ['label' => 'Dalam Proses',        'color' => '#64748b'],
                        'Proses'              => ['label' => 'Dalam Proses',        'color' => '#64748b'],
                        'Diproses'            => ['label' => 'Dalam Proses',        'color' => '#64748b'],
                        'Dalam Proses'        => ['label' => 'Dalam Proses',        'color' => '#64748b'],

                        'Resolved'            => ['label' => 'Selesai Diperbaiki',  'color' => '#10b981'],
                        'Selesai'             => ['label' => 'Selesai Diperbaiki',  'color' => '#10b981'],
                        'Selesai Diperbaiki'  => ['label' => 'Selesai Diperbaiki',  'color' => '#10b981'],
                    ];

                    $segments = [];
                    $offset = 0;
                    foreach ($statusGroups as $statusKey => $items) {
                        $count = $items->count();
                        $pct = $totalTiketTampil > 0 ? ($count / $totalTiketTampil) * 100 : 0;
                        
                        // Fallback ke warna abu-abu muda jika key tidak terdaftar
                        $color = $statusMeta[$statusKey]['color'] ?? '#9ca3af';
                        
                        $segments[] = "$color $offset% " . ($offset + $pct) . "%";
                        $offset += $pct;
                    }
                    $conicGradient = count($segments) ? implode(', ', $segments) : '#e5e7eb 0% 100%';

                    $kategoriGroups = collect($tikets)
                        ->groupBy(fn ($t) => $t->kategori->nama_kategori ?? 'Tanpa Kategori')
                        ->map(fn ($items) => $items->count())
                        ->sortDesc()
                        ->take(5);
                    $maxKategori = $kategoriGroups->max() ?: 1;
                @endphp

                <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-10 relative z-20">

                    {{-- DONUT: DISTRIBUSI STATUS --}}
                    <div class="bg-white rounded-[2rem] p-7 shadow-xl shadow-gray-200/20 border border-gray-100/50">
                        <div class="flex items-center gap-2.5 mb-6">
                            <div class="w-8 h-8 rounded-xl bg-red-50 flex items-center justify-center text-red-500">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 3.055A9 9 0 1020.945 13H11V3.055z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.488 9H15V3.512A9.025 9.025 0 0120.488 9z" />
                                </svg>
                            </div>
                            <h3 class="text-sm font-bold text-gray-800 font-tegas">Distribusi Status Tiket</h3>
                        </div>

                        <div class="flex items-center justify-center py-2">
                            <div class="relative w-48 h-48 rounded-full flex items-center justify-center"
                                style="background: conic-gradient({{ $conicGradient }});">
                                {{-- Mengubah dari w-32 h-32 menjadi w-40 h-40 agar lingkaran luar terlihat lebih tipis --}}
                                <div class="absolute w-40 h-40 bg-white rounded-full flex flex-col items-center justify-center shadow-inner">
                                    <span class="text-3xl font-extrabold text-gray-900 font-tegas">{{ $totalTiketTampil }}</span>
                                    <span class="text-[10px] font-bold text-gray-400 uppercase tracking-widest">Tiket</span>
                                </div>
                            </div>
                        </div>

                        <div class="flex flex-wrap justify-center gap-4 mt-4">
                            @foreach (collect(['Menunggu Verifikasi' => 'Menunggu', 'Diproses' => 'Proses', 'Selesai' => 'Selesai']) as $key => $label)
                                <span class="inline-flex items-center gap-1.5 text-[10px] font-bold text-gray-500 uppercase tracking-wider">
                                    <span class="w-2 h-2 rounded-full" style="background-color: {{ $statusMeta[$key]['color'] ?? '#9ca3af' }}"></span>
                                    {{ $label }}
                                </span>
                            @endforeach
                        </div>
                    </div>

                    {{-- KATEGORI GANGGUAN TERATAS --}}
                    <div class="bg-white rounded-[2rem] p-7 shadow-xl shadow-gray-200/20 border border-gray-100/50">
                        <div class="flex items-center gap-2.5 mb-6">
                            <div class="w-8 h-8 rounded-xl bg-gray-50 flex items-center justify-center text-gray-500">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z" />
                                </svg>
                            </div>
                            <h3 class="text-sm font-bold text-gray-800 font-tegas">Kategori Gangguan Teratas</h3>
                        </div>

                        <div class="space-y-5">
                            @forelse ($kategoriGroups as $nama => $jumlah)
                                <div>
                                    <div class="flex items-center justify-between mb-1.5">
                                        <span class="text-xs font-semibold text-gray-700">{{ $nama }}</span>
                                        <span class="text-xs font-bold text-gray-400">{{ $jumlah }} tiket</span>
                                    </div>
                                    <div class="w-full h-2.5 bg-gray-100 rounded-full overflow-hidden">
                                        <div class="h-full bg-red-500 rounded-full" style="width: {{ ($jumlah / $maxKategori) * 100 }}%"></div>
                                    </div>
                                </div>
                            @empty
                                <p class="text-xs text-gray-400 font-medium uppercase tracking-wider text-center py-6">
                                    Belum ada data kategori gangguan.
                                </p>
                            @endforelse
                        </div>
                    </div>
                </div>

                {{-- ================= TABEL BERKAS TIKET ================= --}}
                <div class="bg-white rounded-[2rem] shadow-2xl shadow-gray-200/20 border border-gray-100 overflow-hidden relative z-10">

                    <div class="px-8 py-6 border-b border-gray-50 flex flex-col lg:flex-row lg:items-center justify-between gap-4 bg-gray-50/20">
                        <h3 class="text-sm font-bold uppercase tracking-wider text-gray-800 font-tegas whitespace-nowrap">
                            Daftar Berkas Tiket Gangguan
                        </h3>

                        <form method="GET" action="{{ route('pimpinan.dashboard') }}" class="flex flex-col sm:flex-row gap-2 w-full lg:w-auto">

                            <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari pelanggan..."
                                class="w-full sm:w-48 text-xs border-gray-200 rounded-xl px-4 py-2 focus:ring-gray-900 focus:border-gray-900 shadow-sm">

                            <select name="kategori" class="w-full sm:w-48 text-xs border-gray-200 rounded-xl px-4 py-2 focus:ring-gray-900 focus:border-gray-900 shadow-sm">
                                <option value="">Semua Kategori</option>
                                @foreach($kategoris as $kat)
                                    <option value="{{ $kat->id }}" {{ request('kategori') == $kat->id ? 'selected' : '' }}>
                                        {{ $kat->nama_kategori }}
                                    </option>
                                @endforeach
                            </select>

                            <div class="flex gap-2">
                                <button type="submit" class="bg-gray-900 text-white px-5 py-2 rounded-xl text-xs font-bold hover:bg-red-600 transition shadow-md">
                                    Cari
                                </button>
                                @if(request('search') || request('kategori'))
                                    <a href="{{ route('pimpinan.dashboard') }}" class="bg-white border border-gray-200 text-gray-600 px-5 py-2 rounded-xl text-xs font-bold hover:bg-gray-50 transition shadow-sm flex items-center justify-center">
                                        Reset
                                    </a>
                                @endif
                            </div>
                        </form>
                    </div>

                    <div class="overflow-x-auto">
                        <table class="w-full text-left">
                            <thead>
                                <tr class="text-[10px] text-gray-400 uppercase tracking-[0.15em] bg-gray-50/50 border-b border-gray-50">
                                    <th class="px-8 py-4 font-bold">Pelanggan</th>
                                    <th class="px-8 py-4 font-bold">Kategori Gangguan</th>
                                    <th class="px-8 py-4 font-bold">Tanggal Laporan</th>
                                    <th class="px-8 py-4 font-bold text-center">Status</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-50">
                                @forelse ($tikets as $tiket)
                                    <tr class="group hover:bg-gray-50/40 transition-all duration-200">
                                        <td class="px-8 py-4">
                                            <p class="text-sm font-bold text-gray-900 uppercase tracking-wide font-tegas">
                                                {{ $tiket->pelanggan->name ?? 'Anonim' }}
                                            </p>
                                            <p class="text-[10px] text-gray-500 font-mono mt-0.5">
                                                {{ $tiket->pelanggan->email ?? '-' }}
                                            </p>
                                        </td>

                                        <td class="px-8 py-4">
                                            <p class="text-xs font-semibold text-gray-700">
                                                {{ $tiket->kategori->nama_kategori ?? 'Gangguan Jaringan' }}
                                            </p>
                                        </td>

                                        <td class="px-8 py-4 text-xs font-mono text-gray-500 font-medium">
                                            {{ $tiket->created_at->format('d M Y, H:i') }}
                                        </td>

                                        <td class="px-8 py-4 text-center">
                                            @php
                                                $normalizedStatus = ucwords(strtolower(trim($tiket->status)));
                                            @endphp
                                            
                                            <span class="px-3 py-1 rounded-full text-[9px] font-bold uppercase tracking-wider ring-1 inline-block
                                                @if (in_array($normalizedStatus, ['Open', 'Pending', 'Menunggu', 'Menunggu Verifikasi'])) bg-red-50 text-red-600 ring-red-100
                                                @elseif(in_array($normalizedStatus, ['In Progress', 'Proses', 'Diproses', 'Dalam Proses'])) bg-gray-100 text-gray-600 ring-gray-200
                                                @elseif(in_array($normalizedStatus, ['Resolved', 'Selesai', 'Selesai Diperbaiki'])) bg-emerald-50 text-emerald-600 ring-emerald-100
                                                @else bg-gray-50 text-gray-600 ring-gray-100 @endif">
                                                {{ $tiket->status }}
                                            </span>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4" class="px-8 py-10 text-center text-gray-400 text-xs font-medium uppercase tracking-wider">
                                            Belum ada berkas tiket yang ditemukan.
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    @if(method_exists($tikets, 'links'))
                        <div class="px-8 py-5 border-t border-gray-50">
                            {{ $tikets->links() }}
                        </div>
                    @endif
                </div>

            </div>
        </div>
    </div>
</x-app-layout>