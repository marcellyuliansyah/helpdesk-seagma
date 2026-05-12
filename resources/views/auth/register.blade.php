<x-guest-layout>
    <div class="mb-6 border-b border-gray-200 pb-4">
        <h2 class="text-xl font-bold text-gray-800 font-tegas uppercase tracking-wide">Registrasi Akun Baru</h2>
        <p class="text-sm text-gray-500 mt-1">Lengkapi data di bawah ini untuk mendaftar</p>
    </div>

    <form method="POST" action="{{ route('register') }}">
        @csrf

        <div>
            <label for="name" class="block font-bold text-xs text-gray-700 uppercase tracking-wide">Nama Lengkap</label>
            <input id="name" class="block mt-2 w-full border-gray-300 focus:border-red-500 focus:ring-red-500 rounded-sm shadow-sm transition" type="text" name="name" value="{{ old('name') }}" required autofocus autocomplete="name" />
            <x-input-error :messages="$errors->get('name')" class="mt-2" />
        </div>

        <div class="mt-5">
            <label for="email" class="block font-bold text-xs text-gray-700 uppercase tracking-wide">Alamat Email</label>
            <input id="email" class="block mt-2 w-full border-gray-300 focus:border-red-500 focus:ring-red-500 rounded-sm shadow-sm transition" type="email" name="email" value="{{ old('email') }}" required autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <div class="mt-5">
            <label for="password" class="block font-bold text-xs text-gray-700 uppercase tracking-wide">Kata Sandi</label>
            <input id="password" class="block mt-2 w-full border-gray-300 focus:border-red-500 focus:ring-red-500 rounded-sm shadow-sm transition"
                            type="password"
                            name="password"
                            required autocomplete="new-password" />
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <div class="mt-5">
            <label for="password_confirmation" class="block font-bold text-xs text-gray-700 uppercase tracking-wide">Konfirmasi Kata Sandi</label>
            <input id="password_confirmation" class="block mt-2 w-full border-gray-300 focus:border-red-500 focus:ring-red-500 rounded-sm shadow-sm transition"
                            type="password"
                            name="password_confirmation" required autocomplete="new-password" />
            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
        </div>

        <div class="flex items-center justify-between mt-8">
            <a class="underline text-sm text-gray-500 hover:text-red-600 transition" href="{{ route('login') }}">
                Sudah punya akun?
            </a>

            <button type="submit" class="inline-flex items-center px-6 py-2.5 bg-red-600 border border-transparent rounded-sm font-bold text-xs text-white uppercase tracking-widest hover:bg-red-700 focus:bg-red-700 active:bg-red-800 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2 transition ease-in-out duration-150 shadow-sm">
                Daftar
            </button>
        </div>
    </form>
</x-guest-layout>