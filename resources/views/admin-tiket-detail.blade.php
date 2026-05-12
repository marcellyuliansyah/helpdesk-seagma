<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-bold text-xl text-gray-800 leading-tight uppercase tracking-wide">
                {{ __('Detail Pengaduan: ') }} {{ $tiket->nomor_tiket }}
            </h2>
            <a href="{{ route('admin.dashboard') }}" class="text-xs bg-gray-200 hover:bg-gray-300 text-gray-700 py-2 px-4 rounded-sm font-bold uppercase transition">
                &larr; Kembali
            </a>
        </div>
    </x-slot>

    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />

    <div class="py-12 bg-gray-50 min-h-screen">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            @if(session('success'))
            <div class="mb-6 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded-sm relative shadow-sm">
                <strong class="font-bold uppercase text-xs">Berhasil!</strong>
                <span class="block sm:inline text-sm">{{ session('success') }}</span>
            </div>
            @endif

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                
                <div class="lg:col-span-2 space-y-6">
                    <div class="bg-white p-8 shadow-sm border border-gray-200 rounded-sm">
                        <div class="flex justify-between items-start border-b border-gray-100 pb-4 mb-6">
                            <div>
                                <p class="text-[10px] font-bold text-blue-600 uppercase tracking-widest mb-1">Subjek Keluhan</p>
                                <h3 class="text-xl font-bold text-gray-800">{{ $tiket->judul }}</h3>
                            </div>
                            <span class="text-[10px] px-3 py-1 rounded-sm font-bold uppercase {{ $tiket->status == 'selesai' ? 'bg-green-100 text-green-700' : 'bg-yellow-100 text-yellow-700' }}">
                                {{ $tiket->status }}
                            </span>
                        </div>

                        <div class="space-y-4">
                            <div>
                                <p class="text-[10px] font-bold text-gray-400 uppercase tracking-widest">Deskripsi Masalah</p>
                                <p class="text-gray-700 leading-relaxed">{{ $tiket->deskripsi }}</p>
                            </div>
                            
                            <div class="grid grid-cols-1 md:grid-cols-3 gap-4 pt-4 border-t border-gray-100 mt-4">
                                <div>
                                    <p class="text-[10px] font-bold text-gray-400 uppercase tracking-widest">Dilaporkan Pada</p>
                                    <p class="text-sm font-medium">{{ $tiket->created_at->format('d F Y - H:i') }}</p>
                                </div>
                                <div>
                                    <p class="text-[10px] font-bold text-gray-400 uppercase tracking-widest">ID Pelanggan</p>
                                    <p class="text-sm font-medium">{{ $tiket->user->id ?? '-' }}</p>
                                </div>
                                <div>
                                    <p class="text-[10px] font-bold text-gray-400 uppercase tracking-widest">Teknisi Bertugas</p>
                                    <p class="text-sm font-bold {{ $tiket->teknisi_id ? 'text-blue-600' : 'text-red-500' }}">
                                        {{ $tiket->teknisi->name ?? 'Belum Diambil' }}
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="bg-white p-8 shadow-sm border border-gray-200 rounded-sm">
                        <h4 class="text-sm font-bold text-gray-800 uppercase tracking-widest border-b border-gray-100 pb-4 mb-4">Informasi Pelanggan</h4>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <p class="text-[10px] font-bold text-gray-400 uppercase mb-1">Nama Lengkap</p>
                                <p class="text-sm font-bold text-gray-800">{{ $tiket->user->name }}</p>
                            </div>
                            <div>
                                <p class="text-[10px] font-bold text-gray-400 uppercase mb-1">Alamat Email</p>
                                <p class="text-sm font-medium text-gray-700">{{ $tiket->user->email }}</p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="space-y-6">
                    <div class="bg-white p-4 shadow-sm border border-gray-200 rounded-sm">
                        <p class="text-[10px] font-bold text-gray-400 uppercase tracking-widest mb-3">Lokasi Perangkat / Gangguan</p>
                        <div id="map" class="h-64 w-full rounded-sm border border-gray-200"></div>
                        <p class="text-[10px] text-gray-500 mt-2 italic text-center">Koordinat: {{ $tiket->latitude }}, {{ $tiket->longitude }}</p>
                    </div>

                    <div class="bg-white p-6 shadow-sm border border-gray-200 rounded-sm">
                        <h4 class="text-sm font-bold text-gray-800 uppercase mb-4">Update Status Laporan</h4>
                        <form action="{{ route('admin.pengaduan.updateStatus', $tiket->id) }}" method="POST">
                            @csrf
                            @method('PATCH')
                            <div class="mb-4">
                                <label class="block text-[10px] font-bold text-gray-500 uppercase mb-2">Pilih Status Baru</label>
                                <select name="status" class="w-full border-gray-300 rounded-sm text-sm focus:ring-blue-500 focus:border-blue-500">
                                    <option value="menunggu verifikasi" {{ $tiket->status == 'menunggu verifikasi' ? 'selected' : '' }}>Menunggu Verifikasi</option>
                                    <option value="diproses" {{ $tiket->status == 'diproses' ? 'selected' : '' }}>Valid (Siap Diambil Teknisi)</option>
                                    <option value="selesai" {{ $tiket->status == 'selesai' ? 'selected' : '' }}>Selesai / Tutup Tiket</option>
                                </select>
                            </div>
                            <button type="submit" class="w-full bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded-sm text-xs uppercase tracking-widest transition">
                                Simpan Perubahan
                            </button>
                        </form>
                    </div>
                </div>

            </div>
        </div>
    </div>

    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
    <script>
        // Inisialisasi Peta berdasarkan koordinat dari Database
        var lat = {{ $tiket->latitude ?? -8.1331 }}; // Default ke Lumajang jika kosong
        var lng = {{ $tiket->longitude ?? 113.2223 }};

        var map = L.map('map').setView([lat, lng], 16);

        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '&copy; OpenStreetMap'
        }).addTo(map);

        // Tambahkan Marker
        var marker = L.marker([lat, lng]).addTo(map)
            .bindPopup("<b>Lokasi Pelanggan</b><br>{{ $tiket->user->name }}")
            .openPopup();
    </script>
</x-app-layout>