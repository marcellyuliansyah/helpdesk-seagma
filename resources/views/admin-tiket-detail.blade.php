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

    <div class="relative min-h-screen bg-[#f8fafc] pb-16">
        <div class="fixed inset-0 z-0 bg-grid-pattern pointer-events-none"></div>
        <div class="fixed top-0 right-0 w-[600px] h-[600px] bg-red-400/5 rounded-full blur-[120px] z-0 pointer-events-none"></div>

        <div class="relative z-10 pt-8">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                
                <div class="mb-8">
                    <a href="{{ route('admin.dashboard') }}" class="inline-flex items-center gap-2 px-5 py-2.5 bg-white border border-slate-200 rounded-full text-sm font-medium text-slate-600 hover:text-slate-900 hover:bg-slate-50 hover:shadow-md transition-all duration-300">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                        </svg>
                        Kembali ke Dasbor
                    </a>
                </div>

                <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 mb-10">
                    <div class="flex items-center gap-4">
                        <div class="w-14 h-14 bg-[#dc2626] rounded-2xl flex items-center justify-center text-white shadow-[0_8px_20px_-6px_rgba(220,38,38,0.4.5)] shrink-0">
                            <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                            </svg>
                        </div>
                        <div>
                            <h2 class="text-2xl font-bold text-[#111c2a] font-tegas leading-none tracking-tight">Detail Berkas Pengaduan</h2>
                            <p class="text-sm text-slate-500 mt-1.5">Tinjau laporan pelanggan dan kelola penugasan teknisi lapangan secara terpusat.</p>
                        </div>
                    </div>
                </div>

                @if (session('success'))
                    <div class="mb-8 bg-emerald-50 border border-emerald-200 rounded-2xl p-4 flex items-center gap-4 shadow-sm animate-fade-in">
                        <div class="bg-emerald-500 p-1.5 rounded-full text-white shrink-0">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7" />
                            </svg>
                        </div>
                        <div>
                            <p class="text-sm text-emerald-800 font-medium">{{ session('success') }}</p>
                        </div>
                    </div>
                @endif

                <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                    
                    <div class="lg:col-span-2 space-y-8">
                        
                        <div class="bg-white rounded-3xl p-6 sm:p-8 border border-slate-200/80 shadow-[0_4px_20px_-4px_rgba(0,0,0,0.03)]">
                            <div class="flex flex-col sm:flex-row justify-between items-start gap-4 border-b border-slate-100 pb-6 mb-6">
                                <div>
                                    <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest mb-1.5 font-tegas">
                                        Subjek Laporan
                                    </p>
                                    <h3 class="text-xl font-bold text-[#111c2a] font-tegas">{{ $tiket->judul }}</h3>
                                </div>
                                
                                <span class="px-4 py-1.5 rounded-full text-[11px] font-bold uppercase tracking-wider border transition-all duration-300
                                    {{ $tiket->status == 'selesai' ? 'bg-emerald-50 text-emerald-600 border-emerald-200' : ($tiket->status == 'diproses' ? 'bg-slate-100 text-slate-600 border-slate-300' : 'bg-red-50 text-red-600 border-red-200') }}">
                                    {{ $tiket->status == 'menunggu verifikasi' ? 'Menunggu Verifikasi' : ($tiket->status == 'diproses' ? 'Dalam Proses' : 'Selesai Diperbaiki') }}
                                </span>
                            </div>

                            <div class="space-y-6">
                                <div>
                                    <p class="text-[11px] font-bold text-slate-400 uppercase tracking-wider mb-2 font-tegas">Deskripsi Kronologi Gangguan</p>
                                    <div class="text-slate-600 text-sm leading-relaxed bg-[#f8fafc] p-6 rounded-2xl border border-slate-100 shadow-inner">
                                        {{ $tiket->deskripsi }}
                                    </div>
                                </div>

                                <div class="grid grid-cols-1 sm:grid-cols-3 gap-6 pt-4 border-t border-slate-50">
                                    <div>
                                        <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest mb-1 font-tegas">Dilaporkan Pada</p>
                                        <p class="text-sm font-semibold text-slate-800">{{ $tiket->created_at->format('d M Y -.H:i') }} WIB</p>
                                    </div>
                                    <div>
                                        <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest mb-1 font-tegas">ID Pengguna</p>
                                        <p class="text-sm font-mono font-bold text-slate-800">#{{ $tiket->pelanggan->id ?? '-' }}</p>
                                    </div>
                                    <div>
                                        <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest mb-1 font-tegas">Teknisi Lapangan</p>
                                        <p class="text-sm font-bold {{ $tiket->teknisi_id ? 'text-slate-800' : 'text-[#dc2626]' }}">
                                            {{ $tiket->teknisi->name ?? 'Belum Ditugaskan' }}
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="bg-white rounded-3xl p-6 sm:p-8 border border-slate-200/80 shadow-[0_4px_20px_-4px_rgba(0,0,0,0.03)]">
                            <h4 class="text-sm font-bold text-[#111c2a] mb-6 font-tegas flex items-center gap-2.5 border-b border-slate-50 pb-4">
                                <svg class="w-5 h-5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                </svg>
                                Informasi Pelanggan
                            </h4>

                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-y-6 gap-x-8">
                                <div>
                                    <p class="text-[11px] font-bold text-slate-400 uppercase mb-1 font-tegas">Nama Lengkap</p>
                                    <p class="text-sm font-semibold text-slate-900">{{ $tiket->pelanggan->name ?? '-' }}</p>
                                </div>
                                <div>
                                    <p class="text-[11px] font-bold text-slate-400 uppercase mb-1 font-tegas">Email Sistem</p>
                                    <p class="text-sm font-medium text-slate-700">{{ $tiket->pelanggan->email ?? '-' }}</p>
                                </div>
                                <div>
                                    <p class="text-[11px] font-bold text-slate-400 uppercase mb-1 font-tegas">No Telepon / WhatsApp</p>
                                    <p class="text-sm font-semibold text-slate-900">{{ $tiket->pelanggan->no_telepon ?? '-' }}</p>
                                </div>
                                <div>
                                    <p class="text-[11px] font-bold text-slate-400 uppercase mb-1 font-tegas">Alamat Pemasangan</p>
                                    <p class="text-sm font-medium text-slate-700 leading-relaxed">{{ $tiket->pelanggan->alamat_lengkap ?? '-' }}</p>
                                </div>
                            </div>
                        </div>

                        <div class="bg-white rounded-3xl p-6 sm:p-8 border border-slate-200/80 shadow-[0_4px_20px_-4px_rgba(0,0,0,0.03)]">
                            <h4 class="text-sm font-bold text-[#111c2a] mb-6 font-tegas flex items-center gap-2.5 border-b border-slate-50 pb-4">
                                <svg class="w-5 h-5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                </svg>
                                Bukti Foto Penanganan
                            </h4>

                            @if ($tiket->bukti_foto)
                                <div class="relative bg-slate-50 rounded-2xl border border-slate-100 shadow-inner p-2 flex justify-center items-center">
                                    <a href="{{ asset('storage/' . $tiket->bukti_foto) }}" target="_blank" class="block group cursor-pointer relative">
                                        <img src="{{ asset('storage/' . $tiket->bukti_foto) }}" alt="Bukti Foto Teknisi" class="max-w-full rounded-xl object-contain max-h-[400px] transition-opacity duration-300 group-hover:opacity-90">
                                        
                                        <div class="absolute inset-0 flex items-center justify-center opacity-0 group-hover:opacity-100 transition-opacity duration-300 pointer-events-none">
                                            <div class="bg-black/50 text-white p-3 rounded-full backdrop-blur-sm">
                                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0zM10 7v3m0 0v3m0-3h3m-3 0H7"></path>
                                                </svg>
                                            </div>
                                        </div>
                                    </a>
                                </div>
                                <p class="text-[11px] font-medium text-slate-400 text-center mt-4">Klik gambar untuk melihat resolusi penuh</p>
                            @else
                                <div class="text-center py-12 bg-[#f8fafc] rounded-2xl border-2 border-dashed border-slate-200">
                                    <div class="bg-slate-100 w-16 h-16 rounded-full flex items-center justify-center mx-auto mb-3">
                                        <svg class="w-8 h-8 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"></path>
                                        </svg>
                                    </div>
                                    <p class="text-sm font-bold text-slate-500 font-tegas">Belum Ada Bukti Foto</p>
                                    <p class="text-xs text-slate-400 mt-1">Teknisi belum mengunggah dokumentasi perbaikan</p>
                                </div>
                            @endif
                        </div>
                    </div>

                    <div class="space-y-8">
                        
                        <div class="bg-white p-5 border border-slate-200/80 shadow-[0_4px_20px_-4px_rgba(0,0,0,0.03)] rounded-3xl overflow-hidden">
                            <p class="text-sm font-bold text-[#111c2a] mb-4 ml-1 flex items-center gap-2 font-tegas">
                                <svg class="w-4 h-4 text-[#dc2626]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                </svg>
                                Titik Koordinat Pelanggan
                            </p>

                            <div class="relative rounded-2xl overflow-hidden shadow-inner bg-slate-100 z-0 border border-slate-200">
                                <div id="map" class="h-48 w-full"></div>
                            </div>

                            <div class="mt-4 flex items-center justify-center gap-2 text-xs font-mono font-bold text-slate-600 bg-slate-50 py-2.5 rounded-xl border border-slate-100">
                                <span>{{ $tiket->latitude }}, {{ $tiket->longitude }}</span>
                            </div>
                        </div>

                        <div class="bg-white p-6 sm:p-8 border border-slate-200/80 shadow-[0_4px_20px_-4px_rgba(0,0,0,0.03)] rounded-3xl">
                            <h4 class="text-sm font-bold text-[#111c2a] mb-6 font-tegas flex items-center gap-2.5 border-b border-slate-50 pb-4">
                                <svg class="w-5 h-5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                </svg>
                                Aksi Administrator
                            </h4>

                            <form action="{{ route('admin.pengaduan.updateStatus', $tiket->id) }}" method="POST" class="space-y-5">
                                @csrf
                                @method('PATCH')

                                <div>
                                    <label class="block text-xs font-bold text-slate-500 uppercase mb-2 font-tegas">Pilih Teknisi Lapangan</label>
                                    <select name="teknisi_id" class="block w-full rounded-xl border-slate-200 py-3 px-4 text-sm bg-white focus:border-[#111c2a] focus:ring-[#111c2a] transition-all duration-300">
                                        <option value="">-- Belum Ditugaskan --</option>
                                        @foreach ($teknisis as $teknisi)
                                            <option value="{{ $teknisi->id }}" {{ $tiket->teknisi_id == $teknisi->id ? 'selected' : '' }}>
                                                {{ $teknisi->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>

                                <div>
                                    <label class="block text-xs font-bold text-slate-500 uppercase mb-2 font-tegas">Update Status Berkas</label>
                                    <select name="status" class="block w-full rounded-xl border-slate-200 py-3 px-4 text-sm bg-white focus:border-[#111c2a] focus:ring-[#111c2a] transition-all duration-300">
                                        <option value="menunggu verifikasi" {{ $tiket->status == 'menunggu verifikasi' ? 'selected' : '' }}>Menunggu Verifikasi</option>
                                        <option value="diproses" {{ $tiket->status == 'diproses' ? 'selected' : '' }}>Dalam Proses</option>
                                        <option value="selesai" {{ $tiket->status == 'selesai' ? 'selected' : '' }}>Selesai Diperbaiki</option>
                                    </select>
                                </div>

                                <button type="submit" class="w-full bg-[#111c2a] text-white rounded-full py-3.5 mt-4 text-xs font-bold uppercase tracking-wider hover:bg-slate-800 hover:shadow-lg focus:ring-4 focus:ring-slate-200 transition-all duration-300 font-tegas">
                                    Simpan Perubahan Berkas
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
        // Koordinat dinamis (dengan fallback default jika kosong)
        var lat = {{ $tiket->latitude ?? -8.1331 }};
        var lng = {{ $tiket->longitude ?? 113.2223 }};

        var map = L.map('map', {
            zoomControl: false
        }).setView([lat, lng], 16);
        
        L.control.zoom({
            position: 'topright'
        }).addTo(map);

        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '&copy; OpenStreetMap'
        }).addTo(map);

        var marker = L.marker([lat, lng]).addTo(map)
            .bindPopup("<div class='text-center'><b class='font-tegas text-sm'>Lokasi Titik</b><br><span class='text-xs text-slate-600'>{{ $tiket->pelanggan->name }}</span></div>")
            .openPopup();
    </script>
</x-app-layout>