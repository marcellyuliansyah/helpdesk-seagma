<x-app-layout>
    <x-slot name="header">
        <h2 class="font-bold text-xl text-gray-800 leading-tight uppercase tracking-wide">
            {{ __('Form Pengaduan Gangguan') }}
        </h2>
    </x-slot>

    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />

    <div class="py-12 bg-gray-50 min-h-screen">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-sm border border-gray-200">
                <div class="p-6 border-b border-gray-200 bg-gray-50 flex justify-between items-center">
                    <div>
                        <h3 class="text-lg font-bold uppercase tracking-wide text-gray-800">Tiket Baru</h3>
                        <p class="text-sm text-gray-500 mt-1">Lengkapi data di bawah ini dengan akurat agar teknisi dapat menemukan lokasi Anda.</p>
                    </div>
                    <a href="{{ url('/pelanggan/dashboard') }}" class="text-sm font-bold text-gray-500 hover:text-red-600 uppercase transition tracking-wider">
                        &larr; Kembali
                    </a>
                </div>

                <div class="p-6 md:p-8">
                    @if ($errors->any())
                        <div class="mb-6 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded-sm relative shadow-sm" role="alert">
                            <strong class="font-bold uppercase tracking-wide text-xs">Gagal Mengirim Tiket!</strong>
                            <ul class="mt-2 list-disc list-inside text-sm">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                    <form action="{{ route('pengaduan.store') }}" method="POST">
                        @csrf
                        
                        <div class="mb-6 bg-gray-50 p-4 border border-gray-200 rounded-sm">
                            <label class="block font-bold text-xs text-gray-500 uppercase tracking-wide mb-2">Pelapor (Otomatis)</label>
                            <div class="font-bold text-gray-900 uppercase">{{ Auth::user()->name }}</div>
                            <div class="text-sm text-gray-600">{{ Auth::user()->email }}</div>
                        </div>

                        <div class="mb-6">
                            <label for="judul" class="block font-bold text-xs text-gray-700 uppercase tracking-wide mb-2">Judul / Kategori Gangguan <span class="text-red-600">*</span></label>
                            <input type="text" id="judul" name="judul" class="block w-full border-gray-300 focus:border-red-500 focus:ring-red-500 rounded-sm shadow-sm transition text-sm" placeholder="Contoh: Internet Mati Total" required>
                        </div>

                        <div class="mb-6">
                            <label for="deskripsi" class="block font-bold text-xs text-gray-700 uppercase tracking-wide mb-2">Deskripsi Gangguan Wi-Fi <span class="text-red-600">*</span></label>
                            <textarea id="deskripsi" name="deskripsi" rows="4" class="block w-full border-gray-300 focus:border-red-500 focus:ring-red-500 rounded-sm shadow-sm transition text-sm" placeholder="Contoh: Lampu LOS pada modem berwarna merah dan internet tidak bisa diakses sejak pagi..." required></textarea>
                        </div>

                        <div class="mb-6">
                            <label class="block font-bold text-xs text-gray-700 uppercase tracking-wide mb-2">Tandai Titik Lokasi Rumah / Perangkat <span class="text-red-600">*</span></label>
                            <p class="text-xs text-gray-500 mb-3">Geser pin merah pada peta di bawah ini ke lokasi persis rumah Anda.</p>
                            
                            <div id="map" class="h-80 w-full rounded-sm border border-gray-300 shadow-sm mb-3 z-0"></div>

                            <div class="flex gap-4">
                                <div class="w-1/2">
                                    <label class="block font-bold text-[10px] text-gray-500 uppercase tracking-wide mb-1">Latitude</label>
                                    <input type="text" id="latitude" name="latitude" class="block w-full border-gray-300 bg-gray-50 rounded-sm shadow-sm text-sm" readonly required>
                                </div>
                                <div class="w-1/2">
                                    <label class="block font-bold text-[10px] text-gray-500 uppercase tracking-wide mb-1">Longitude</label>
                                    <input type="text" id="longitude" name="longitude" class="block w-full border-gray-300 bg-gray-50 rounded-sm shadow-sm text-sm" readonly required>
                                </div>
                            </div>
                        </div>

                        <hr class="border-gray-200 my-8">

                        <div class="flex justify-end">
                            <button type="submit" class="inline-flex items-center px-8 py-3 bg-red-600 border border-transparent rounded-sm font-bold text-xs text-white uppercase tracking-widest hover:bg-red-700 focus:bg-red-700 active:bg-red-800 transition shadow-sm">
                                Kirim Laporan Gangguan
                            </button>
                        </div>
                    </form>
                </div>
            </div>

        </div>
    </div>

    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Titik awal peta (Default: Alun-Alun Lumajang, Jawa Timur)
            var initialLat = -8.1332; 
            var initialLng = 113.2226;

            // Inisialisasi Peta
            var map = L.map('map').setView([initialLat, initialLng], 13);

            // Tampilan Peta dari OpenStreetMap
            L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                attribution: '&copy; OpenStreetMap contributors'
            }).addTo(map);

            // Buat Pin (Marker) yang bisa digeser (draggable)
            var marker = L.marker([initialLat, initialLng], {draggable: true}).addTo(map);

            // Masukkan koordinat awal ke dalam input text
            document.getElementById('latitude').value = initialLat;
            document.getElementById('longitude').value = initialLng;

            // Jika pin digeser, update angka koordinatnya
            marker.on('dragend', function (e) {
                var latLng = marker.getLatLng();
                document.getElementById('latitude').value = latLng.lat;
                document.getElementById('longitude').value = latLng.lng;
            });

            // Jika peta diklik, pindahkan pin ke titik tersebut
            map.on('click', function(e) {
                marker.setLatLng(e.latlng);
                document.getElementById('latitude').value = e.latlng.lat;
                document.getElementById('longitude').value = e.latlng.lng;
            });
        });
    </script>
</x-app-layout>