<x-app-layout>
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap');
        .font-jakarta { font-family: 'Plus Jakarta Sans', sans-serif; }
    </style>
    
    <div class="relative min-h-screen bg-[#fafbfc] font-jakarta overflow-hidden pb-12">
        <div class="absolute inset-0 z-0 bg-[linear-gradient(to_right,#8080800f_1px,transparent_1px),linear-gradient(to_bottom,#8080800f_1px,transparent_1px)] bg-[size:32px_32px]"></div>

        <div x-data="{ openModal: false }" class="relative z-10 max-w-7xl mx-auto p-4 sm:p-6 lg:p-8">

            @if (session('success'))
                <div class="rounded-2xl bg-emerald-50 p-4 mb-6 border border-emerald-100 shadow-sm">
                    <div class="flex items-center">
                        <div class="flex-shrink-0">
                            <svg class="h-5 w-5 text-emerald-500" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.857-9.809a.75.75 0 00-1.214-.882l-3.483 4.79-1.88-1.88a.75.75 0 10-1.06 1.061l2.5 2.5a.75.75 0 001.137-.089l4-5.5z" clip-rule="evenodd" />
                            </svg>
                        </div>
                        <div class="ml-3">
                            <p class="text-sm font-semibold text-emerald-800">{{ session('success') }}</p>
                        </div>
                    </div>
                </div>
            @endif

            <div class="mb-8">
                <a href="javascript:history.back()" class="inline-flex items-center text-sm font-bold text-gray-500 hover:text-gray-800 transition-colors group">
                    <div class="p-2 rounded-full bg-white shadow-sm ring-1 ring-gray-200 mr-2 group-hover:bg-gray-50 group-hover:ring-gray-300 transition-all">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                        </svg>
                    </div>
                    Kembali
                </a>
            </div>

            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between mb-10 gap-4">
                <div class="flex items-center gap-5">
                    <div class="flex h-16 w-16 items-center justify-center rounded-full bg-[#ef233c] text-white shadow-lg shadow-red-200/60 border-[3px] border-white">
                        <svg class="h-7 w-7" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15 19.128a9.38 9.38 0 002.625.372 9.337 9.337 0 004.121-.952 4.125 4.125 0 00-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.106A12.318 12.318 0 018.624 21c-2.331 0-4.512-.645-6.374-1.766l-.001-.109a6.375 6.375 0 0111.964-3.07M12 6.375a3.375 3.375 0 11-6.75 0 3.375 3.375 0 016.75 0zm8.25 2.25a2.625 2.625 0 11-5.25 0 2.625 2.625 0 015.25 0z" />
                        </svg>
                    </div>
                    <div>
                        <h2 class="text-[1.75rem] font-extrabold text-[#111827] tracking-tight leading-tight">
                            Manajemen Pengguna
                        </h2>
                        <p class="text-[0.95rem] font-medium text-gray-500 mt-1">Kelola daftar pelanggan dan teknisi di sistem Anda.</p>
                    </div>
                </div>
                
                <div class="flex-none">
                    <button @click="openModal = true; setTimeout(() => { window.dispatchEvent(new Event('resize')); }, 300)" 
                            class="flex items-center gap-2 rounded-full bg-[#ef233c] px-7 py-3 text-[13px] font-bold text-white shadow-lg shadow-red-200/50 hover:bg-[#d90429] hover:-translate-y-0.5 transition-all duration-200 uppercase tracking-wider">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M12 4v16m8-8H4"></path></svg>
                        Tambah Akun
                    </button>
                </div>
            </div>

            <div class="bg-white rounded-[2rem] shadow-sm border border-gray-100 overflow-hidden p-2 sm:p-4">
                <div class="overflow-x-auto rounded-[1.5rem]">
                    <table class="w-full text-left border-collapse min-w-max">
                        <thead>
                            <tr class="border-b-2 border-gray-100">
                                <th class="py-5 px-6 font-extrabold text-gray-400 uppercase tracking-wider text-[11px] w-20">ID</th>
                                <th class="py-5 px-6 font-extrabold text-gray-400 uppercase tracking-wider text-[11px] w-1/4">Nama</th>
                                <th class="py-5 px-6 font-extrabold text-gray-400 uppercase tracking-wider text-[11px] w-1/3">Email</th>
                                <th class="py-5 px-6 font-extrabold text-gray-400 uppercase tracking-wider text-[11px] w-32">Role</th>
                                <th class="py-5 px-6 font-extrabold text-gray-400 uppercase tracking-wider text-[11px] text-center w-32">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($users as $user)
                                <tr class="border-b border-gray-50 hover:bg-[#f8f9fa] transition-colors group">
                                    <td class="py-4 px-6 text-gray-400 font-bold text-[13px]">#{{ $user->id }}</td>
                                    <td class="py-4 px-6 text-[#111827] font-extrabold text-[15px]">{{ $user->name }}</td>
                                    <td class="py-4 px-6 text-gray-500 font-medium text-[14px]">{{ $user->email }}</td>
                                    <td class="py-4 px-6">
                                        @php
                                            $role = strtolower($user->role);
                                        @endphp

                                        @if($role == 'teknisi')
                                            <span class="inline-flex items-center rounded-full bg-[#334155] px-4 py-1.5 text-[11px] font-extrabold text-white tracking-widest uppercase shadow-sm">Teknisi</span>
                                        @elseif($role == 'admin')
                                            <span class="inline-flex items-center rounded-full bg-red-500 px-4 py-1.5 text-[11px] font-extrabold text-white tracking-widest uppercase shadow-sm">Admin</span>
                                        @elseif($role == 'pimpinan')
                                            <span class="inline-flex items-center rounded-full bg-blue-500 px-4 py-1.5 text-[11px] font-extrabold text-white tracking-widest uppercase shadow-sm">Pimpinan</span>
                                        @else
                                            <span class="inline-flex items-center rounded-full bg-[#10b981] px-4 py-1.5 text-[11px] font-extrabold text-white tracking-widest uppercase shadow-sm">Pelanggan</span>
                                        @endif
                                    </td>
                                    <td class="py-4 px-6 text-center">
                                        <form action="{{ route('admin.users.destroy', $user->id) }}" method="POST" class="inline-block m-0">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" onclick="return confirm('Apakah Anda yakin ingin menghapus user ini?')"
                                                class="inline-flex items-center justify-center rounded-full bg-red-50 text-red-600 hover:bg-[#ef233c] hover:text-white px-5 py-2 text-[12px] font-bold transition-colors">
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

            <div x-show="openModal" class="relative z-50 font-jakarta" aria-labelledby="modal-title" role="dialog" aria-modal="true" x-cloak style="display: none;">
                <div x-show="openModal" x-transition:enter="ease-out duration-300" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100" x-transition:leave="ease-in duration-200" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0" class="fixed inset-0 bg-slate-900/40 backdrop-blur-sm transition-opacity"></div>
                <div class="fixed inset-0 z-10 w-screen overflow-y-auto">
                    <div class="flex min-h-full items-center justify-center p-4 text-center sm:p-0">
                        <div x-show="openModal" x-transition:enter="ease-out duration-300" x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95" x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100" x-transition:leave="ease-in duration-200" x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100" x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95" 
                             class="relative transform overflow-hidden rounded-[2rem] bg-white text-left shadow-2xl transition-all sm:my-8 sm:w-full sm:max-w-3xl border border-gray-100">
                            
                            <div class="bg-white px-6 pb-6 pt-8 sm:p-10">
                                <div class="flex justify-between items-center mb-8 pb-5 border-b-2 border-gray-50">
                                    <h3 class="text-2xl font-extrabold text-[#111827]" id="modal-title">Form Tambah Pengguna</h3>
                                    <button @click="openModal = false" class="text-gray-400 hover:text-red-500 hover:bg-red-50 rounded-full p-2.5 transition-colors">
                                        <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" /></svg>
                                    </button>
                                </div>

                                <form action="{{ route('admin.users.store') }}" method="POST">
                                    @csrf
                                    <div class="grid grid-cols-1 md:grid-cols-2 gap-x-6 gap-y-6">
                                        <div>
                                            <label class="block text-[13px] font-extrabold text-gray-700 uppercase tracking-wide">Nama Lengkap</label>
                                            <input type="text" name="name" class="mt-2 block w-full rounded-2xl border-0 py-3 px-4 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-200 focus:ring-2 focus:ring-inset focus:ring-[#ef233c] sm:text-sm font-medium transition-all bg-[#f8f9fa] hover:bg-white" required>
                                        </div>
                                        <div>
                                            <label class="block text-[13px] font-extrabold text-gray-700 uppercase tracking-wide">Email</label>
                                            <input type="email" name="email" class="mt-2 block w-full rounded-2xl border-0 py-3 px-4 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-200 focus:ring-2 focus:ring-inset focus:ring-[#ef233c] sm:text-sm font-medium transition-all bg-[#f8f9fa] hover:bg-white" required>
                                        </div>
                                        <div>
                                            <label class="block text-[13px] font-extrabold text-gray-700 uppercase tracking-wide">Password</label>
                                            <input type="password" name="password" class="mt-2 block w-full rounded-2xl border-0 py-3 px-4 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-200 focus:ring-2 focus:ring-inset focus:ring-[#ef233c] sm:text-sm font-medium transition-all bg-[#f8f9fa] hover:bg-white" required>
                                        </div>
                                        <div>
                                            <label class="block text-[13px] font-extrabold text-gray-700 uppercase tracking-wide">Peran (Role)</label>
                                            <select id="role" name="role" class="mt-2 block w-full rounded-2xl border-0 py-3 px-4 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-200 focus:ring-2 focus:ring-inset focus:ring-[#ef233c] sm:text-sm font-medium transition-all bg-[#f8f9fa] hover:bg-white" required>
                                                <option value="pelanggan">Pelanggan</option>
                                                <option value="teknisi">Teknisi</option>
                                            </select>
                                        </div>
                                        <div class="md:col-span-2">
                                            <label class="block text-[13px] font-extrabold text-gray-700 uppercase tracking-wide">No. Telepon</label>
                                            <input type="text" name="no_telepon" class="mt-2 block w-full rounded-2xl border-0 py-3 px-4 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-200 focus:ring-2 focus:ring-inset focus:ring-[#ef233c] sm:text-sm font-medium transition-all bg-[#f8f9fa] hover:bg-white">
                                        </div>
                                        
                                        <div id="lokasi-pelanggan" class="md:col-span-2 pt-2">
                                            <div class="rounded-3xl bg-[#f8f9fa] p-6 border border-gray-100">
                                                <h4 class="text-[15px] font-extrabold text-[#111827] mb-5 flex items-center gap-2">
                                                    <div class="bg-red-100 text-[#ef233c] p-2 rounded-xl">
                                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                                                    </div>
                                                    Informasi Lokasi Pelanggan
                                                </h4>
                                                
                                                <label class="block text-[12px] font-extrabold text-gray-600 uppercase tracking-wide mb-2">Alamat Lengkap</label>
                                                <input type="text" id="alamat_lengkap" name="alamat_lengkap" class="block w-full rounded-2xl border-0 py-3 px-4 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-200 focus:ring-2 focus:ring-inset focus:ring-[#ef233c] sm:text-sm font-medium mb-6 bg-white" placeholder="Tandai di peta untuk mengisi otomatis...">
                                                
                                                <label class="block text-[12px] font-extrabold text-gray-600 uppercase tracking-wide mb-3">Tandai Lokasi di Peta</label>
                                                <div id="map" style="height:260px;width:100%;" class="rounded-2xl ring-1 ring-gray-200 shadow-inner z-0 relative mb-5"></div>
                                                
                                                <div class="grid grid-cols-2 gap-5">
                                                    <div>
                                                        <label class="block text-[11px] font-extrabold text-gray-400 uppercase tracking-wider">Latitude</label>
                                                        <input type="text" id="latitude" name="latitude" readonly class="mt-1.5 block w-full rounded-xl border-0 py-2.5 px-3 bg-gray-200/50 text-gray-500 shadow-inner ring-1 ring-inset ring-gray-200 sm:text-sm font-bold cursor-not-allowed">
                                                    </div>
                                                    <div>
                                                        <label class="block text-[11px] font-extrabold text-gray-400 uppercase tracking-wider">Longitude</label>
                                                        <input type="text" id="longitude" name="longitude" readonly class="mt-1.5 block w-full rounded-xl border-0 py-2.5 px-3 bg-gray-200/50 text-gray-500 shadow-inner ring-1 ring-inset ring-gray-200 sm:text-sm font-bold cursor-not-allowed">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="mt-10 flex items-center justify-end gap-x-3">
                                        <button type="button" @click="openModal = false" class="text-[13px] font-bold text-gray-500 hover:text-gray-800 px-5 py-2.5 transition-colors uppercase tracking-wider">Batal</button>
                                        <button type="submit" class="rounded-full bg-[#111827] px-8 py-3 text-[13px] font-bold text-white shadow-lg hover:bg-gray-800 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 transition-all uppercase tracking-wider">Simpan Pengguna</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>

    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const roleSelect = document.getElementById('role');
            const lokasiBox = document.getElementById('lokasi-pelanggan');
            const alamatInput = document.getElementById('alamat_lengkap');
            let map, marker;
            
            function toggleLokasi() {
                if (roleSelect.value === 'pelanggan') {
                    lokasiBox.style.display = 'block';
                    setTimeout(() => { if (map) map.invalidateSize(); }, 100);
                } else {
                    lokasiBox.style.display = 'none';
                }
            }
            toggleLokasi();
            roleSelect.addEventListener('change', toggleLokasi);

            // Default coordinate set (e.g., Lumajang area)
            let defaultLat = -8.1335;
            let defaultLng = 113.2248;

            map = L.map('map').setView([defaultLat, defaultLng], 13);
            L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', { attribution: '&copy; OpenStreetMap' }).addTo(map);
            marker = L.marker([defaultLat, defaultLng], { draggable: true }).addTo(map);
            
            document.getElementById('latitude').value = defaultLat;
            document.getElementById('longitude').value = defaultLng;

            // Fungsi Reverse Geocoding menggunakan API Nominatim (Gratis OpenStreetMap)
            async function fetchAddress(lat, lng) {
                alamatInput.value = "Memuat alamat otomatis..."; 
                try {
                    // API Call ke Nominatim
                    const response = await fetch(`https://nominatim.openstreetmap.org/reverse?format=json&lat=${lat}&lon=${lng}`);
                    const data = await response.json();
                    
                    if (data && data.display_name) {
                        alamatInput.value = data.display_name; // Set response string ke input form
                    } else {
                        alamatInput.value = "Alamat tidak ditemukan.";
                    }
                } catch (error) {
                    console.error("Gagal mendapatkan alamat:", error);
                    alamatInput.value = "";
                }
            }

            // Saat marker selesai di-drag
            marker.on('dragend', function() {
                const pos = marker.getLatLng();
                document.getElementById('latitude').value = pos.lat.toFixed(6);
                document.getElementById('longitude').value = pos.lng.toFixed(6);
                fetchAddress(pos.lat, pos.lng); // Memanggil fetchAddress
            });

            // Saat peta diklik
            map.on('click', function(e) {
                marker.setLatLng(e.latlng);
                document.getElementById('latitude').value = e.latlng.lat.toFixed(6);
                document.getElementById('longitude').value = e.latlng.lng.toFixed(6);
                fetchAddress(e.latlng.lat, e.latlng.lng); // Memanggil fetchAddress
            });

            window.addEventListener('resize', function() {
                if(map) map.invalidateSize();
            });
        });
    </script>
</x-app-layout>