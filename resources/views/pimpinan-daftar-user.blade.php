<x-app-layout>

    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600&family=Poppins:wght@500;600;700&display=swap');

        body {
            font-family: 'Inter', sans-serif;
        }

        .font-tegas {
            font-family: 'Poppins', sans-serif;
        }

        .glass {
            backdrop-filter: blur(14px);
        }
    </style>

    <div class="min-h-screen bg-gradient-to-b from-white via-white to-slate-100 py-10">

        <div class="max-w-7xl mx-auto px-4">

            {{-- HEADER --}}
           {{-- HEADER --}}
<div
    class="bg-white rounded-[2rem] border border-gray-100 shadow-xl p-8 flex justify-between items-center mb-8">

    <div>

        <p class="text-[10px] uppercase tracking-[0.2em] text-red-600 font-bold">
            Manajemen Pengguna
        </p>

        <h1 class="text-3xl font-bold font-tegas text-gray-900 mt-2">
            {{ $judul }}
        </h1>

        <p class="text-sm text-gray-500 mt-1">
            Total Data:
            <span class="font-bold">
                {{ $users->count() }}
            </span>
        </p>

    </div>


    {{-- ACTION BUTTON --}}
    <div class="flex items-center gap-3">

        {{-- Tombol Tambah Admin (muncul hanya halaman admin) --}}
        @if(request()->role === 'admin')

            <a href="{{ route('pimpinan.users.create') }}"
                class="px-5 py-3 rounded-full bg-red-600 text-white text-xs uppercase font-bold hover:bg-red-700 transition flex items-center gap-2 shadow">

                <svg class="w-4 h-4"
                    fill="none"
                    stroke="currentColor"
                    viewBox="0 0 24 24">

                    <path stroke-linecap="round"
                        stroke-linejoin="round"
                        stroke-width="2"
                        d="M12 4v16m8-8H4"/>

                </svg>

                Tambah Admin

            </a>

        @endif


        {{-- Tombol kembali tetap ada --}}
        <a href="{{ route('pimpinan.dashboard') }}"
            class="px-5 py-3 rounded-full bg-gray-900 text-white text-xs uppercase font-bold hover:bg-red-600 transition">

            ← Kembali

        </a>

    </div>

</div>


            {{-- TABEL --}}
            <div class="bg-white rounded-[2rem] shadow-xl overflow-hidden">

                <div class="overflow-x-auto">

                    <table class="w-full">

                        <thead>
                            <tr class="bg-gray-50 text-[11px] uppercase tracking-[0.15em] text-gray-500">

                                <th class="p-6 text-left">
                                    Nama
                                </th>

                                <th class="p-6 text-left">
                                    Email
                                </th>

                                <th class="p-6 text-left">
                                    Role
                                </th>

                                {{-- STATUS hanya untuk teknisi --}}
                                @if (request()->role === 'teknisi')
                                    <th class="p-6 text-left">
                                        Status
                                    </th>
                                @endif

                                <th class="p-6 text-left">
                                    Dibuat
                                </th>

                            </tr>
                        </thead>

                        <tbody>

                            @forelse($users as $user)

                                <tr class="border-t hover:bg-gray-50 transition">

                                    {{-- NAMA --}}
                                    <td class="p-6">

                                        <div class="flex items-center gap-4">

                                            <div
                                                class="w-12 h-12 rounded-full bg-red-50 flex items-center justify-center font-bold text-red-600">

                                                {{ strtoupper(substr($user->name, 0, 1)) }}

                                            </div>

                                            <div>

                                                <p class="font-bold text-gray-900">
                                                    {{ $user->name }}
                                                </p>

                                                <p class="text-xs text-gray-400">
                                                    ID: {{ $user->id }}
                                                </p>

                                            </div>

                                        </div>

                                    </td>


                                    {{-- EMAIL --}}
                                    <td class="p-6 text-sm text-gray-600">
                                        {{ $user->email }}
                                    </td>


                                    {{-- ROLE --}}
                                    <td class="p-6">

                                        <span
                                            class="px-4 py-2 rounded-full text-xs font-bold

                                            @if ($user->role == 'admin') bg-purple-50 text-purple-600
                                            @elseif($user->role == 'teknisi')
                                                bg-green-50 text-green-600
                                            @else
                                                bg-blue-50 text-blue-600 @endif">

                                            {{ strtoupper($user->role) }}

                                        </span>

                                    </td>


                                    {{-- STATUS hanya teknisi --}}
                                    @if (request()->role === 'teknisi')
                                        <td class="p-6">

                                            @if ($user->is_approved)
                                                <span class="text-green-600 font-semibold">
                                                    Aktif
                                                </span>
                                            @else
                                                <span class="text-orange-500 font-semibold">
                                                    Menunggu Validasi
                                                </span>
                                            @endif

                                        </td>
                                    @endif


                                    {{-- CREATED --}}
                                    <td class="p-6 text-gray-500 text-sm">

                                        {{ $user->created_at->format('d M Y') }}

                                    </td>

                                </tr>

                            @empty

                                <tr>

                                    <td colspan="{{ request()->role === 'teknisi' ? 5 : 4 }}" class="p-14 text-center">

                                        <div>

                                            <div class="text-5xl mb-3">
                                                📂
                                            </div>

                                            <h3 class="font-bold text-gray-700">
                                                Tidak ada data
                                            </h3>

                                            <p class="text-sm text-gray-400">
                                                Belum ada pengguna untuk kategori ini.
                                            </p>

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

</x-app-layout>
