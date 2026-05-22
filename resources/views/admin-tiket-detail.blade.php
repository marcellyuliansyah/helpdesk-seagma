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

    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />

    <div class="relative min-h-screen bg-gray-50/50 pb-16">
        <div class="fixed inset-0 z-0 bg-grid-pattern opacity-60"></div>
        <div class="fixed top-0 right-0 w-[600px] h-[600px] bg-red-50/30 rounded-full blur-[130px] z-0 pointer-events-none"></div>

        <div class="relative z-10">
            <div class="bg-white/60 backdrop-blur-md border-b border-gray-100">
                <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8 flex items-center justify-between">
                    <div>
                        <span class="text-[10px] font-bold text-gray-400 font-mono tracking-widest block mb-0.5">TIKET #{{ $tiket->nomor_tiket }}</span>
                        <h2 class="text-xl font-bold text-gray-900 font-tegas leading-none">
                            Detail Berkas Pengaduan
                        </h2>
                    </div>
                    <a href="{{ route('admin.dashboard') }}" class="inline-flex items-center gap-1.5 text-xs font-bold tracking-wide text-gray-500 hover:text-gray-900 transition-colors duration-200 bg-white px-4 py-2 rounded-xl border border-gray-100 shadow-sm">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
                        KEMBALI
                    </a>
                </div>
            </div>

            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mt-10">
                
                @if(session('success'))
                <div class="mb-8 bg-green-50 border border-green-100 rounded-2xl p-4 flex items-center gap-4 animate-fade-in-down">
                    <div class="bg-green-500 p-2 rounded-xl text-white">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                    </div>
                    <div>
                        <h4 class="text-sm font-bold text-green-900">Pembaruan Disimpan</h4>
                        <p class="text-xs text-green-700 font-light">{{ session('success') }}</p>
                    </div>
                </div>
                @endif

                <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                    
                    <div class="lg:col-span-2 space-y-6">
                        
                        <div class="bg-white rounded-[2rem] p-6 sm:p-8 shadow-xl shadow-gray-200/30 border border-gray-100/50">
                            <div class="flex flex-col sm:flex-row justify-between items-start gap-4 border-b border-gray-50 pb-5 mb-6">
                                <div>
                                    <p class="text-[9px] font-bold text-red-600 uppercase tracking-widest mb-1.5 bg-red-50 px-2.5 py-0.5 rounded-full inline-block font-tegas">Subjek Laporan</p>
                                    <h3 class="text-xl font-bold text-gray-900 font-tegas tracking-wide">{{ $tiket->judul }}</h3>
                                </div>
                                <span class="px-3 py-1 rounded-full text-[10px] font-bold uppercase tracking-wider ring-1 shrink-0
                                    {{ $tiket->status == 'selesai' ? 'bg-green-50 text-green-700 ring-green-100' : ($tiket->status == 'diproses' ? 'bg-blue-50 text-blue-700 ring-blue-100' : 'bg-yellow-50 text-yellow-700 ring-yellow-100') }}">
                                    {{ $tiket->status == 'menunggu verifikasi' ? 'menunggu' : $tiket->status }}
                                </span>
                            </div>

                            <div class="space-y-6">
                                <div>
                                    <p class="text-[10px] font-bold text-gray-400 uppercase tracking-widest mb-2">Deskripsi Kronologi Gangguan</p>
                                    <p class="text-gray-600 text-sm leading-relaxed font-light bg-gray-50/50 p-4 rounded-2xl border border-gray-50">{{ $tiket->deskripsi }}</p>
                                </div>
                                
                                <div class="grid grid-cols-1 sm:grid-cols-3 gap-6 pt-5 border-t border-gray-50">
                                    <div>
                                        <p class="text-[10px] font-bold text-gray-400 uppercase tracking-widest mb-1">Dilaporkan Pada</p>
                                        <p class="text-xs font-semibold text-gray-800">{{ $tiket->created_at->format('d M Y - H:i') }} WIB</p>
                                    </div>
                                    <div>
                                        <p class="text-[10px] font-bold text-gray-400 uppercase tracking-widest mb-1">ID Pengguna</p>
                                        <p class="text-xs font-mono text-gray-800 font-medium">#{{ $tiket->user->id ?? '-' }}</p>
                                    </div>
                                    <div>
                                        <p class="text-[10px] font-bold text-gray-400 uppercase tracking-widest mb-1">Teknisi Lapangan</p>
                                        <p class="text-xs font-bold {{ $tiket->teknisi_id ? 'text-blue-600' : 'text-red-500' }}">
                                            {{ $tiket->teknisi->name ?? 'Belum Ditugaskan' }}
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="bg-white rounded-[2rem] p-6 sm:p-8 shadow-xl shadow-gray-200/30 border border-gray-100/50">
                            <h4 class="text-xs font-bold text-gray-800 uppercase tracking-widest border-b border-gray-50 pb-4 mb-5 font-tegas">Informasi Pelanggan</h4>
                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                                <div class="flex items-center gap-4">
                                    <div class="w-10 h-10 rounded-xl bg-gray-50 flex items-center justify-center text-gray-400 shrink-0 border border-gray-100">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                                    </div>
                                    <div>
                                        <p class="text-[10px] font-bold text-gray-400 uppercase mb-0.5">Nama Lengkap</p>
                                        <p class="text-sm font-bold text-gray-900 uppercase tracking-wide font-tegas">{{ $tiket->user->name }}</p>
                                    </div>
                                </div>
                                <div class="flex items-center gap-4">
                                    <div class="w-10 h-10 rounded-xl bg-gray-50 flex items-center justify-center text-gray-400 shrink-0 border border-gray-100">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                                    </div>
                                    <div>
                                        <p class="text-[10px] font-bold text-gray-400 uppercase mb-0.5">Alamat Email</p>
                                        <p class="text-sm font-medium text-gray-600 font-mono">{{ $tiket->user->email }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="space-y-6">
                        
                        <div class="bg-white p-4 shadow-xl shadow-gray-200/30 border border-gray-100/50 rounded-[2rem] overflow-hidden">
                            <p class="text-[10px] font-bold text-gray-400 uppercase tracking-widest mb-3 ml-2">Geolokasi Perangkat WiFi</p>
                            
                            <div class="relative rounded-2xl overflow-hidden shadow-inner bg-gray-100 z-0 border border-gray-100">
                                <div id="map" class="h-60 w-full"></div>
                            </div>
                            
                            <div class="mt-3 text-center flex items-center justify-center gap-1 text-[10px] font-mono text-gray-400 bg-gray-50 py-1.5 rounded-xl border border-gray-100">
                                <span>COORD:</span>
                                <span class="font-bold text-gray-600">{{ $tiket->latitude }}, {{ $tiket->longitude }}</span>
                            </div>
                        </div>

                        <div class="bg-white p-6 sm:p-8 shadow-xl shadow-gray-200/30 border border-gray-100/50 rounded-[2rem]">
                            <h4 class="text-xs font-bold text-gray-800 uppercase tracking-wide mb-4 font-tegas">Pembaruan Status Laporan</h4>
                            
                            <form action="{{ route('admin.pengaduan.updateStatus', $tiket->id) }}" method="POST" class="space-y-4">
                                @csrf
                                @method('PATCH')
                                
                                <div>
                                    <label class="block text-[10px] font-bold text-gray-400 uppercase tracking-widest mb-2">Tentukan Status Baru</label>
                                    <select name="status" class="block w-full rounded-xl border-0 py-3.5 px-4 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-100 focus:ring-1 focus:ring-inset focus:ring-gray-900 bg-gray-50/40 sm:text-sm transition-all duration-300 outline-none appearance-none">
                                        <option value="menunggu verifikasi" {{ $tiket->status == 'menunggu verifikasi' ? 'selected' : '' }}>Menunggu Verifikasi</option>
                                        <option value="diproses" {{ $tiket->status == 'diproses' ? 'selected' : '' }}>Valid (Siap Diambil Teknisi)</option>
                                        <option value="selesai" {{ $tiket->status == 'selesai' ? 'selected' : '' }}>Selesai / Tutup Tiket</option>
                                    </select>
                                </div>
                                
                                <button type="submit" class="w-full flex justify-center rounded-xl bg-gray-900 px-4 py-3.5 text-xs font-bold tracking-widest text-white shadow-md hover:bg-red-600 hover:shadow-lg transition-all duration-300 transform hover:-translate-y-0.5">
                                    SIMPAN PERUBAHAN
                                </button>
                            </form>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>

    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
    <script>
        var lat = {{ $tiket->latitude ?? -8.1331 }};
        var lng = {{ $tiket->longitude ?? 113.2223 }};

        var map = L.map('map', {zoomControl: false}).setView([lat, lng], 16);
        L.control.zoom({position: 'topright'}).addTo(map);

        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '&copy; OpenStreetMap'
        }).addTo(map);

        var marker = L.marker([lat, lng]).addTo(map)
            .bindPopup("<b class='font-tegas'>Lokasi Gangguan</b><br>{{ $tiket->user->name }}")
            .openPopup();
    </script>
</x-app-layout>