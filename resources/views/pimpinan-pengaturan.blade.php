<x-app-layout>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&family=Poppins:wght@500;600;700;800&display=swap');
        
        .font-tegas { font-family: 'Poppins', sans-serif; }
        body { font-family: 'Inter', sans-serif; }

        .bg-grid-pattern {
            background-image: linear-gradient(to right, #80808012 1px, transparent 1px), linear-gradient(to bottom, #80808012 1px, transparent 1px);
            background-size: 24px 24px;
        }
    </style>

    <div class="relative min-h-screen bg-slate-50 bg-grid-pattern pb-20 pt-8">
        <div class="fixed top-0 left-1/4 w-[500px] h-[500px] bg-red-100/20 rounded-full blur-[140px] z-0 pointer-events-none"></div>

        <div class="relative z-10 max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
            
            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between mb-10 gap-4">
                <div class="flex items-center gap-5">
                    <div class="flex h-14 w-14 items-center justify-center rounded-[20px] bg-[#ef4444] text-white shadow-lg shadow-red-200/50 shrink-0">
                        <svg class="h-7 w-7" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z" />
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                        </svg>
                    </div>
                    <div>
                        <span class="text-[10px] font-extrabold text-red-600 uppercase tracking-[0.15em] block mb-0.5 font-tegas">Sistem Hak Akses Utama</span>
                        <h2 class="text-[1.6rem] font-bold text-gray-900 font-tegas tracking-tight leading-none">
                            Pengaturan Sistem
                        </h2>
                        <p class="text-[0.9rem] font-medium text-gray-500 mt-1.5 leading-relaxed">Kelola penamaan global, atribusi instansi, dan penjenamaan visual ekosistem.</p>
                    </div>
                </div>
            </div>

            @if(session('success'))
            <div class="mb-8 bg-emerald-50 border border-emerald-100 rounded-[1.25rem] p-4 flex items-center gap-3 shadow-sm">
                <div class="text-emerald-500 shrink-0">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                </div>
                <span class="text-sm font-bold text-emerald-900 tracking-wide">{{ session('success') }}</span>
            </div>
            @endif

            <div class="bg-white rounded-[1.5rem] border border-gray-100 p-6 sm:p-10 shadow-sm">
                <form action="{{ route('pimpinan.pengaturan.update') }}" method="POST" enctype="multipart/form-data" class="space-y-8">
                    @csrf
                    @method('PUT')
                    
                    <div>
                        <label class="block text-[11px] font-extrabold text-gray-400 uppercase tracking-wider mb-2.5 ml-0.5 font-tegas">Nama Sistem Aplikasi</label>
                        <input type="text" name="nama_aplikasi" value="{{ $pengaturan->nama_aplikasi }}" 
                            class="block w-full rounded-2xl border-0 py-3.5 px-4 text-gray-800 shadow-sm ring-1 ring-inset ring-gray-200 focus:ring-2 focus:ring-inset focus:ring-[#1e293b] bg-slate-50/50 text-sm font-bold outline-none transition-all duration-200 focus:bg-white" required>
                    </div>

                    <div>
                        <label class="block text-[11px] font-extrabold text-gray-400 uppercase tracking-wider mb-2.5 ml-0.5 font-tegas">Nama Perusahaan / Instansi</label>
                        <input type="text" name="nama_perusahaan" value="{{ $pengaturan->nama_perusahaan }}" 
                            class="block w-full rounded-2xl border-0 py-3.5 px-4 text-gray-800 shadow-sm ring-1 ring-inset ring-gray-200 focus:ring-2 focus:ring-inset focus:ring-[#1e293b] bg-slate-50/50 text-sm font-bold outline-none transition-all duration-200 focus:bg-white" required>
                    </div>

                    <div class="rounded-2xl border border-gray-100 bg-slate-50/50 p-6 space-y-5">
                        <label class="block text-[11px] font-extrabold text-gray-400 uppercase tracking-wider font-tegas">Visualisasi Logo Aplikasi (Opsional)</label>
                        
                        @if($pengaturan->logo)
                        <div class="flex items-center gap-4 bg-white p-4 rounded-2xl border border-gray-100 shadow-sm w-fit">
                            <div class="shrink-0 bg-slate-50 p-2.5 rounded-xl border border-slate-100">
                                <img src="{{ asset('storage/' . $pengaturan->logo) }}" alt="Logo" class="h-12 w-12 object-contain">
                            </div>
                            <div>
                                <p class="text-[10px] font-extrabold text-gray-400 uppercase tracking-wider font-tegas">Identitas Aktif</p>
                                <p class="text-xs text-gray-700 font-bold mt-0.5">Berkas lambang logo sistem utama.</p>
                            </div>
                        </div>
                        @endif
                        
                        <div class="relative">
                            <input type="file" name="logo" accept="image/png, image/jpeg, image/jpg" 
                                class="block w-full text-xs text-gray-500 file:mr-4 file:py-2.5 file:px-5 file:rounded-full file:border-0 file:text-[11px] file:font-extrabold file:uppercase file:tracking-wider file:bg-[#1e293b] file:text-white hover:file:bg-[#0f172a] file:transition-colors file:duration-200 cursor-pointer font-medium">
                        </div>
                        <p class="text-[10px] text-gray-400 font-bold font-mono leading-none">* Format berkas valid: JPG / PNG (Maksimal: 2 Megabytes).</p>
                    </div>

                    <div class="pt-6 border-t border-gray-100 flex flex-col sm:flex-row items-center justify-between gap-4">
                        <a href="{{ route('pimpinan.dashboard') }}" class="inline-flex items-center justify-center px-6 py-2.5 bg-white border border-gray-200 text-gray-600 hover:text-gray-900 text-xs font-bold uppercase tracking-wider rounded-full shadow-sm hover:bg-gray-50 transition-all duration-200 w-full sm:w-auto">
                            <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
                            Kembali
                        </a>

                        <button type="submit" class="w-full sm:w-auto px-8 py-3 bg-[#ef4444] hover:bg-red-600 text-white text-xs font-extrabold uppercase tracking-widest rounded-full shadow-md shadow-red-200/50 transition-all duration-200 transform hover:-translate-y-0.5 font-tegas">
                            Simpan Konfigurasi
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>