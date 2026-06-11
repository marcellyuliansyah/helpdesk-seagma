<x-app-layout>

    <div class="min-h-screen bg-gray-50 py-10">

        <div class="max-w-6xl mx-auto px-6">

            <div class="mb-6">
                <h1 class="text-2xl font-bold text-gray-900">
                    Validasi Akun Teknisi
                </h1>
                <p class="text-sm text-gray-500">
                    Daftar teknisi yang perlu disetujui oleh pimpinan
                </p>
            </div>

            <div class="bg-white rounded-2xl shadow border overflow-hidden">

                <table class="w-full text-left">
                    <thead class="bg-gray-50 text-xs uppercase text-gray-500">
                        <tr>
                            <th class="px-6 py-4">Nama</th>
                            <th class="px-6 py-4">Email</th>
                            <th class="px-6 py-4 text-center">Status</th>
                            <th class="px-6 py-4 text-center">Aksi</th>
                        </tr>
                    </thead>

                    <tbody class="divide-y">
                        @foreach ($teknisi as $user)
                            <tr>

                                <td class="px-6 py-4 font-semibold text-gray-900">
                                    {{ $user->name }}
                                </td>

                                <td class="px-6 py-4 text-sm text-gray-600">
                                    {{ $user->email }}
                                </td>

                                <td class="px-6 py-4 text-center">
                                    @if ($user->is_approved)
                                        <span class="text-green-600 font-bold text-xs uppercase">
                                            Sudah Valid
                                        </span>
                                    @else
                                        <span class="text-red-500 font-bold text-xs uppercase">
                                            Belum Valid
                                        </span>
                                    @endif
                                </td>

                                <td class="px-6 py-4 text-center">

                                    @if (!$user->is_approved)
                                        <form action="{{ route('pimpinan.users.approve', $user->id) }}" method="POST">
                                            @csrf
                                            @method('PATCH')

                                            <button type="submit"
                                                class="text-green-600 font-bold text-xs uppercase hover:text-green-800">
                                                Validasi
                                            </button>
                                        </form>
                                    @else
                                        <span class="text-gray-400 text-xs">-</span>
                                    @endif

                                </td>

                            </tr>
                        @endforeach
                    </tbody>

                </table>

            </div>

        </div>

    </div>

</x-app-layout>
