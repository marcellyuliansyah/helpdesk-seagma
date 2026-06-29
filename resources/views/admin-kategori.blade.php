<x-app-layout>
    <div class="min-h-screen bg-slate-50 bg-[linear-gradient(to_right,#80808012_1px,transparent_1px),linear-gradient(to_bottom,#80808012_1px,transparent_1px)] bg-[size:24px_24px] pb-12">
        <div class="max-w-7xl mx-auto p-4 sm:p-6 lg:p-8 pt-8">

            @if(session('success'))
                <div class="rounded-[1.25rem] bg-[#10b981]/10 p-4 mb-6 border border-[#10b981]/20 shadow-sm">
                    <div class="flex items-center">
                        <div class="flex-shrink-0">
                            <svg class="h-5 w-5 text-[#10b981]" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.857-9.809a.75.75 0 00-1.214-.882l-3.483 4.79-1.88-1.88a.75.75 0 10-1.06 1.061l2.5 2.5a.75.75 0 001.137-.089l4-5.5z" clip-rule="evenodd" />
                            </svg>
                        </div>
                        <div class="ml-3">
                            <p class="text-sm font-semibold text-emerald-800">{{ session('success') }}</p>
                        </div>
                    </div>
                </div>
            @endif

            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between mb-10 gap-4">
                <div class="flex items-center gap-5">
                    <div class="flex h-14 w-14 items-center justify-center rounded-[1rem] bg-[#ef4444] text-white shadow-lg shadow-red-200/50">
                        <svg class="h-7 w-7" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 12.75V12A2.25 2.25 0 014.5 9.75h15A2.25 2.25 0 0121.75 12v.75m-8.69-6.44l-2.12-2.12a1.5 1.5 0 00-1.061-.44H4.5A2.25 2.25 0 002.25 6v12a2.25 2.25 0 002.25 2.25h15A2.25 2.25 0 0021.75 18V9a2.25 2.25 0 00-2.25-2.25h-5.379a1.5 1.5 0 01-1.06-.44z" />
                        </svg>
                    </div>
                    <div>
                        <h2 class="text-[1.6rem] font-bold text-gray-800 tracking-tight">
                            Manajemen Data Kategori
                        </h2>
                        <p class="text-[0.95rem] font-medium text-gray-500 mt-1">Kelola master rumpun masalah gangguan untuk klasifikasi tiket pengaduan.</p>
                    </div>
                </div>
                
                <div class="flex-none">
                    <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-2 rounded-full bg-[#1e293b] px-7 py-3 text-sm font-bold text-white shadow-md hover:bg-[#0f172a] hover:-translate-y-0.5 transition-all duration-200 uppercase tracking-wider">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path></svg>
                        Kembali
                    </a>
                </div>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                
                <div class="bg-white rounded-[1.5rem] shadow-sm border border-gray-100 p-6 sm:p-8 h-fit relative overflow-hidden">
                    <div class="mb-6 border-b border-gray-100 pb-5">
                        <div class="flex items-center gap-3 mb-1">
                            <div class="p-2 bg-gray-50 rounded-lg">
                                <svg class="w-5 h-5 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                            </div>
                            <h3 class="text-lg font-bold text-gray-800">Tambah Kategori</h3>
                        </div>
                        <p class="text-sm text-gray-500 font-medium ml-11">Buat sub-klasifikasi keluhan baru.</p>
                    </div>
                    
                    <form action="{{ route('admin.kategori.store') }}" method="POST" class="space-y-6">
                        @csrf
                        <div>
                            <label class="block text-sm font-bold text-gray-700 mb-2">Nama Kategori Baru</label>
                            <input type="text" name="nama_kategori" required placeholder="Contoh: Lampu LOS Merah" 
                                class="block w-full rounded-2xl border-0 py-3 px-4 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-200 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-[#1e293b] sm:text-sm font-medium transition-all bg-gray-50 focus:bg-white">
                        </div>
                        
                        <button type="submit" class="w-full flex justify-center items-center gap-2 rounded-full bg-[#10b981] px-4 py-3.5 text-sm font-bold tracking-wider text-white shadow-md hover:bg-emerald-600 transition-all duration-200 uppercase">
                            Simpan Data
                        </button>
                    </form>
                </div>

                <div class="lg:col-span-2 bg-white rounded-[1.5rem] shadow-sm border border-gray-100 overflow-hidden p-6 sm:p-8">
                    <div class="mb-6 flex items-center gap-3 border-b border-gray-100 pb-5">
                        <div class="p-2 bg-gray-50 rounded-lg">
                            <svg class="w-5 h-5 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 10h16M4 14h16M4 18h16"></path></svg>
                        </div>
                        <h3 class="text-lg font-bold text-gray-800">Daftar Kategori Tersedia</h3>
                    </div>

                    <div class="overflow-x-auto">
                        <table class="w-full text-left border-collapse min-w-max">
                            <thead>
                                <tr class="border-b-2 border-gray-100">
                                    <th class="py-4 px-4 font-bold text-gray-400 text-[11px] uppercase tracking-wider w-16 text-center">No</th>
                                    <th class="py-4 px-4 font-bold text-gray-400 text-[11px] uppercase tracking-wider">Nama Kategori Masalah</th>
                                    <th class="py-4 px-4 font-bold text-gray-400 text-[11px] uppercase tracking-wider text-right w-32">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($semuaKategori as $index => $kat)
                                    <tr class="border-b border-gray-50 hover:bg-slate-50/50 transition-colors duration-200">
                                        <td class="py-5 px-4 align-middle text-center">
                                            <span class="text-sm font-bold text-gray-400">{{ $index + 1 }}</span>
                                        </td>
                                        <td class="py-5 px-4 align-middle">
                                            <span class="text-[14px] font-bold text-gray-700">{{ $kat->nama_kategori }}</span>
                                        </td>
                                        <td class="py-5 px-4 align-middle text-right">
                                            <form action="{{ route('admin.kategori.destroy', $kat->id) }}" method="POST" class="inline-block m-0" onsubmit="return confirm('Apakah Anda yakin ingin menghapus kategori masalah ini?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="inline-flex items-center justify-center rounded-full bg-[#ef4444]/10 text-[#ef4444] hover:bg-[#ef4444] hover:text-white px-5 py-2 text-[11px] font-extrabold tracking-wider transition-all duration-200 uppercase">
                                                    Hapus
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="3" class="py-16 px-6 text-center">
                                            <div class="flex flex-col items-center justify-center">
                                                <div class="p-4 rounded-full bg-gray-50 mb-4 border border-gray-100">
                                                    <svg class="w-8 h-8 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0a2 2 0 01-2 2H6a2 2 0 01-2-2m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"/></svg>
                                                </div>
                                                <p class="text-sm font-bold text-gray-400">Belum ada kategori masalah.</p>
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
</x-app-layout>