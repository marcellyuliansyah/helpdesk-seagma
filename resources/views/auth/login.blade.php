<x-guest-layout>
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <div class="mb-6 border-b border-gray-200 pb-4">
        <h2 class="text-xl font-bold text-gray-800 font-tegas uppercase tracking-wide">Akses Masuk</h2>
        <p class="text-sm text-gray-500 mt-1">Silakan masukkan kredensial Anda</p>
    </div>

    <form method="POST" action="{{ route('login') }}">
        @csrf

        <div>
            <label for="email" class="block font-bold text-xs text-gray-700 uppercase tracking-wide">Alamat Email</label>
            <input id="email" class="block mt-2 w-full border-gray-300 focus:border-red-500 focus:ring-red-500 rounded-sm shadow-sm transition" type="email" name="email" value="{{ old('email') }}" required autofocus autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <div class="mt-5">
            <label for="password" class="block font-bold text-xs text-gray-700 uppercase tracking-wide">Kata Sandi</label>
            <input id="password" class="block mt-2 w-full border-gray-300 focus:border-red-500 focus:ring-red-500 rounded-sm shadow-sm transition"
                            type="password"
                            name="password"
                            required autocomplete="current-password" />
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <div class="block mt-5">
            <label for="remember_me" class="inline-flex items-center">
                <input id="remember_me" type="checkbox" class="rounded-sm border-gray-300 text-red-600 shadow-sm focus:ring-red-500" name="remember">
                <span class="ml-2 text-sm text-gray-600 font-medium">Ingat Sesi Saya</span>
            </label>
        </div>

        <div class="flex items-center justify-between mt-8">
            @if (Route::has('password.request'))
                <a class="underline text-sm text-gray-500 hover:text-red-600 transition" href="{{ route('password.request') }}">
                    Lupa sandi?
                </a>
            @endif

            <button type="submit" class="inline-flex items-center px-6 py-2.5 bg-red-600 border border-transparent rounded-sm font-bold text-xs text-white uppercase tracking-widest hover:bg-red-700 focus:bg-red-700 active:bg-red-800 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2 transition ease-in-out duration-150 shadow-sm">
                Masuk Sistem
            </button>
        </div>
    </form>
</x-guest-layout>