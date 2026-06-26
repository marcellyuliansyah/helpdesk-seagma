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

    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />

    <div class="relative min-h-screen bg-white pb-16">
        <div class="fixed inset-0 z-0 bg-grid-pattern opacity-40"></div>
        <div
            class="fixed top-[-10%] right-[-10%] w-[600px] h-[600px] bg-red-50/40 rounded-full blur-[130px] z-0 pointer-events-none">
        </div>

        <div class="relative z-10">
            <div class="max-w-3xl mx-auto pt-12 px-4 sm:px-6 flex items-center justify-between">
                <div>
                    <h2 class="text-2xl font-bold tracking-tight text-gray-950 font-tegas">
                        Buat Pengaduan
                    </h2>
                    <p class="text-xs text-black mt-1 font-light tracking-wide">Layanan dukungan teknis infrastruktur
                        PT Seagma.</p>
                </div>
                <a href="{{ url('/pelanggan/dashboard') }}"
                    class="text-xs font-semibold tracking-widest text-black hover:text-gray-900 transition-colors duration-300 flex items-center gap-1">
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                    </svg>
                    DASHBOARD
                </a>
            </div>

            <div class="max-w-3xl mx-auto px-4 sm:px-6 mt-10">

                @if ($errors->any())
                    <div
                        class="mb-8 bg-red-50/60 backdrop-blur-sm border border-red-100 rounded-2xl p-5 flex items-start gap-4">
                        <div class="text-red-500 mt-0.5 shrink-0">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
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

                    <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 pt-4 border-t border-gray-100">

                        <div>
                            <h3 class="text-xs font-bold uppercase tracking-widest text-black font-tegas">
                                01. Pelapor
                            </h3>
                        </div>

                        <div class="sm:col-span-2">

                            <div class="text-base font-semibold text-gray-900 font-tegas tracking-wide uppercase">
                                {{ Auth::user()->name }}
                            </div>

                            <div class="text-xs text-black font-light mt-0.5">
                                {{ Auth::user()->email }}
                            </div>

                            <div class="mt-4 p-4 bg-gray-50 rounded-xl border">

                                <p class="text-xs font-bold text-gray-600 uppercase mb-2">
                                    Lokasi Pelanggan
                                </p>

                                <p class="text-sm text-gray-800">
                                    {{ Auth::user()->alamat_lengkap ?? 'Alamat belum diatur Admin' }}
                                </p>

                                <p class="text-xs text-gray-500 mt-2">
                                    Latitude :
                                    {{ Auth::user()->latitude }}
                                </p>

                                <p class="text-xs text-gray-500">
                                    Longitude :
                                    {{ Auth::user()->longitude }}
                                </p>

                            </div>

                            <input type="hidden" name="latitude" value="{{ Auth::user()->latitude }}">

                            <input type="hidden" name="longitude" value="{{ Auth::user()->longitude }}">

                        </div>

                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-3 gap-6 pt-8 border-t border-gray-100">

                        <div>
                            <h3 class="text-xs font-bold uppercase tracking-widest text-black font-tegas">
                                02. Lokasi Gangguan
                            </h3>
                        </div>

                        <div class="sm:col-span-2">

                            <div class="rounded-xl overflow-hidden border">
                                <div id="map" style="height:300px;"></div>
                            </div>

                        </div>

                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-3 gap-6 pt-8 border-t border-gray-100">
                        <div>
                            <h3 class="text-xs font-bold uppercase tracking-widest text-black font-tegas">03. Detail
                                Masalah</h3>
                            <p class="text-[11px] text-black font-light mt-2 pr-4 leading-relaxed">Berikan informasi
                                singkat dan deskripsi mendalam mengenai kendala jaringan yang terjadi.</p>
                        </div>

                        <div class="sm:col-span-2 space-y-6">
                            <div>
                                <label for="judul"
                                    class="block text-[10px] font-bold text-black uppercase tracking-widest mb-2">Judul
                                    Keluhan Singkat</label>
                                <input type="text" id="judul" name="judul" required
                                    placeholder="Misal: Koneksi Lambat / Lampu Indikator Merah"
                                    class="block w-full rounded-xl border-0 py-3.5 px-4 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-100 placeholder:text-gray-300 focus:ring-1 focus:ring-inset focus:ring-gray-900 bg-gray-50/30 sm:text-sm transition-all duration-300 outline-none">
                            </div>

                            <div>
                                <label
                                    class="block text-[10px] font-bold text-black uppercase tracking-widest mb-2">Kategori
                                    Gangguan</label>
                                <select name="kategori_id" required
                                    class="block w-full rounded-xl border-0 py-3.5 px-4 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-100 focus:ring-1 focus:ring-inset focus:ring-gray-900 bg-gray-50/30 sm:text-sm transition-all duration-300 outline-none appearance-none">
                                    <option value="" disabled selected class="text-gray-300">Pilih rumpun
                                        masalah...</option>
                                    @foreach ($semuaKategori as $kat)
                                        <option value="{{ $kat->id }}">{{ $kat->nama_kategori }}</option>
                                    @endforeach
                                </select>
                                @error('kategori_id')
                                    <p class="text-red-500 text-xs mt-1.5 font-medium">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="deskripsi"
                                    class="block text-[10px] font-bold text-black uppercase tracking-widest mb-2">Deskripsi
                                    Lengkap Kronologi</label>
                                <textarea id="deskripsi" name="deskripsi" rows="4" required
                                    placeholder="Tuliskan detail kendala secara kronologis di sini..."
                                    class="block w-full rounded-xl border-0 py-3.5 px-4 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-100 placeholder:text-gray-300 focus:ring-1 focus:ring-inset focus:ring-gray-900 bg-gray-50/30 sm:text-sm transition-all duration-300 outline-none resize-none"></textarea>
                            </div>
                        </div>
                    </div>

                    {{-- <div class="grid grid-cols-1 sm:grid-cols-3 gap-6 pt-8 border-t border-gray-100">
                        <div>
                            <h3 class="text-xs font-bold uppercase tracking-widest text-gray-400 font-tegas">03.
                                Geolokasi</h3>
                            <p class="text-[11px] text-gray-400 font-light mt-2 pr-4 leading-relaxed">Geser pin merah
                                tepat di atas posisi hunian Anda untuk rute penugasan tim lapangan.</p>
                        </div>

                        <div class="sm:col-span-2 space-y-4">
                            <div
                                class="relative rounded-[2rem] overflow-hidden shadow-2xl shadow-gray-200/60 bg-gray-50 z-0 border border-gray-100/50">
                                <div id="map" class="h-72 w-full"></div>
                            </div>

                            <div class="flex gap-4">
                                <div
                                    class="w-1/2 flex items-center gap-2 bg-gray-50/50 px-4 py-2.5 rounded-xl border border-gray-100">
                                    <span
                                        class="text-[9px] font-bold text-gray-400 uppercase tracking-wider font-mono">LAT:</span>
                                    <input type="text" id="latitude" name="latitude" readonly required
                                        class="w-full bg-transparent border-0 p-0 text-xs font-mono text-gray-600 outline-none pointer-events-none">
                                </div>
                                <div
                                    class="w-1/2 flex items-center gap-2 bg-gray-50/50 px-4 py-2.5 rounded-xl border border-gray-100">
                                    <span
                                        class="text-[9px] font-bold text-gray-400 uppercase tracking-wider font-mono">LNG:</span>
                                    <input type="text" id="longitude" name="longitude" readonly required
                                        class="w-full bg-transparent border-0 p-0 text-xs font-mono text-gray-600 outline-none pointer-events-none">
                                </div>
                            </div>
                        </div>
                    </div> --}}

                    <div class="pt-8 border-t border-gray-100 flex justify-end">
                        <button type="submit"
                            class="w-full sm:w-auto px-10 py-4 bg-gray-950 hover:bg-red-600 text-white text-xs font-bold uppercase tracking-[0.2em] rounded-full shadow-xl shadow-gray-900/10 hover:shadow-red-500/20 transition-all duration-300 transform hover:-translate-y-1">
                            Kirim Tiket Gangguan
                        </button>
                    </div>
                </form>

            </div>
        </div>
    </div>

    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css">

    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {

            let lat = {{ Auth::user()->latitude ?? -8.174512 }};
            let lng = {{ Auth::user()->longitude ?? 113.703221 }};

            let map = L.map('map').setView([lat, lng], 15);

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
