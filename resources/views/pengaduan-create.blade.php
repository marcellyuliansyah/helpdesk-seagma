<x-app-layout>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600&family=Poppins:wght@500;600;700&display=swap');

        .font-tegas {
            font-family: 'Poppins', sans-serif;
        }

        body {
            font-family: 'Inter', sans-serif;
            background-color: #fafafa;
        }

        .bg-grid-pattern {
            background-image: linear-gradient(to right, #e2e8f0 1px, transparent 1px), linear-gradient(to bottom, #e2e8f0 1px, transparent 1px);
            background-size: 3rem 3rem;
        }
    </style>

    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />

    <div class="relative min-h-screen pb-16">
        <div class="fixed inset-0 z-0 bg-grid-pattern opacity-40"></div>
        <div class="fixed top-[-10%] right-[-10%] w-[600px] h-[600px] bg-red-100/40 rounded-full blur-[130px] z-0 pointer-events-none"></div>

        <div class="relative z-10 max-w-5xl mx-auto pt-12 px-4 sm:px-6">
            
            <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-6">
                <div class="flex items-center gap-4 border-b sm:border-0 pb-4 sm:pb-0 border-gray-200">
                    <div class="w-14 h-14 bg-red-600 rounded-2xl flex items-center justify-center text-white shadow-lg shadow-red-500/30 shrink-0">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                        </svg>
                    </div>
                    <div>
                        <h2 class="text-2xl font-bold tracking-tight text-gray-900 font-tegas">
                            Buat Pengaduan
                        </h2>
                        <p class="text-sm text-gray-500 mt-1 font-light tracking-wide">
                            Layanan dukungan teknis infrastruktur PT Seagma.
                        </p>
                    </div>
                </div>

                <div class="flex items-center gap-3">
                    <div class="hidden md:flex items-center gap-2 px-4 py-2.5 bg-red-50 text-red-600 rounded-full border border-red-100 text-xs font-semibold">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                        </svg>
                        {{ \Carbon\Carbon::now()->translatedFormat('l, d F Y') }}
                    </div>
                    <a href="{{ url('/pelanggan/dashboard') }}" class="px-6 py-2.5 bg-gray-900 text-white rounded-full text-xs font-bold uppercase tracking-widest hover:bg-gray-800 transition-all duration-300 shadow-md shadow-gray-900/10 flex items-center gap-2">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                        </svg>
                        KEMBALI
                    </a>
                </div>
            </div>

            <div class="mt-8 bg-white border border-gray-100 rounded-[2rem] p-6 sm:p-10 shadow-sm relative overflow-hidden">
                
                @if ($errors->any())
                    <div class="mb-8 bg-red-50/60 backdrop-blur-sm border border-red-100 rounded-2xl p-5 flex items-start gap-4">
                        <div class="text-red-500 mt-0.5 shrink-0">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                            </svg>
                        </div>
                        <div>
                            <h4 class="text-sm font-bold text-gray-900 font-tegas">Verifikasi Formulir Gagal</h4>
                            <ul class="mt-1 list-disc list-inside text-xs text-gray-500 space-y-1 font-light">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                @endif

                <form action="{{ route('pengaduan.store') }}" method="POST" class="space-y-10">
                    @csrf

                    <div class="grid grid-cols-1 sm:grid-cols-3 gap-6">
                        <div>
                            <h3 class="text-xs font-bold uppercase tracking-widest text-gray-900 font-tegas">
                                01. Pelapor
                            </h3>
                        </div>
                        <div class="sm:col-span-2">
                            <div class="text-lg font-semibold text-gray-900 font-tegas tracking-wide uppercase">
                                {{ Auth::user()->name }}
                            </div>
                            <div class="text-sm text-gray-500 font-light mt-1">
                                {{ Auth::user()->email }}
                            </div>

                            <div class="mt-5 p-5 bg-gray-50/80 rounded-2xl border border-gray-100">
                                <p class="text-xs font-bold text-gray-500 uppercase mb-2 tracking-wider">
                                    Lokasi Pelanggan
                                </p>
                                <p class="text-sm text-gray-800 font-medium">
                                    {{ Auth::user()->alamat_lengkap ?? 'Alamat belum diatur Admin' }}
                                </p>
                                <div class="flex gap-6 mt-3">
                                    <p class="text-[11px] text-gray-500 font-mono">
                                        LAT: <span class="font-semibold text-gray-700">{{ Auth::user()->latitude }}</span>
                                    </p>
                                    <p class="text-[11px] text-gray-500 font-mono">
                                        LNG: <span class="font-semibold text-gray-700">{{ Auth::user()->longitude }}</span>
                                    </p>
                                </div>
                            </div>
                            <input type="hidden" name="latitude" value="{{ Auth::user()->latitude }}">
                            <input type="hidden" name="longitude" value="{{ Auth::user()->longitude }}">
                        </div>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-3 gap-6 pt-8 border-t border-gray-100">
                        <div>
                            <h3 class="text-xs font-bold uppercase tracking-widest text-gray-900 font-tegas">
                                02. Peta Lokasi
                            </h3>
                        </div>
                        <div class="sm:col-span-2">
                            <div class="rounded-2xl overflow-hidden border border-gray-200 shadow-inner z-0">
                                <div id="map" class="w-full" style="height:350px;"></div>
                            </div>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-3 gap-6 pt-8 border-t border-gray-100">
                        <div>
                            <h3 class="text-xs font-bold uppercase tracking-widest text-gray-900 font-tegas">
                                03. Detail Masalah
                            </h3>
                            <p class="text-[11px] text-gray-500 font-light mt-2 pr-4 leading-relaxed">
                                Berikan informasi singkat dan deskripsi mendalam mengenai kendala jaringan yang terjadi.
                            </p>
                        </div>
                        <div class="sm:col-span-2 space-y-6">
                            <div>
                                <label for="judul" class="block text-[10px] font-bold text-gray-500 uppercase tracking-widest mb-2">Judul Keluhan Singkat</label>
                                <input type="text" id="judul" name="judul" required
                                    placeholder="Misal: Koneksi Lambat / Lampu Indikator Merah"
                                    class="block w-full rounded-xl border-gray-200 py-3.5 px-4 text-gray-900 shadow-sm focus:border-gray-900 focus:ring-gray-900 bg-gray-50/50 sm:text-sm transition-all outline-none">
                            </div>

                            <div>
                                <label class="block text-[10px] font-bold text-gray-500 uppercase tracking-widest mb-2">Kategori Gangguan</label>
                                <select name="kategori_id" required
                                    class="block w-full rounded-xl border-gray-200 py-3.5 px-4 text-gray-900 shadow-sm focus:border-gray-900 focus:ring-gray-900 bg-gray-50/50 sm:text-sm transition-all outline-none appearance-none">
                                    <option value="" disabled selected class="text-gray-300">Pilih rumpun masalah...</option>
                                    @foreach ($semuaKategori as $kat)
                                        <option value="{{ $kat->id }}">{{ $kat->nama_kategori }}</option>
                                    @endforeach
                                </select>
                                @error('kategori_id')
                                    <p class="text-red-500 text-xs mt-1.5 font-medium">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="deskripsi" class="block text-[10px] font-bold text-gray-500 uppercase tracking-widest mb-2">Deskripsi Lengkap Kronologi</label>
                                <textarea id="deskripsi" name="deskripsi" rows="5" required
                                    placeholder="Tuliskan detail kendala secara kronologis di sini..."
                                    class="block w-full rounded-xl border-gray-200 py-3.5 px-4 text-gray-900 shadow-sm focus:border-gray-900 focus:ring-gray-900 bg-gray-50/50 sm:text-sm transition-all outline-none resize-none"></textarea>
                            </div>
                        </div>
                    </div>

                    <div class="pt-8 flex justify-end">
                        <button type="submit"
                            class="w-full sm:w-auto px-10 py-4 bg-red-600 hover:bg-red-700 text-white text-xs font-bold uppercase tracking-[0.15em] rounded-full shadow-lg shadow-red-500/30 transition-all duration-300 transform hover:-translate-y-0.5 flex items-center justify-center gap-2">
                            Kirim Tiket Gangguan
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3" />
                            </svg>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            let lat = {{ Auth::user()->latitude ?? -8.174512 }};
            let lng = {{ Auth::user()->longitude ?? 113.703221 }};

            let map = L.map('map').setView([lat, lng], 16); // Sedikit lebih zoom agar lebih pas dalam form

            L.tileLayer(
                'https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                    attribution: '&copy; OpenStreetMap'
                }
            ).addTo(map);

            L.marker([lat, lng])
                .addTo(map)
                .bindPopup('Lokasi Pelanggan')
                .openPopup();
        });
    </script>
</x-app-layout>