<x-app-layout>
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
    <link rel="stylesheet" href="https://unpkg.com/leaflet-routing-machine@3.2.12/dist/leaflet-routing-machine.css" />

    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600&family=Poppins:wght@400;500;600;700;800&display=swap');

        .font-tegas { font-family: 'Poppins', sans-serif; }
        body { font-family: 'Inter', sans-serif; }

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

        /* Memastikan container Leaflet tidak tertutup elemen luar */
        #map { z-index: 1; }
        /* Kustomisasi tampilan instruksi rute Leaflet agar lebih bersih di HP */
        .leaflet-routing-container {
            background-color: rgba(255, 255, 255, 0.95) !important;
            padding: 10px !important;
            border-radius: 12px !important;
            box-shadow: 0 4px 12px rgba(0,0,0,0.1) !important;
            max-height: 150px !important;
            overflow-y: auto !important;
            font-size: 11px !important;
        }
    </style>

    {{-- ================= HEADER BAR ================= --}}
    
    <div class="relative min-h-screen bg-white bg-gradient-to-b from-white via-white to-slate-100/50 pb-16">
        <div class="fixed inset-0 z-0 bg-grid-pattern opacity-50"></div>
        <div class="fixed top-[-5%] right-[-5%] w-[600px] h-[600px] bg-red-50/30 rounded-full blur-[130px] z-0 pointer-events-none"></div>

        <div class="relative z-10">

            {{-- ================= TITLE ================= --}}
            <div class="bg-white/70 backdrop-blur-md border-b border-gray-100">
                <div class="max-w-7xl mx-auto py-8 px-4 sm:px-6 lg:px-8 flex flex-col lg:flex-row lg:items-center lg:justify-between gap-5">

                    <div class="flex items-center gap-4">
                        <div class="w-14 h-14 rounded-2xl bg-red-600 flex items-center justify-center shadow-lg shadow-red-200 shrink-0">
                            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 4a2 2 0 114 0v1a1 1 0 001 1h3a1 1 0 011 1v3a1 1 0 01-1 1h-1a2 2 0 100 4h1a1 1 0 011 1v3a1 1 0 01-1 1h-3a1 1 0 01-1-1v-1a2 2 0 10-4 0v1a1 1 0 01-1 1H7a1 1 0 01-1-1v-3a1 1 0 00-1-1H4a1 1 0 01-1-1V9a1 1 0 011-1h1a1 1 0 001-1V6a1 1 0 011-1h3a1 1 0 001-1V4z" />
                            </svg>
                        </div>
                        <div>
                            <span class="text-[9px] font-bold text-red-600 uppercase tracking-[0.2em] block mb-1 font-tegas">
                                Workspace Lapangan
                            </span>
                            <h2 class="text-2xl font-bold text-gray-950 font-tegas leading-none">
                                Ruang Kerja Teknisi
                            </h2>
                            <p class="text-xs text-gray-500 mt-1.5 font-light">
                                Kelola tugas lapangan dan navigasi rute ke lokasi pelanggan.
                            </p>
                        </div>
                    </div>

                    <span class="inline-flex items-center gap-2 px-4 py-2.5 bg-red-50 text-red-600 text-xs font-bold rounded-full border border-red-100 self-start lg:self-auto">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                        </svg>
                        {{ \Carbon\Carbon::now()->translatedFormat('l, d F Y') }}
                    </span>
                </div>
            </div>

            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mt-10 space-y-8">

                @if(session('success'))
                <div class="bg-green-50/80 border border-green-100 rounded-2xl p-4 flex items-center gap-3">
                    <div class="bg-emerald-500 p-1.5 rounded-xl text-white shrink-0">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                    </div>
                    <p class="text-xs font-semibold text-gray-900">{{ session('success') }}</p>
                </div>
                @endif

                @if(session('error'))
                <div class="bg-red-50/80 border border-red-100 rounded-2xl p-4 flex items-center gap-3">
                    <div class="bg-red-500 p-1.5 rounded-xl text-white shrink-0">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>
                    </div>
                    <p class="text-xs font-semibold text-gray-900">{{ session('error') }}</p>
                </div>
                @endif

                {{-- ================= STAT CARDS ================= --}}
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-6 relative z-20">

                    {{-- TUGAS AKTIF — dark navy card --}}
                    <div class="stat-glow relative overflow-hidden bg-gray-950 rounded-[2rem] p-6 shadow-xl flex items-center justify-between">
                        <div class="absolute -right-6 -bottom-8 w-28 h-28 rounded-full bg-white/5"></div>
                        <div class="relative z-10">
                            <p class="text-[10px] font-bold text-gray-400 uppercase tracking-widest">
                                Tugas Lapangan Aktif
                            </p>
                            <p class="text-4xl font-extrabold text-white font-tegas mt-1">
                                {{ $tiketSaya->count() }}
                            </p>
                            <p class="text-[10px] text-gray-400 mt-2 font-medium">
                                Sedang Anda kerjakan saat ini
                            </p>
                        </div>
                        <div class="relative z-10 w-12 h-12 rounded-2xl bg-white/10 flex items-center justify-center text-white shrink-0">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17V7m0 10a2 2 0 01-2 2H5a2 2 0 01-2-2V7a2 2 0 012-2h2a2 2 0 012 2m0 10a2 2 0 002 2h2a2 2 0 002-2M9 7a2 2 0 012-2h2a2 2 0 012 2m0 10V7m0 10a2 2 0 002 2h2a2 2 0 002-2V7a2 2 0 00-2-2h-2a2 2 0 00-2 2" />
                            </svg>
                        </div>
                    </div>

                    {{-- ANTREAN TERSEDIA — red card --}}
                    <div class="stat-glow relative overflow-hidden bg-red-600 rounded-[2rem] p-6 shadow-xl shadow-red-200/40 flex items-center justify-between">
                        <div class="absolute -right-6 -bottom-8 w-28 h-28 rounded-full bg-white/10"></div>
                        <div class="relative z-10">
                            <p class="text-[10px] font-bold text-white/80 uppercase tracking-widest">
                                Antrean Tiket Tersedia
                            </p>
                            <p class="text-4xl font-extrabold text-white font-tegas mt-1">
                                {{ $tiketTersedia->count() }}
                            </p>
                            <p class="text-[10px] text-white/80 mt-2 font-medium">
                                Menunggu untuk diambil
                            </p>
                        </div>
                        <div class="relative z-10 w-12 h-12 rounded-2xl bg-white/15 flex items-center justify-center text-white shrink-0">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </div>
                    </div>
                </div>

                {{-- ================= TUGAS SAYA SAAT INI ================= --}}
                <div class="bg-white rounded-[2rem] shadow-xl shadow-gray-200/20 border border-gray-100/50 overflow-hidden relative">
                    <div class="absolute top-0 left-0 w-full h-1 bg-gradient-to-r from-red-500 to-gray-900"></div>
                    <div class="px-6 py-5 border-b border-gray-50 flex items-center bg-gray-50/20">
                        <span class="w-2 h-2 rounded-full bg-red-500 inline-block mr-2 animate-pulse"></span>
                        <h3 class="text-xs font-bold uppercase tracking-wider text-gray-800 font-tegas">Tugas Saya Saat Ini</h3>
                    </div>

                    <div class="divide-y divide-gray-100">
                        @forelse($tiketSaya as $tiket)
                        <div class="p-6">
                            <div class="grid grid-cols-1 lg:grid-cols-12 gap-6 items-stretch">

                                <div class="lg:col-span-5 flex flex-col justify-between space-y-4">
                                    <div>
                                        <span class="text-[9px] font-bold text-gray-400 uppercase tracking-wider block mb-1">Pelanggan</span>
                                        <h4 class="text-base font-bold text-gray-900 uppercase tracking-wide font-tegas">
                                            {{ $tiket->pelanggan->name ?? 'User Tidak Ditemukan' }}
                                        </h4>
                                        <span class="inline-block text-[10px] text-gray-500 font-mono bg-gray-100 px-2.5 py-1 rounded-md mt-1 border border-gray-200/60">
                                            #{{ $tiket->nomor_tiket }}
                                        </span>
                                    </div>

                                    <div class="bg-gray-50 p-4 rounded-xl border border-gray-100 flex-1 flex flex-col justify-start">
                                        <span class="text-[9px] font-bold text-red-500 uppercase tracking-wider block mb-1">Detail Keluhan</span>
                                        <p class="text-xs font-semibold text-gray-800 mb-1">{{ $tiket->judul }}</p>
                                        <p class="text-[11px] text-gray-500 font-light leading-relaxed">{{ $tiket->deskripsi }}</p>
                                    </div>

                                    {{-- FORM PENYELESAIAN TUGAS (MENGGUNAKAN KAMERA) --}}
                                    <form action="{{ route('teknisi.pengaduan.selesai', $tiket->id) }}" method="POST" enctype="multipart/form-data" class="pt-2 space-y-3">
                                        @csrf @method('PATCH')
                                        
                                        {{-- AREA UPLOAD FOTO BUKTI --}}
                                        <div class="bg-gray-50 p-4 rounded-xl border border-gray-500 border-dashed">
                                            <label for="foto_bukti_{{ $tiket->id }}" class="block text-[10px] font-bold text-gray-700 uppercase tracking-wider mb-2">
                                                Ambil Foto Bukti Selesai (Kamera HP) <span class="text-red-500">*</span>
                                            </label>
                                            
                                            <input type="file" 
                                                   id="foto_bukti_{{ $tiket->id }}" 
                                                   name="foto_bukti" 
                                                   accept="image/*" 
                                                   capture="environment"
                                                   required
                                                   class="block w-full text-xs text-black file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-xs file:font-semibold file:bg-gray-900 file:text-white hover:file:bg-red-600 transition-all cursor-pointer">
                                                   
                                            <p class="text-[9px] text-black mt-1.5 font-light">
                                                Format: JPG, PNG. Maksimal 5MB. Klik tombol di atas untuk langsung membuka kamera belakang HP Anda.
                                            </p>
                                        </div>

                                        <button type="submit" onclick="return confirm('Apakah Anda yakin sudah mengunggah foto bukti yang benar dan menyelesaikan gangguan ini?');" class="w-full flex justify-center items-center py-3 bg-gray-950 hover:bg-red-600 text-white text-xs font-bold uppercase tracking-widest rounded-xl shadow-lg transition-all duration-300">
                                            <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/>
                                            </svg>
                                            Selesaikan Tugas Lapangan
                                        </button>
                                    </form>

                                </div>

                                <div class="lg:col-span-7 flex flex-col">
                                    <span class="text-[9px] font-bold text-gray-400 uppercase tracking-wider block mb-2">Peta Navigasi & Rute Jalan Otomatis</span>
                                    <div class="relative w-full h-72 lg:h-full min-h-[320px] rounded-2xl overflow-hidden border border-gray-200/80 shadow-inner bg-gray-100">

                                        <div id="map" class="absolute inset-0 w-full h-full"></div>

                                        <div id="gps-error" class="hidden absolute top-3 inset-x-3 z-50 bg-red-500/90 backdrop-blur-sm text-white text-[10px] p-2.5 rounded-xl text-center font-semibold tracking-wide shadow-md">
                                            ⚠️ GPS Gagal terdeteksi. Pastikan izin lokasi browser Anda aktif.
                                        </div>

                                    </div>
                                </div>

                            </div>
                        </div>
                        @empty
                        <div class="px-6 py-12 text-center text-xs text-gray-400 font-light uppercase tracking-wider">Anda belum mengambil tugas apapun saat ini.</div>
                        @endforelse
                    </div>
                </div>

                {{-- ================= ANTREAN TIKET TERSEDIA ================= --}}
                <div class="bg-white rounded-[2rem] shadow-xl shadow-gray-200/20 border border-gray-100/50 overflow-hidden">
                    <div class="px-6 py-5 border-b border-gray-50 bg-gray-50/20">
                        <h3 class="text-xs font-bold uppercase tracking-wider text-gray-800 font-tegas">Antrean Tiket Tersedia</h3>
                    </div>

                    <div class="hidden md:block overflow-x-auto">
                        <table class="w-full text-left">
                            <thead>
                                <tr class="text-[10px] text-gray-400 uppercase tracking-[0.15em] bg-gray-50/50 border-b border-gray-50">
                                    <th class="px-6 py-4 font-bold">Pelanggan</th>
                                    <th class="px-6 py-4 font-bold">Detail Keluhan</th>
                                    <th class="px-6 py-4 font-bold">Waktu Masuk</th>
                                    <th class="px-6 py-4 font-bold text-center w-36">Tindakan</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-50">
                                @forelse($tiketTersedia as $tiket)
                                <tr class="hover:bg-gray-50/40 transition">
                                    <td class="px-6 py-4">
                                        <p class="text-xs font-bold text-gray-900 uppercase tracking-wide">{{ $tiket->user->name ?? 'User Tidak Ditemukan' }}</p>
                                        <p class="text-[10px] text-gray-400 font-mono mt-0.5">#{{ $tiket->nomor_tiket }}</p>
                                    </td>
                                    <td class="px-6 py-4">
                                        <p class="text-xs font-semibold text-gray-800">{{ $tiket->judul }}</p>
                                        <p class="text-[11px] text-gray-400 font-light mt-0.5 max-w-xs truncate">{{ $tiket->deskripsi }}</p>
                                    </td>
                                    <td class="px-6 py-4 text-xs text-gray-500 font-light">
                                        {{ $tiket->created_at->diffForHumans() }}
                                    </td>
                                    <td class="px-6 py-4 text-center">
                                        <form action="{{ route('teknisi.pengaduan.ambil', $tiket->id) }}" method="POST">
                                            @csrf @method('PATCH')
                                            <button type="submit" class="inline-flex items-center px-4 py-2 bg-emerald-50 hover:bg-emerald-600 border border-emerald-100 text-emerald-600 hover:text-white text-[10px] font-bold uppercase tracking-wider rounded-xl transition-all duration-300">
                                                Ambil Tugas
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="4" class="px-6 py-12 text-center text-xs text-gray-400 font-light uppercase tracking-wider">Hebat! Semua tiket gangguan sudah bersih ditangani.</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <div class="block md:hidden divide-y divide-gray-100">
                        @forelse($tiketTersedia as $tiket)
                        <div class="p-5 space-y-3">
                            <div class="flex justify-between items-center">
                                <div>
                                    <h4 class="text-sm font-bold text-gray-900 uppercase tracking-wide font-tegas">{{ $tiket->pelanggan->name ?? 'User Tidak Ditemukan' }}</h4>
                                    <span class="text-[10px] text-gray-400 font-mono">#{{ $tiket->nomor_tiket }}</span>
                                </div>
                                <span class="text-[9px] text-gray-400 font-medium bg-gray-100 px-2 py-0.5 rounded-full">{{ $tiket->created_at->diffForHumans() }}</span>
                            </div>
                            <div class="bg-gray-50 p-3 rounded-xl border border-gray-100/50">
                                <p class="text-xs font-bold text-gray-800">{{ $tiket->judul }}</p>
                                <p class="text-[11px] text-gray-400 font-light mt-1">{{ Str::limit($tiket->deskripsi, 80) }}</p>
                            </div>
                            <form action="{{ route('teknisi.pengaduan.ambil', $tiket->id) }}" method="POST">
                                @csrf @method('PATCH')
                                <button type="submit" class="w-full flex justify-center py-3 bg-gray-950 hover:bg-red-600 text-white text-xs font-bold uppercase tracking-widest rounded-xl shadow-md transition-all duration-300">
                                    Ambil Alih Tugas Ini
                                </button>
                            </form>
                        </div>
                        @empty
                        <div class="p-8 text-center text-xs text-gray-400 font-light uppercase tracking-wider">Hebat! Semua tiket gangguan sudah bersih ditangani.</div>
                        @endforelse
                    </div>
                </div>

            </div>
        </div>
    </div>

    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
    <script src="https://unpkg.com/leaflet-routing-machine@3.2.12/dist/leaflet-routing-machine.js"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            // Memeriksa apakah ada tugas aktif yang diambil teknisi
            @if($tiketSaya->first())
                // Ambil koordinat target pelanggan langsung dari database backend Laravel Anda
                const destLat = parseFloat("{{ $tiketSaya->first()->latitude }}");
                const destLng = parseFloat("{{ $tiketSaya->first()->longitude }}");

                // Fallback default jika database Anda belum terisi data koordinat (Dummy default: Lumajang)
                const targetLat = isNaN(destLat) ? -8.1331 : destLat;
                const targetLng = isNaN(destLng) ? 113.2241 : destLng;

                // 1. Inisialisasi Kanvas Peta Leaflet dasar
                const map = L.map('map').setView([targetLat, targetLng], 14);

                // 2. Load Desain Tile Peta dari OpenStreetMap Gratisan
                L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                    attribution: '&copy; OpenStreetMap contributors'
                }).addTo(map);

                // 3. Ambil Geolokasi GPS Real-Time dari Ponsel Pintar Teknisi
                if (navigator.geolocation) {
                    navigator.geolocation.getCurrentPosition(
                        function (position) {
                            const userLat = position.coords.latitude;
                            const userLng = position.coords.longitude;

                            // 4. Gambar Garis Rute Otomatis (Lokasi Teknisi -> Lokasi Pelanggan), warna merah sesuai tema brand
                            L.Routing.control({
                                waypoints: [
                                    L.latLng(userLat, userLng),   // Titik Mulai (HP Teknisi)
                                    L.latLng(targetLat, targetLng) // Titik Tujuan (Rumah Pelanggan)
                                ],
                                lineOptions: {
                                    styles: [{ color: '#dc2626', weight: 6, opacity: 0.85 }] // Garis merah tebal sesuai aksen brand
                                },
                                createMarker: function(i, wp, nWps) {
                                    // Membuat penanda visual kustom pembeda titik start & finish
                                    if (i === 0) {
                                        return L.marker(wp.latLng).bindPopup("<b>Lokasi Anda Sekarang</b>").openPopup();
                                    } else {
                                        return L.marker(wp.latLng).bindPopup("<b>Rumah Pelanggan (GANGGUAN)</b>");
                                    }
                                },
                                routeWhileDragging: false,
                                addWaypoints: false // Menutup akses manipulasi rute manual oleh user
                            }).addTo(map);
                        },
                        function (error) {
                            // Handler jika izin share-location diblokir teknisi
                            console.warn("Akses GPS ditolak teknisi, menampilkan marker statis tujuan.");
                            document.getElementById('gps-error').classList.remove('hidden');
                            L.marker([targetLat, targetLng]).addTo(map)
                                .bindPopup("<b>Lokasi Pelanggan</b><br>Gagal melacak rute karena GPS Anda mati.").openPopup();
                        },
                        { enableHighAccuracy: true, timeout: 10000 }
                    );
                } else {
                    // Browser jadul yang tidak mendukung Geolokasi API
                    L.marker([targetLat, targetLng]).addTo(map).bindPopup("<b>Lokasi Pelanggan</b>").openPopup();
                }
            @endif
        });
    </script>
</x-app-layout>