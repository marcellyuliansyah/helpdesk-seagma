<x-app-layout>
    <x-slot name="header">
        <h2 class="font-bold text-xl text-gray-800 leading-tight uppercase tracking-wide">
            {{ __('Panel Kendali Admin') }}
        </h2>
    </x-slot>

    <div class="py-12 bg-gray-50 min-h-screen">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-8">
                <div class="bg-white p-6 rounded-sm shadow-sm border border-gray-200">
                    <p class="text-xs font-bold text-gray-500 uppercase">Total Tiket</p>
                    <p class="text-2xl font-bold text-gray-800">{{ $stats['total'] }}</p>
                </div>
                <div class="bg-white p-6 rounded-sm shadow-sm border border-gray-200 border-l-4 border-l-yellow-400">
                    <p class="text-xs font-bold text-yellow-600 uppercase">Menunggu</p>
                    <p class="text-2xl font-bold text-gray-800">{{ $stats['pending'] }}</p>
                </div>
                <div class="bg-white p-6 rounded-sm shadow-sm border border-gray-200 border-l-4 border-l-blue-400">
                    <p class="text-xs font-bold text-blue-600 uppercase">Diproses</p>
                    <p class="text-2xl font-bold text-gray-800">{{ $stats['proses'] }}</p>
                </div>
                <div class="bg-white p-6 rounded-sm shadow-sm border border-gray-200 border-l-4 border-l-green-400">
                    <p class="text-xs font-bold text-green-600 uppercase">Selesai</p>
                    <p class="text-2xl font-bold text-gray-800">{{ $stats['selesai'] }}</p>
                </div>
            </div>

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-sm border border-gray-200">
                <div class="p-6 border-b border-gray-200 bg-gray-50 flex justify-between items-center">
                    <h3 class="text-md font-bold uppercase tracking-wide text-gray-800">Daftar Masuk Pengaduan</h3>
                </div>
                <div class="p-0 overflow-x-auto">
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr class="bg-white border-b border-gray-200 text-xs text-gray-600 uppercase tracking-wider">
                                <th class="p-4 font-bold">Teknisi</th>
                                <th class="p-4 font-bold">Pelanggan</th>
                                <th class="p-4 font-bold">Keluhan</th>
                                <th class="p-4 font-bold">Status</th>
                                <th class="p-4 font-bold">Tgl. Masuk</th>
                                <th class="p-4 font-bold text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="text-sm text-gray-700">
                            @forelse($semuaTiket as $tiket)
                                <tr class="border-b border-gray-100 hover:bg-gray-50 transition">
                                    <td class="p-4">
                                        <p class="font-bold text-gray-800">{{ $tiket->user->name ?? 'User Tidak Ditemukan' }}</p>
                                        <p class="text-[10px] text-gray-500 italic">{{ $tiket->nomor_tiket }}</p>
                                    </td>
                                    <td class="p-4">
                                        <p class="font-medium text-gray-700">{{ Str::limit($tiket->judul, 40) }}</p>
                                        <p class="text-xs text-gray-500">{{ Str::limit($tiket->deskripsi, 50) }}</p>
                                    </td>
                                    <td class="p-4">
                                        @if($tiket->status == 'menunggu verifikasi')
                                            <span class="text-[10px] bg-yellow-100 text-yellow-800 px-2 py-1 rounded-sm uppercase font-bold">Menunggu</span>
                                        @elseif($tiket->status == 'diproses')
                                            <span class="text-[10px] bg-blue-100 text-blue-800 px-2 py-1 rounded-sm uppercase font-bold">Diproses</span>
                                        @else
                                            <span class="text-[10px] bg-green-100 text-green-800 px-2 py-1 rounded-sm uppercase font-bold">Selesai</span>
                                        @endif
                                    </td>
                                    <td class="p-4 text-xs text-gray-500">
                                        {{ $tiket->created_at->format('d/m/Y H:i') }}
                                    </td>
                                    <td class="p-4 text-center">
                                        <a href="{{ route('admin.pengaduan.show', $tiket->id) }}" class="text-blue-600 hover:underline font-bold text-xs uppercase bg-blue-50 px-3 py-1 rounded-sm border border-blue-200">Lihat Detail</a>
                                    </td>
                                    <td class="p-4">
                                        @if($tiket->teknisi_id)
                                            <span class="text-xs font-bold text-blue-700">{{ $tiket->teknisi->name ?? 'Teknisi' }}</span>
                                        @else
                                            <span class="text-[10px] bg-gray-100 text-gray-500 px-2 py-1 rounded-sm uppercase font-bold">Belum Ada</span>
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="p-8 text-center text-gray-500">Belum ada pengaduan masuk.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

        </div>
    </div>
</x-app-layout>