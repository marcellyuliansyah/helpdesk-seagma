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
        <div class="fixed top-0 right-1/4 w-[500px] h-[500px] bg-red-50/20 rounded-full blur-[140px] z-0 pointer-events-none"></div>

        <div class="relative z-10">
            <div class="bg-white/60 backdrop-blur-md border-b border-gray-100">
                <div class="max-w-3xl mx-auto py-8 px-4 sm:px-6 lg:px-8">
                    <span class="text-[9px] font-bold text-red-600 uppercase tracking-[0.2em] block mb-1 font-tegas">Modifikasi Kredensial</span>
                    <h2 class="text-2xl font-bold text-gray-950 font-tegas leading-none">
                        Pembaruan Profil Pengguna
                    </h2>
                    <p class="text-xs text-gray-400 mt-1.5 font-light">Lakukan penyesuaian identitas, delegasi hak akses, atau intervensi kata sandi.</p>
                </div>
            </div>

            <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8 mt-10">
                <div class="bg-white rounded-[2rem] shadow-2xl shadow-gray-200/30 border border-gray-100/60 p-8 sm:p-10 relative overflow-hidden">
                    
                    <div class="absolute top-0 left-0 w-full h-1 bg-gradient-to-r from-transparent via-gray-950 to-transparent opacity-20"></div>

                    <form action="{{ route('pimpinan.users.update', $user->id) }}" method="POST" class="space-y-8 relative z-10">
                        @csrf
                        @method('PUT')
                        
                        <div>
                            <label class="block text-[10px] font-bold text-gray-400 uppercase tracking-widest mb-2.5 ml-0.5">Identitas Lengkap (Nama)</label>
                            <input type="text" name="name" value="{{ $user->name }}" class="block w-full rounded-xl border-0 py-3.5 px-4 text-gray-950 shadow-sm ring-1 ring-inset ring-gray-200 focus:ring-1 focus:ring-inset focus:ring-gray-950 bg-gray-50/40 text-sm font-medium outline-none transition-all duration-300" required autocomplete="off">
                        </div>

                        <div>
                            <label class="block text-[10px] font-bold text-gray-400 uppercase tracking-widest mb-2.5 ml-0.5">Korespondensi (Alamat Email)</label>
                            <input type="email" name="email" value="{{ $user->email }}" class="block w-full rounded-xl border-0 py-3.5 px-4 text-gray-950 shadow-sm ring-1 ring-inset ring-gray-200 focus:ring-1 focus:ring-inset focus:ring-gray-950 bg-gray-50/40 text-sm font-medium outline-none transition-all duration-300" required autocomplete="off">
                        </div>

                        <div class="bg-gray-50/50 p-6 rounded-2xl border border-gray-100">
                            <label class="block text-[10px] font-bold text-gray-400 uppercase tracking-widest mb-3">Tingkat Hak Akses / Otoritas (Role)</label>
                            <select name="role" class="block w-full rounded-xl border-0 py-3.5 px-4 text-gray-950 shadow-sm ring-1 ring-inset ring-gray-200 focus:ring-1 focus:ring-inset focus:ring-gray-950 bg-white text-sm font-semibold outline-none transition-all cursor-pointer" required>
                                <option value="pelanggan" {{ $user->role === 'pelanggan' ? 'selected' : '' }}>Pelanggan (Akses Front-End Laporan)</option>
                                <option value="teknisi" {{ $user->role === 'teknisi' ? 'selected' : '' }}>Teknisi (Akses Penanganan & Resolusi)</option>
                                <option value="admin" {{ $user->role === 'admin' ? 'selected' : '' }}>Administrator (Operator Manajemen Harian)</option>
                                <option value="pimpinan" {{ $user->role === 'pimpinan' ? 'selected' : '' }}>Pimpinan (Hak Akses Absolut / God Mode)</option>
                            </select>
                        </div>

                        <div class="relative overflow-hidden bg-white p-6 rounded-2xl border border-gray-200 shadow-sm">
                            <div class="absolute left-0 top-0 w-1 h-full bg-red-400"></div>
                            
                            <label class="block text-[10px] font-bold text-gray-900 uppercase tracking-widest mb-1">Intervensi Kata Sandi (Force Reset)</label>
                            <p class="text-[9px] text-gray-400 font-light font-mono leading-relaxed mb-4">* Biarkan bidang ini kosong jika tidak ada tindakan pemulihan (reset) kata sandi untuk akun terkait.</p>
                            
                            <input type="password" name="password" placeholder="Ketik kata sandi baru di sini..." class="block w-full rounded-xl border-0 py-3.5 px-4 text-gray-950 shadow-sm ring-1 ring-inset ring-gray-200 focus:ring-1 focus:ring-inset focus:ring-red-400 bg-gray-50/40 text-sm font-medium outline-none transition-all duration-300" minlength="8" autocomplete="new-password">
                        </div>

                        <div class="pt-6 border-t border-gray-50 flex flex-col sm:flex-row items-center justify-between gap-4">
                            <a href="{{ route('pimpinan.dashboard') }}" class="inline-flex items-center justify-center px-6 py-3.5 bg-white border border-gray-200 text-gray-500 hover:text-gray-900 text-xs font-semibold uppercase tracking-widest rounded-full shadow-sm transition-colors duration-300 w-full sm:w-auto group">
                                <svg class="w-3.5 h-3.5 mr-1.5 transition-transform group-hover:-translate-x-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
                                Batalkan
                            </a>

                            <button type="submit" class="w-full sm:w-auto px-10 py-3.5 bg-gray-950 hover:bg-red-600 text-white text-xs font-bold uppercase tracking-[0.2em] rounded-full shadow-xl shadow-gray-950/10 hover:shadow-red-500/20 transition-all duration-300 transform hover:-translate-y-0.5">
                                Simpan Perubahan
                            </button>
                        </div>
                    </form>
                </div>
            </div>

        </div>
    </div>
</x-app-layout>