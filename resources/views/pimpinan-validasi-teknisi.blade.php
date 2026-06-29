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
        <div class="fixed top-0 left-1/3 w-[500px] h-[500px] bg-red-100/20 rounded-full blur-[140px] z-0 pointer-events-none"></div>

        <div class="relative z-10 max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
            
            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between mb-8 gap-4">
                <div class="flex items-center gap-5">
                    <div class="flex h-14 w-14 items-center justify-center rounded-[20px] bg-[#ef4444] text-white shadow-lg shadow-red-200/50 shrink-0">
                        <svg class="h-7 w-7" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                        </svg>
                    </div>
                    <div>
                        <span class="text-[10px] font-extrabold text-red-600 uppercase tracking-[0.15em] block mb-0.5 font-tegas">Sistem Hak Akses Utama</span>
                        <h2 class="text-[1.6rem] font-bold text-gray-900 font-tegas tracking-tight leading-none">
                            Validasi Akun Teknisi
                        </h2>
                        <p class="text-[0.9rem] font-medium text-gray-500 mt-1.5 leading-none">Daftar akun teknisi baru yang memerlukan verifikasi dan persetujuan pimpinan.</p>
                    </div>
                </div>
                
                <div>
                    <a href="javascript:history.back()" class="inline-flex items-center justify-center px-6 py-2.5 bg-white border border-gray-200 text-gray-600 hover:text-gray-900 text-xs font-bold uppercase tracking-wider rounded-full shadow-sm hover:bg-gray-50 transition-all duration-200">
                        <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
                        Kembali
                    </a>
                </div>
            </div>

            <div class="bg-white rounded-[2rem] border border-gray-100/80 shadow-sm overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr class="border-b border-gray-100 bg-slate-50/50">
                                <th class="px-8 py-5 text-[11px] font-extrabold uppercase tracking-wider text-gray-400 font-tegas">Nama</th>
                                <th class="px-8 py-5 text-[11px] font-extrabold uppercase tracking-wider text-gray-400 font-tegas">Email</th>
                                <th class="px-8 py-5 text-[11px] font-extrabold uppercase tracking-wider text-gray-400 font-tegas text-center">Status</th>
                                <th class="px-8 py-5 text-[11px] font-extrabold uppercase tracking-wider text-gray-400 font-tegas text-center">Aksi</th>
                            </tr>
                        </thead>

                        <tbody class="divide-y divide-gray-50">
                            @foreach ($teknisi as $user)
                                <tr class="hover:bg-slate-50/30 transition-colors duration-150">
                                    <td class="px-8 py-5 text-sm font-bold text-gray-900 tracking-tight">
                                        {{ $user->name }}
                                    </td>

                                    <td class="px-8 py-5 text-sm font-medium text-gray-500">
                                        {{ $user->email }}
                                    </td>

                                    <td class="px-8 py-5 text-center whitespace-nowrap">
                                        @if ($user->is_approved)
                                            <span class="inline-flex items-center px-4 py-1.5 rounded-full text-[10px] font-extrabold uppercase tracking-wider bg-[#00b67a] text-white shadow-sm">
                                                Sudah Valid
                                            </span>
                                        @else
                                            <span class="inline-flex items-center px-4 py-1.5 rounded-full text-[10px] font-extrabold uppercase tracking-wider bg-rose-50 text-rose-600 border border-rose-100 font-medium">
                                                Belum Valid
                                            </span>
                                        @endif
                                    </td>

                                    <td class="px-8 py-5 text-center whitespace-nowrap">
                                        @if (!$user->is_approved)
                                            <form action="{{ route('pimpinan.users.approve', $user->id) }}" method="POST" class="inline-block">
                                                @csrf
                                                @method('PATCH')

                                                <button type="submit"
                                                    class="inline-flex items-center justify-center px-5 py-1.5 bg-[#1e293b] hover:bg-[#0f172a] text-white text-[11px] font-extrabold uppercase tracking-wider rounded-full shadow-sm transition-all duration-200 transform hover:-translate-y-0.5 font-tegas">
                                                    Validasi
                                                </button>
                                            </form>
                                        @else
                                            <span class="text-gray-300 font-bold text-sm">-</span>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                
                @if($teknisi->isEmpty())
                    <div class="py-12 text-center">
                        <svg class="mx-auto h-10 w-10 text-gray-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0a2 2 0 01-2 2H6a2 2 0 01-2-2m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4" />
                        </svg>
                        <p class="mt-4 text-xs font-semibold text-gray-400 uppercase tracking-wider font-tegas">Tidak ada antrean validasi teknisi</p>
                    </div>
                @endif
            </div>

        </div>
    </div>
</x-app-layout>