<x-app-layout>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600&family=Poppins:wght@500;600;700&display=swap');

        .font-tegas {
            font-family: 'Poppins', sans-serif;
        }

        body {
            font-family: 'Inter', sans-serif;
        }

        /* Latar belakang grid yang disesuaikan persis dengan foto dasbor */
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
                        <div class="w-14 h-14 bg-[#dc2626] rounded-2xl flex items-center justify-center text-white shadow-[0_8px_20px_-6px_rgba(220,38,38,0.45)] shrink-0">
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
                                        <p class="text-sm font-semibold text-slate-800">{{ $tiket->created_at->format('d M Y - H:i') }} WIB</p>
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

                        @if ($tiket->foto_bukti)
                            <div class="bg-white rounded-3xl p-6 sm:p-8 border border-slate-200/80 shadow-[0_4px_20px_-4px_rgba(0,0,0,0.03)] animate-fade-in">
                                <h4 class="text-sm font-bold text-[#111c2a] mb-6 font-tegas flex items-center gap-2.5 border-b border-slate-50 pb-4">
                                    <svg class="w-5 h-5 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z"></path>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 13a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                    </svg>
                                    Bukti Penanganan Teknisi
                                </h4>
                                
                                <div class="relative rounded-2xl overflow-hidden border border-slate-200 bg-slate-50 shadow-inner group">
                                    <img src="{{ asset('storage/' . $tiket->foto_bukti) }}" alt="Foto Bukti Teknisi" class="w-full h-auto object-contain max-h-[500px] transition-transform duration-500 group-hover:scale-[1.02]">
                                    
                                    <a href="{{ asset('storage/' . $tiket->foto_bukti) }}" target="_blank" class="absolute top-4 right-4 bg-white/90 backdrop-blur-sm p-2 rounded-xl text-slate-700 hover:text-[#111c2a] shadow-sm transition-all duration-300 opacity-0 group-hover:opacity-100">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 8V4m0 0h4M4 4l5 5m11-1V4m0 0h-4m4 0l-5 5M4 16v4m0 0h4m-4 0l5-5m11 5l-5-5m5 5v-4m0 4h-4"></path>
                                        </svg>
                                    </a>
                                </div>
                                <p class="text-xs text-slate-500 mt-4 text-center font-medium">Foto diunggah pada saat status laporan diselesaikan.</p>
                            </div>
                        @endif
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
                                Kendali Distribusi Tugas (Dispatching)
                            </h4>

                            @if($tiket->status !== 'selesai')
                                <form action="{{ route('admin.pengaduan.updateStatus', $tiket->id) }}" method="POST" class="space-y-5">
                                    @csrf
                                    @method('PATCH')

                                    <div class="mb-4">
                                        {{-- MODIFIKASI DISINI: Menghindari error jika $tiket->pelanggan / user bernilai null --}}
                                        <label class="block text-sm font-bold text-gray-700">Tugaskan Teknisi (Wilayah: {{ $tiket->pelanggan?->kecamatan ?? 'Tidak Diketahui' }})</label>
                                        
                                        {{-- Notifikasi Tambahan Jika di Luar Jam Kerja --}}
                                        @if(isset($isLuarJamKerja) && $isLuarJamKerja && !$tiket->teknisi_id)
                                            <div class="mb-2 p-3 bg-red-50 rounded-xl border border-red-100 text-[12px] font-bold text-red-600 flex items-center gap-2">
                                                <span>Sistem Terkunci: Saat ini di luar jam kerja operasional (07:00 - 17:00).</span>
                                            </div>
                                        @endif

                                        <select name="teknisi_id" class="block w-full rounded-xl border-slate-200 py-3 px-4 text-sm bg-white focus:border-[#111c2a] focus:ring-[#111c2a] transition-all duration-300">
                                            <option value="">-- Belum Ditugaskan --</option>
                                            @if(isset($teknisiTersedia) && count($teknisiTersedia) > 0)
                                                @foreach($teknisiTersedia as $tek)
                                                    <option value="{{ $tek->id }}" {{ $tiket->teknisi_id == $tek->id ? 'selected' : '' }}>
                                                        {{ $tek->name }} (Tugas: {{ $tek->kecamatan_tugas }})
                                                    </option>
                                                @endforeach
                                            @else
                                                @forelse ($teknisis ?? [] as $teknisi)
                                                    <option value="{{ $teknisi->id }}" {{ $tiket->teknisi_id == $teknisi->id ? 'selected' : '' }} class="text-slate-900 font-semibold">
                                                        {{ $teknisi->name }} 
                                                        @if($tiket->teknisi_id == $teknisi->id)
                                                            - (Saat Ini Ditugaskan)
                                                        @else
                                                            - (Siaga / Tersedia)
                                                        @endif
                                                    </option>
                                                @empty
                                                    <option value="" disabled class="text-red-500 bg-red-50">❌ Tidak ada teknisi yang tersedia saat ini</option>
                                                @endforelse
                                            @endif
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

                                    <button type="submit" onclick="return confirm('Simpan perubahan data pendelegasian ini?');" class="w-full bg-[#111c2a] text-white rounded-full py-3.5 mt-4 text-xs font-bold uppercase tracking-wider hover:bg-slate-800 hover:shadow-lg focus:ring-4 focus:ring-slate-200 transition-all duration-300 font-tegas">
                                        Simpan Perubahan Berkas
                                    </button>
                                </form>
                            @else
                                {{-- Kondisi Jika Tiket Selesai Diperbaiki --}}
                                <div class="bg-emerald-50 border border-emerald-100 p-5 rounded-2xl text-center">
                                    <div class="w-10 h-10 bg-emerald-100 text-emerald-600 rounded-full flex items-center justify-center mx-auto mb-3">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7" />
                                        </svg>
                                    </div>
                                    <h5 class="text-xs font-bold text-slate-900 uppercase font-tegas tracking-wide">Status Selesai</h5>
                                    <p class="text-[11px] text-slate-500 mt-1 leading-relaxed">
                                        Gangguan ini telah berhasil diperbaiki oleh teknisi lapangan <b>{{ $tiket->teknisi->name ?? '-' }}</b> dan berkas telah dikunci.
                                    </p>
                                </div>
                            @endif
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
            .bindPopup("<div class='text-center'><b class='font-tegas text-sm'>Lokasi Titik</b><br><span class='text-xs text-slate-600'>{{ $tiket->pelanggan?->name ?? 'Pelanggan' }}</span></div>")
            .openPopup();
    </script>
</x-app-layout>