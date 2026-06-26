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

    <div class="relative min-h-screen bg-gray-50/50 pb-16">
        <div class="fixed inset-0 z-0 bg-grid-pattern opacity-60"></div>
        <div class="fixed top-0 right-0 w-[600px] h-[600px] bg-red-50/30 rounded-full blur-[130px] z-0 pointer-events-none"></div>

        <div class="relative z-10">
            <div class="bg-white/60 backdrop-blur-md border-b border-gray-100">
                <div class="max-w-6xl mx-auto py-8 px-4 sm:px-6 lg:px-8 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                    <div>
                        <h2 class="text-2xl font-bold text-gray-900 font-tegas">
                            Manajemen Data Kategori
                        </h2>
                        <p class="text-sm text-black mt-1 font-light">Kelola master rumpun masalah gangguan untuk klasifikasi tiket pengaduan.</p>
                    </div>
                    
                    <div class="shrink-0">
                        <a href="{{ route('admin.dashboard') }}" class="inline-flex items-center gap-1.5 text-xs font-bold tracking-wide text-gray-500 hover:text-gray-900 transition-colors duration-200 bg-white px-4 py-2 rounded-xl border border-gray-100 shadow-sm">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
                            DASHBOARD
                        </a>
                    </div>
                </div>
            </div>

            <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 mt-10">
                
                @if(session('success'))
                <div class="mb-8 bg-green-50 border border-green-100 rounded-2xl p-4 flex items-center gap-4 animate-fade-in-down">
                    <div class="bg-green-500 p-2 rounded-xl text-white">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                    </div>
                    <div>
                        <h4 class="text-sm font-bold text-green-900">Aksi Berhasil</h4>
                        <p class="text-xs text-green-700 font-light">{{ session('success') }}</p>
                    </div>
                </div>
                @endif

                <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                    
                    <div class="bg-white rounded-[2rem] p-6 sm:p-8 shadow-xl shadow-gray-200/30 border border-gray-100/50 h-fit">
                        <div class="mb-6">
                            <h3 class="text-sm font-bold uppercase tracking-wider text-gray-800 font-tegas">Tambah Kategori</h3>
                            <p class="text-xs text-black mt-1 font-light">Buat sub-klasifikasi keluhan gangguan baru.</p>
                        </div>
                        
                        <form action="{{ route('admin.kategori.store') }}" method="POST" class="space-y-5">
                            @csrf
                            <div>
                                <label class="block text-[10px] font-bold text-black uppercase tracking-widest mb-2">Nama Kategori Baru</label>
                                <input type="text" name="nama_kategori" required placeholder="Contoh: Lampu LOS Merah" 
                                    class="block w-full rounded-xl border-0 py-3.5 px-4 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-100 placeholder:text-gray-300 focus:ring-1 focus:ring-inset focus:ring-gray-900 bg-gray-50/30 sm:text-sm transition-all duration-300 outline-none">
                            </div>
                            
                            <button type="submit" class="w-full flex justify-center rounded-xl bg-gray-900 px-4 py-3.5 text-xs font-bold tracking-widest text-white shadow-md hover:bg-red-600 hover:shadow-lg transition-all duration-300 transform hover:-translate-y-0.5">
                                SIMPAN DATA
                            </button>
                        </form>
                    </div>

                    <div class="lg:col-span-2 bg-white rounded-[2rem] shadow-xl shadow-gray-200/30 border border-gray-100 overflow-hidden">
                        <div class="px-8 py-5 border-b border-gray-50 bg-gray-50/20">
                            <h3 class="text-sm font-bold uppercase tracking-wider text-gray-800 font-tegas">Kategori Terdaftar</h3>
                        </div>
                        
                        <div class="overflow-x-auto">
                            <table class="w-full text-left">
                                <thead>
                                    <tr class="text-[10px] text-black uppercase tracking-[0.15em] bg-gray-50/30 border-b border-gray-50">
                                        <th class="px-8 py-4 font-bold text-center w-16">No</th>
                                        <th class="px-8 py-4 font-bold">Deskripsi Kategori Masalah</th>
                                        <th class="px-8 py-4 font-bold text-center w-32">Tindakan</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-gray-50">
                                    @forelse($semuaKategori as $index => $kat)
                                    <tr class="group hover:bg-gray-50/40 transition-all duration-200">
                                        <td class="px-8 py-4 text-center">
                                            <span class="text-xs font-mono text-gray-400 font-medium">{{ $index + 1 }}</span>
                                        </td>
                                        <td class="px-8 py-4">
                                            <p class="text-xs font-bold text-gray-900 tracking-wide bg-purple-50/60 text-purple-700 px-3 py-1.5 rounded-full inline-block ring-1 ring-purple-100">
                                                📁 {{ $kat->nama_kategori }}
                                            </p>
                                        </td>
                                        <td class="px-8 py-4 text-center">
                                            <form action="{{ route('admin.kategori.destroy', $kat->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus kategori masalah ini?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="inline-flex items-center px-4 py-1.5 bg-red-50 hover:bg-red-600 border border-red-100 text-red-600 hover:text-white text-[10px] font-bold uppercase tracking-wider rounded-xl transition-all duration-300">
                                                    Hapus
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                    @empty
                                    <tr>
                                        <td colspan="3" class="px-8 py-16 text-center">
                                            <div class="flex flex-col items-center opacity-30">
                                                <svg class="w-12 h-12 mb-2 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0a2 2 0 01-2 2H6a2 2 0 01-2-2m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"/></svg>
                                                <p class="text-xs font-semibold tracking-wide text-gray-500 uppercase">Belum ada rumpun kategori data.</p>
                                            </div>
                                        </td>
                                    </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>

                </div>

            </div>
        </div>
    </div>
</x-app-layout>