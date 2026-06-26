<x-app-layout>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600&family=Poppins:wght@500;600;700&display=swap');
        
        .font-tegas { font-family: 'Poppins', sans-serif; }
        body { font-family: 'Inter', sans-serif; background-color: #ffffff; }

        .bg-grid-pattern {
            background-image: linear-gradient(to right, #f1f5f9 1px, transparent 1px), linear-gradient(to bottom, #f1f5f9 1px, transparent 1px);
            background-size: 3rem 3rem;
        }
    </style>

    <div class="relative min-h-screen bg-gray-50/40 pb-20">
        <div class="fixed inset-0 z-0 bg-grid-pattern opacity-50"></div>
        <div class="fixed top-0 left-1/4 w-[500px] h-[500px] bg-red-50/30 rounded-full blur-[140px] z-0 pointer-events-none"></div>

        <div class="relative z-10">
            <div class="bg-white/60 backdrop-blur-md border-b border-gray-100">
                <div class="max-w-3xl mx-auto py-8 px-4 sm:px-6 lg:px-8">
                    <span class="text-[9px] font-bold text-red-600 uppercase tracking-[0.2em] block mb-1 font-tegas">Konfigurasi Inti</span>
                    <h2 class="text-2xl font-bold text-gray-950 font-tegas leading-none">
                        Pengaturan Sistem
                    </h2>
                    <p class="text-xs text-black mt-1.5 font-light">Kelola penamaan global, atribusi instansi, dan penjenamaan visual ekosistem.</p>
                </div>
            </div>

            <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8 mt-10">
                
                @if(session('success'))
                <div class="mb-8 bg-green-50/80 border border-green-100 rounded-2xl p-4 flex items-center gap-3 animate-fade-in-down">
                    <div class="text-green-500 shrink-0">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    </div>
                    <span class="text-xs font-semibold text-gray-900">{{ session('success') }}</span>
                </div>
                @endif

                <div class="bg-white rounded-[2rem] shadow-2xl shadow-gray-200/30 border border-gray-100/60 p-8 sm:p-10">
                    <form action="{{ route('pimpinan.pengaturan.update') }}" method="POST" enctype="multipart/form-data" class="space-y-8">
                        @csrf
                        @method('PUT')
                        
                        <div>
                            <label class="block text-[10px] font-bold text-black uppercase tracking-widest mb-2.5 ml-0.5">Nama Sistem Aplikasi</label>
                            <input type="text" name="nama_aplikasi" value="{{ $pengaturan->nama_aplikasi }}" class="block w-full rounded-xl border-0 py-3.5 px-4 text-gray-950 shadow-sm ring-1 ring-inset ring-gray-200 focus:ring-1 focus:ring-inset focus:ring-gray-950 bg-gray-50/40 text-sm font-medium outline-none transition-all duration-300" required>
                        </div>

                        <div>
                            <label class="block text-[10px] font-bold text-black uppercase tracking-widest mb-2.5 ml-0.5">Nama Perusahaan / Instansi</label>
                            <input type="text" name="nama_perusahaan" value="{{ $pengaturan->nama_perusahaan }}" class="block w-full rounded-xl border-0 py-3.5 px-4 text-gray-950 shadow-sm ring-1 ring-inset ring-gray-200 focus:ring-1 focus:ring-inset focus:ring-gray-950 bg-gray-50/40 text-sm font-medium outline-none transition-all duration-300" required>
                        </div>

                        <div class="rounded-2xl border border-gray-100 bg-gray-50/40 p-6 space-y-4">
                            <label class="block text-[10px] font-bold text-black uppercase tracking-widest">Visualisasi Logo Aplikasi (Opsional)</label>
                            
                            @if($pengaturan->logo)
                            <div class="flex items-center gap-4 bg-white p-4 rounded-xl border border-gray-50 shadow-sm w-fit">
                                <div class="shrink-0 bg-gray-50 p-2 rounded-lg border border-gray-100">
                                    <img src="{{ asset('storage/' . $pengaturan->logo) }}" alt="Logo" class="h-12 w-12 object-contain">
                                </div>
                                <div>
                                    <p class="text-[10px] font-bold text-black uppercase tracking-wider">Identitas Aktif</p>
                                    <p class="text-xs text-gray-600 font-light mt-0.5">Berkas lambang logo sistem tersimpan saat ini.</p>
                                </div>
                            </div>
                            @endif
                            
                            <div class="relative group">
                                <input type="file" name="logo" accept="image/png, image/jpeg, image/jpg" class="block w-full text-xs text-gray-500 file:mr-4 file:py-2.5 file:px-5 file:rounded-xl file:border-0 file:text-[10px] file:font-bold file:uppercase file:tracking-wider file:bg-gray-950 file:text-white hover:file:bg-red-600 file:transition-colors file:duration-300 cursor-pointer">
                            </div>
                            <p class="text-[10px] text-gray-600 font-light font-mono leading-none">* Ekstensi formal: JPG / PNG. Alokasi kapasitas maksimal berkas: 2 Megabytes.</p>
                        </div>

                        <div class="pt-4 border-t border-gray-50 flex flex-col sm:flex-row items-center justify-between gap-4">
                            <a href="{{ route('pimpinan.dashboard') }}" class="inline-flex items-center justify-center px-6 py-3 bg-white border border-gray-200 text-gray-500 hover:text-gray-900 text-xs font-semibold uppercase tracking-widest rounded-full shadow-sm transition-colors duration-300 w-full sm:w-auto">
                                <svg class="w-3.5 h-3.5 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
                                Kembali
                            </a>

                            <button type="submit" class="w-full sm:w-auto px-10 py-3.5 bg-gray-950 hover:bg-red-600 text-white text-xs font-bold uppercase tracking-[0.2em] rounded-full shadow-xl shadow-gray-950/10 hover:shadow-red-500/20 transition-all duration-300 transform hover:-translate-y-0.5">
                                Simpan Konfigurasi
                            </button>
                        </div>
                    </form>
                </div>
            </div>

        </div>
    </div>
</x-app-layout>