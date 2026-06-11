<x-app-layout>

    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />

    <div class="max-w-7xl mx-auto p-6">

        <h2 class="text-2xl font-bold mb-6">
            Manajemen Pengguna
        </h2>

        @if (session('success'))
            <div class="bg-green-100 border border-green-300 text-green-800 p-3 rounded mb-4">
                {{ session('success') }}
            </div>
        @endif

        <div class="bg-white p-6 rounded-lg shadow mb-8">

            <form action="{{ route('admin.users.store') }}" method="POST">

                @csrf

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">

                    <input type="text" name="name" placeholder="Nama Lengkap" class="border rounded p-2" required>

                    <input type="email" name="email" placeholder="Email" class="border rounded p-2" required>

                    <input type="password" name="password" placeholder="Password" class="border rounded p-2" required>

                    <select id="role" name="role" class="border rounded p-2" required>

                        <option value="pelanggan">
                            Pelanggan
                        </option>

                        <option value="teknisi">
                            Teknisi
                        </option>

                    </select>

                    <input type="text" name="no_telepon" placeholder="No Telepon" class="border rounded p-2">

                    <div></div>

                    <div id="lokasi-pelanggan" class="md:col-span-2">

                        <label class="font-semibold block mb-2">
                            Alamat Lengkap
                        </label>

                        <input type="text" name="alamat_lengkap" placeholder="Alamat Lengkap"
                            class="border rounded p-2 w-full mb-4">

                        <label class="font-semibold block mb-2">
                            Pilih Lokasi Rumah Pelanggan
                        </label>

                        <div id="map" style="height:400px;width:100%;" class="rounded-lg border">
                        </div>

                        <div class="grid grid-cols-2 gap-3 mt-3">

                            <input type="text" id="latitude" name="latitude" readonly
                                class="border rounded p-2 bg-gray-100">

                            <input type="text" id="longitude" name="longitude" readonly
                                class="border rounded p-2 bg-gray-100">

                        </div>

                    </div>

                </div>

                <button type="submit" class="mt-5 bg-blue-600 hover:bg-blue-700 text-white px-5 py-2 rounded">

                    Tambah User

                </button>

            </form>

        </div>

        <div class="bg-white rounded-lg shadow">

            <table class="w-full">

                <thead>

                    <tr class="bg-gray-100">

                        <th class="p-3">Nama</th>
                        <th class="p-3">Email</th>
                        <th class="p-3">Role</th>
                        <th class="p-3">Aksi</th>

                    </tr>

                </thead>

                <tbody>

                    @foreach ($users as $user)
                        <tr class="border-t">

                            <td class="p-3">
                                {{ $user->name }}
                            </td>

                            <td class="p-3">
                                {{ $user->email }}
                            </td>

                            <td class="p-3">
                                {{ ucfirst($user->role) }}
                            </td>

                            <td class="p-3">

                                <form action="{{ route('admin.users.destroy', $user->id) }}" method="POST">

                                    @csrf
                                    @method('DELETE')

                                    <button type="submit" onclick="return confirm('Hapus user ini?')"
                                        class="bg-red-600 text-white px-3 py-1 rounded">

                                        Hapus

                                    </button>

                                </form>

                            </td>

                        </tr>
                    @endforeach

                </tbody>

            </table>

        </div>

    </div>

    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {

            const roleSelect = document.getElementById('role');
            const lokasiBox = document.getElementById('lokasi-pelanggan');

            function toggleLokasi() {

                if (roleSelect.value === 'pelanggan') {

                    lokasiBox.style.display = 'block';

                } else {

                    lokasiBox.style.display = 'none';

                }

            }

            toggleLokasi();

            roleSelect.addEventListener('change', toggleLokasi);
            
            let defaultLat = -8.1335;
            let defaultLng = 113.2248;

            const map = L.map('map').setView(
                [defaultLat, defaultLng],
                13
            );

            L.tileLayer(
                'https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                    attribution: '&copy; OpenStreetMap'
                }
            ).addTo(map);

            const marker = L.marker(
                [defaultLat, defaultLng], {
                    draggable: true
                }
            ).addTo(map);

            document.getElementById('latitude').value = defaultLat;
            document.getElementById('longitude').value = defaultLng;

            marker.on('dragend', function() {

                const pos = marker.getLatLng();

                document.getElementById('latitude').value = pos.lat;
                document.getElementById('longitude').value = pos.lng;

            });

            map.on('click', function(e) {

                marker.setLatLng(e.latlng);

                document.getElementById('latitude').value = e.latlng.lat;
                document.getElementById('longitude').value = e.latlng.lng;

            });

            setTimeout(function() {

                map.invalidateSize();

            }, 300);

        });
    </script>

</x-app-layout>
