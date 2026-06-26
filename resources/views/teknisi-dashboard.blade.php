<x-app-layout>
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
    <link rel="stylesheet" href="https://unpkg.com/leaflet-routing-machine@3.2.12/dist/leaflet-routing-machine.css" />

    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600&family=Poppins:wght@500;600;700&display=swap');
        
        .font-tegas { font-family: 'Poppins', sans-serif; }
        body { font-family: 'Inter', sans-serif; }

        .bg-grid-pattern {
            background-image: linear-gradient(to right, #f1f5f9 1px, transparent 1px), linear-gradient(to bottom, #f1f5f9 1px, transparent 1px);
            background-size: 3rem 3rem;
        }
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

    <div class="relative min-h-screen bg-gray-50/50 pb-16">
        <div class="fixed inset-0 z-0 bg-grid-pattern opacity-60"></div>
        <div class="fixed top-0 right-0 w-[500px] h-[500px] bg-red-100/20 rounded-full blur-[120px] z-0 pointer-events-none"></div>

        <div class="relative z-10">
            <div class="bg-white/60 backdrop-blur-md border-b border-gray-100">
                <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                    <span class="text-[9px] font-bold text-red-600 uppercase tracking-[0.2em] block mb-1 font-tegas">Workspace</span>
                    <h2 class="text-xl font-bold text-gray-900 font-tegas leading-none">
                        Ruang Kerja Teknisi
                    </h2>
                </div>
            </div>

            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mt-8 space-y-8">
                
                @if(session('success'))
                <div class="bg-green-50 border border-green-100 rounded-2xl p-4 flex items-center gap-3 animate-fade-in-down">
                    <div class="bg-green-500 p-1.5 rounded-xl text-white shrink-0">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                    </div>
                    <p class="text-xs font-semibold text-green-900">{{ session('success') }}</p>
                </div>
                @endif

                @if(session('error'))
                <div class="bg-red-50 border border-red-100 rounded-2xl p-4 flex items-center gap-3 animate-fade-in-down">
                    <div class="bg-red-500 p-1.5 rounded-xl text-white shrink-0">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>
                    </div>
                    <p class="text-xs font-semibold text-red-900">{{ session('error') }}</p>
                </div>
                @endif

                <div class="bg-white rounded-[2rem] shadow-xl shadow-gray-200/40 border border-gray-100 overflow-hidden relative">
                    <div class="absolute top-0 left-0 w-full h-1 bg-gradient-to-r from-blue-400 to-indigo-500"></div>
                    <div class="px-6 py-5 border-b border-gray-50 flex items-center bg-gray-50/10">
                        <span class="w-2 h-2 rounded-full bg-blue-500 inline-block mr-2 animate-pulse"></span>
                        <h3 class="text-xs font-bold uppercase tracking-wider text-black font-tegas">Tugas Saya Saat Ini</h3>
                    </div>
                    
                    <div class="divide-y divide-gray-100">
                        @forelse($tiketSaya as $tiket)
                        <div class="p-6">
                            <div class="grid grid-cols-1 lg:grid-cols-12 gap-6 items-stretch">
                                
                                <div class="lg:col-span-5 flex flex-col justify-between space-y-4">
                                    <div>
                                        <span class="text-[9px] font-bold text-black uppercase tracking-wider block mb-1">Pelanggan</span>
                                        <h4 class="text-base font-bold text-gray-900 uppercase tracking-wide font-tegas">
                                            {{ $tiket->pelanggan->name ?? 'User Tidak Ditemukan' }}
                                        </h4>
                                        <span class="inline-block text-[10px] text-gray-500 font-mono bg-gray-100 px-2.5 py-1 rounded-md mt-1 border border-gray-200/60">
                                            #{{ $tiket->nomor_tiket }}
                                        </span>
                                    </div>

                                    <div class="bg-gray-50 p-4 rounded-xl border border-gray-100 flex-1 flex flex-col justify-start">
                                        <span class="text-[9px] font-bold text-blue-500 uppercase tracking-wider block mb-1">Detail Keluhan</span>
                                        <p class="text-xs font-semibold text-gray-800 mb-1">{{ $tiket->judul }}</p>
                                        <p class="text-[11px] text-gray-500 font-light leading-relaxed">{{ $tiket->deskripsi }}</p>
                                    </div>

                                    <form action="{{ route('teknisi.pengaduan.selesai', $tiket->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin sudah selesai memperbaiki gangguan ini?');" class="pt-2">
                                        @csrf @method('PATCH')
                                        <button type="submit" class="w-full flex justify-center items-center py-3 bg-blue-600 hover:bg-blue-700 text-white text-xs font-bold uppercase tracking-widest rounded-xl shadow-md shadow-blue-200 transition-all duration-200">
                                            <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg>
                                            Selesaikan Tugas Lapangan
                                        </button>
                                    </form>
                                </div>

                                <div class="lg:col-span-7 flex flex-col">
                                    <span class="text-[9px] font-bold text-black uppercase tracking-wider block mb-2">Peta Navigasi & Rute Jalan Otomatis</span>
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
                        <div class="px-6 py-12 text-center text-xs text-black font-light">Anda belum mengambil tugas apapun saat ini.</div>
                        @endforelse
                    </div>
                </div>

                <div class="bg-white rounded-[2rem] shadow-xl shadow-gray-200/40 border border-gray-100 overflow-hidden">
                    <div class="px-6 py-5 border-b border-gray-50 bg-gray-50/20">
                        <h3 class="text-xs font-bold uppercase tracking-wider text-black font-tegas">Antrean Tiket Tersedia</h3>
                    </div>
                    
                    <div class="hidden md:block overflow-x-auto">
                        <table class="w-full text-left">
                            <thead>
                                <tr class="text-[10px] text-black uppercase tracking-[0.15em] bg-gray-50/50 border-b border-gray-50">
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
                                            <button type="submit" class="inline-flex items-center px-4 py-2 bg-green-50 hover:bg-green-600 border border-green-100 text-green-600 hover:text-white text-[10px] font-bold uppercase tracking-wider rounded-xl transition-all duration-300">
                                                Ambil Tugas
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="4" class="px-6 py-12 text-center text-xs text-black font-light">Hebat! Semua tiket gangguan sudah bersih ditangani.</td>
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
                                <button type="submit" class="w-full flex justify-center py-3 bg-gray-950 text-white text-xs font-bold uppercase tracking-widest rounded-xl shadow-md">
                                    Ambil Alih Tugas Ini
                                </button>
                            </form>
                        </div>
                        @empty
                        <div class="p-8 text-center text-xs text-gray-400 font-light">Hebat! Semua tiket gangguan sudah bersih ditangani.</div>
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

                            // 4. Gambar Garis Rute Otomatis (Lokasi Teknisi -> Lokasi Pelanggan)
                            L.Routing.control({
                                waypoints: [
                                    L.latLng(userLat, userLng),   // Titik Mulai (HP Teknisi)
                                    L.latLng(targetLat, targetLng) // Titik Tujuan (Rumah Pelanggan)
                                ],
                                lineOptions: {
                                    styles: [{ color: '#2563eb', weight: 6, opacity: 0.85 }] // Warna garis biru tebal kemudi
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