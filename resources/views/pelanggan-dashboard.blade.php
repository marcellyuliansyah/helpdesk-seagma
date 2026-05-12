<x-app-layout>
    <x-slot name="header">
        <h2 class="font-bold text-xl text-gray-800 leading-tight uppercase tracking-wide">
            {{ __('Dasbor Pelanggan') }}
        </h2>
    </x-slot>

    <div class="py-12 bg-gray-50 min-h-screen">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            @if(session('success'))
            <div class="mb-6 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded-sm relative shadow-sm" role="alert">
                <strong class="font-bold uppercase text-sm tracking-wide">Berhasil!</strong>
                <span class="block sm:inline text-sm ml-1">{{ session('success') }}</span>
            </div>
            @endif

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-sm border border-gray-200 mb-6">
                <div class="p-6 text-gray-900">
                    <h3 class="text-lg font-bold uppercase">Selamat Datang, {{ Auth::user()->name }}!</h3>
                    <p class="text-sm text-gray-600 mt-1">Portal Layanan Pengaduan Gangguan Jaringan Wi-Fi PT Semeru Agung Mandiri.</p>
                </div>
            </div>

            <div class="mb-8">
                <h4 class="font-bold text-gray-700 uppercase tracking-widest text-xs mb-4">Status Pengaduan Saat Ini</h4>

                @if($tiketAktif)
                <div class="bg-white border border-gray-200 rounded-sm shadow-sm overflow-hidden border-l-4 border-l-yellow-400">
                    <div class="p-6">
                        <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
                            <div>
                                <div class="flex items-center gap-2 mb-2">
                                    <span class="text-[10px] font-bold bg-yellow-100 text-yellow-800 px-2 py-1 rounded-sm uppercase tracking-wider">
                                        {{ $tiketAktif->status }}
                                    </span>
                                    <span class="text-xs text-gray-400 font-medium">No. Tiket: {{ $tiketAktif->nomor_tiket ?? $tiketAktif->id }}</span>
                                </div>
                                <h5 class="font-bold text-md text-gray-800 uppercase tracking-wide">{{ Str::limit($tiketAktif->deskripsi_keluhan ?? $tiketAktif->deskripsi, 60) }}</h5>
                            </div>
                            
                            @if($tiketAktif->status == 'menunggu verifikasi')
                            <div>
                                <form action="{{ route('pengaduan.destroy', $tiketAktif->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin membatalkan laporan gangguan ini?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="inline-flex items-center justify-center bg-white hover:bg-red-50 text-red-600 border border-red-200 font-bold py-2 px-4 rounded-sm text-xs uppercase tracking-wider transition shadow-sm whitespace-nowrap">
                                        Batalkan Laporan
                                    </button>
                                </form>
                            </div>
                            @endif
                            </div>
                    </div>
                    <div class="bg-gray-50 px-6 py-3 border-t border-gray-100 flex justify-between items-center">
                        <p class="text-[11px] text-gray-500 font-medium uppercase tracking-wider">
                            Catatan: Anda tidak dapat membuat laporan baru sampai proses perbaikan ini selesai.
                        </p>
                        <p class="text-[11px] text-gray-400 font-medium">
                            Dilaporkan: {{ $tiketAktif->created_at->format('d M Y, H:i') }}
                        </p>
                    </div>
                </div>

                @else
                <div class="bg-white p-6 rounded-sm shadow-sm border-l-4 border-l-red-600 border border-gray-200 flex flex-col md:flex-row justify-between items-center gap-4">
                    <div>
                        <p class="text-sm text-gray-600">
                            Saat ini Anda tidak memiliki tiket gangguan yang sedang aktif. Silakan buat laporan jika mengalami kendala.
                        </p>
                    </div>
                    <div>
                        <a href="{{ route('pengaduan.create') }}" class="inline-block bg-red-600 hover:bg-red-700 text-white font-bold py-3 px-6 rounded-sm shadow-sm transition uppercase text-sm tracking-wider whitespace-nowrap">
                            + Buat Tiket Gangguan
                        </a>
                    </div>
                </div>
                @endif
            </div>

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-sm border border-gray-200">
                <div class="p-6 border-b border-gray-200 bg-gray-50">
                    <h3 class="text-md font-bold uppercase tracking-wide text-gray-800">Arsip Laporan Selesai</h3>
                </div>
                <div class="p-0 overflow-x-auto">
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr class="bg-white border-b border-gray-200 text-xs text-gray-600 uppercase tracking-wider">
                                <th class="p-4 font-bold">No. Tiket</th>
                                <th class="p-4 font-bold">Tgl. Lapor</th>
                                <th class="p-4 font-bold">Keluhan</th>
                                <th class="p-4 font-bold text-center">Status</th>
                            </tr>
                        </thead>
                        <tbody class="text-sm text-gray-700">
                            @forelse($riwayatTiket as $riwayat)
                                <tr class="border-b border-gray-100 hover:bg-gray-50 transition">
                                    <td class="p-4 font-medium">{{ $riwayat->nomor_tiket }}</td>
                                    <td class="p-4">{{ $riwayat->created_at->format('d M Y') }}</td>
                                    <td class="p-4">{{ Str::limit($riwayat->deskripsi_keluhan, 40) }}</td>
                                    <td class="p-4 text-center">
                                        <span class="text-[10px] bg-green-100 text-green-800 px-2 py-1 rounded-sm uppercase font-bold">Selesai</span>
                                    </td>
                                </tr>
                            @empty
                                <tr class="border-b border-gray-100">
                                    <td class="p-4 text-center text-gray-500 py-8" colspan="4">
                                        Belum ada riwayat laporan yang diselesaikan.
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