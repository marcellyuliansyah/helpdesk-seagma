<x-app-layout>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600&family=Poppins:wght@400;500;600;700&display=swap');

        .font-tegas {
            font-family: 'Poppins', sans-serif;
        }

        body {
            font-family: 'Inter', sans-serif;
        }

        /* Pola Grid diatur tipis agar selaras dengan gradasi */
        .bg-grid-pattern {
            background-image: linear-gradient(to right, #f1f5f9 1px, transparent 1px), linear-gradient(to bottom, #f1f5f9 1px, transparent 1px);
            background-size: 3rem 3rem;
        }
    </style>

    <div class="relative min-h-screen bg-white bg-gradient-to-b from-white via-white to-slate-100/50 pb-16">

        <div class="fixed inset-0 z-0 bg-grid-pattern opacity-50"></div>
        <div
            class="fixed top-[-5%] right-[-5%] w-[600px] h-[600px] bg-red-50/30 rounded-full blur-[130px] z-0 pointer-events-none">
        </div>

        <div class="relative z-10">
            <div class="bg-white/70 backdrop-blur-md border-b border-gray-100">
                <div
                    class="max-w-7xl mx-auto py-8 px-4 sm:px-6 lg:px-8 flex flex-col md:flex-row md:items-center md:justify-between gap-5">
                    <div>
                        <span
                            class="text-[9px] font-bold text-red-600 uppercase tracking-[0.2em] block mb-1 font-tegas">Sistem
                            Hak Akses Utama</span>
                        <h2 class="text-2xl font-bold text-gray-950 font-tegas leading-none">
                            Dashboard Pimpinan
                        </h2>
                        <p class="text-xs text-gray-400 mt-1.5 font-light">Selamat datang kembali, Bapak/Ibu Pimpinan.
                            Manajemen otentikasi ekosistem PT Seagma.</p>
                    </div>



                    <div class="flex flex-wrap gap-3">

                        <a href="{{ route('pimpinan.validasi.teknisi') }}"
                            class="inline-flex items-center justify-center px-5 py-2.5 bg-gray-950 hover:bg-red-600 text-white text-xs font-bold uppercase tracking-widest rounded-full shadow-lg transition-all duration-300 transform hover:-translate-y-0.5">
                            Validasi Teknisi
                        </a>
                        <a href="{{ route('pimpinan.pengaturan') }}"
                            class="inline-flex items-center justify-center px-5 py-2.5 bg-white/80 border border-gray-200 text-gray-600 hover:text-gray-900 text-xs font-semibold uppercase tracking-widest rounded-full shadow-sm hover:shadow-md transition-all duration-300 backdrop-blur-sm">
                            <svg class="w-3.5 h-3.5 mr-1.5 text-gray-400" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                            </svg>
                            Sistem Pengaturan
                        </a>


                        <a href="{{ route('pimpinan.tiket.index') }}"
                            class="inline-flex items-center justify-center px-5 py-2.5 bg-gray-950 hover:bg-red-600 text-white text-xs font-bold uppercase tracking-widest rounded-full shadow-lg shadow-gray-900/10 hover:shadow-red-500/20 transition-all duration-300 transform hover:-translate-y-0.5">
                            Semua Berkas Tiket &rarr;
                        </a>
                    </div>
                </div>
            </div>

            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mt-10">

                @if (session('success'))
                    <div class="mb-8 bg-green-50/80 border border-green-100 rounded-2xl p-4 flex items-center gap-3">
                        <div class="text-green-500 shrink-0">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </div>
                        <span class="text-xs font-semibold text-gray-900">{{ session('success') }}</span>
                    </div>
                @endif

                <div class="grid grid-cols-1 sm:grid-cols-3 gap-6 mb-10 relative z-20">
                    <div
                        class="bg-white rounded-[2rem] p-6 shadow-xl shadow-gray-200/20 border border-gray-100/50 flex items-center justify-between transition-transform hover:-translate-y-1 duration-300">
                        <div>
                            <p class="text-[10px] font-bold text-gray-400 uppercase tracking-widest">Total Akun
                                Pelanggan</p>
                            <p class="text-4xl font-extrabold text-gray-900 font-tegas mt-1">{{ $totalPelanggan }}</p>
                        </div>
                        <div
                            class="w-12 h-12 rounded-2xl bg-gray-50 flex items-center justify-center text-gray-400 border border-gray-100 shadow-inner">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                            </svg>
                        </div>
                    </div>

                    <div
                        class="bg-white rounded-[2rem] p-6 shadow-xl shadow-gray-200/20 border border-gray-100/50 flex items-center justify-between transition-transform hover:-translate-y-1 duration-300">
                        <div>
                            <p class="text-[10px] font-bold text-gray-400 uppercase tracking-widest">Data Teknisi
                            </p>
                            <p class="text-4xl font-extrabold text-gray-900 font-tegas mt-1">{{ $totalTeknisi }}</p>
                        </div>
                        <div
                            class="w-12 h-12 rounded-2xl bg-gray-50 flex items-center justify-center text-gray-400 border border-gray-100 shadow-inner">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                            </svg>
                        </div>
                    </div>

                    <div
                        class="bg-white rounded-[2rem] p-6 shadow-xl shadow-gray-200/20 border border-gray-100/50 flex items-center justify-between transition-transform hover:-translate-y-1 duration-300">
                        <div>
                            <p class="text-[10px] font-bold text-gray-400 uppercase tracking-widest">Staf Operator Admin
                            </p>
                            <p class="text-4xl font-extrabold text-gray-900 font-tegas mt-1">{{ $totalAdmin }}</p>
                        </div>
                        <div
                            class="w-12 h-12 rounded-2xl bg-gray-50 flex items-center justify-center text-gray-400 border border-gray-100 shadow-inner">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                            </svg>
                        </div>
                    </div>
                </div>

                {{-- <div
                    class="bg-white rounded-[2rem] shadow-2xl shadow-gray-200/20 border border-gray-100 overflow-hidden relative z-10">
                    <div
                        class="px-8 py-6 border-b border-gray-50 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 bg-gray-50/20">
                        <h3 class="text-sm font-bold uppercase tracking-wider text-gray-800 font-tegas">Daftar Pengguna
                            Sistem</h3>

                        <a href="{{ route('pimpinan.users.create') }}"
                            class="inline-flex items-center justify-center px-5 py-2.5 bg-gray-950 hover:bg-red-600 text-white text-xs font-bold uppercase tracking-widest rounded-full transition-all duration-300 shadow-lg shadow-gray-900/10 hover:shadow-red-500/20 transform hover:-translate-y-0.5">
                            <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z" />
                            </svg>
                            Registrasi Pengguna baru
                        </a>
                    </div>

                    <div class="overflow-x-auto">
                        <table class="w-full text-left">
                            <thead>
                                <tr
                                    class="text-[10px] text-gray-400 uppercase tracking-[0.15em] bg-gray-50/50 border-b border-gray-50">
                                    <th class="px-8 py-4 font-bold">Nama Lengkap</th>
                                    <th class="px-8 py-4 font-bold">Korespondensi Email</th>
                                    <th class="px-8 py-4 font-bold">Otoritas Otorisasi</th>
                                    <th class="px-8 py-4 font-bold text-center w-36">Tindakan Kelola</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-50">
                                @foreach ($users as $user)
                                    <tr class="group hover:bg-gray-50/40 transition-all duration-200">
                                        <td class="px-8 py-4">
                                            <p
                                                class="text-sm font-bold text-gray-900 uppercase tracking-wide font-tegas">
                                                {{ $user->name }}</p>
                                        </td>

                                        <td class="px-8 py-4 text-xs font-mono text-gray-500 font-medium">
                                            {{ $user->email }}
                                        </td>

                                        <td class="px-8 py-4">
                                            <span
                                                class="px-3 py-1 rounded-full text-[9px] font-bold uppercase tracking-wider ring-1 inline-block
                                            @if ($user->role === 'pimpinan') bg-red-50 text-red-600 ring-red-100
                                            @elseif($user->role === 'admin') bg-purple-50 text-purple-600 ring-purple-100
                                            @elseif($user->role === 'teknisi') bg-green-50 text-green-600 ring-green-100
                                            @else bg-gray-50 text-gray-600 ring-gray-100 @endif">
                                                {{ $user->role }}
                                            </span>
                                        </td>

                                        <td class="px-8 py-4">
                                            <div class="flex items-center justify-center space-x-4">

                                                <a href="{{ route('pimpinan.users.edit', $user->id) }}"
                                                    class="text-[10px] font-bold text-gray-400 hover:text-gray-900 uppercase tracking-wider transition-colors">
                                                    Edit
                                                </a>

                                                <form action="{{ route('pimpinan.users.destroy', $user->id) }}"
                                                    method="``POST"
                                                    onsubmit="return confirm('Apakah Anda yakin ingin menghapus pengguna ini secara permanen?')">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit"
                                                        class="text-[10px] font-bold text-red-400 hover:text-red-600 uppercase tracking-wider transition-colors">
                                                        Hapus
                                                    </button>
                                                </form>

                                                <!-- 🔽 TAMBAHKAN INI -->
                                                @if ($user->role === 'teknisi')
                                                    @if (!$user->is_approved)
                                                        <form
                                                            action="{{ route('pimpinan.users.approve', $user->id) }}"
                                                            method="POST">
                                                            @csrf
                                                            @method('PATCH')

                                                            <button type="submit"
                                                                class="relative z-50 px-3 py-1 bg-green-600 text-white text-xs font-bold uppercase rounded-md shadow">
                                                                VALIDASI
                                                            </button>
                                                        </form>
                                                    @else
                                                        <span class="text-green-500 text-[10px] font-bold uppercase">
                                                            Sudah Valid
                                                        </span>
                                                    @endif
                                                @endif

                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div> --}}

            </div>
        </div>
    </div>
</x-app-layout>
