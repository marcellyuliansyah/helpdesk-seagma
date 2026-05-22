<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Masuk - Portal Helpdesk PT Seagma</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600&family=Poppins:wght@500;600;700&display=swap" rel="stylesheet">

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        body {
            font-family: 'Inter', sans-serif;
        }
        .font-tegas {
            font-family: 'Poppins', sans-serif;
        }
        .bg-grid-pattern {
            background-image: linear-gradient(to right, #f1f5f9 1px, transparent 1px), linear-gradient(to bottom, #f1f5f9 1px, transparent 1px);
            background-size: 3rem 3rem;
        }
    </style>
</head>
<body class="h-[100dvh] w-full overflow-hidden antialiased text-gray-800 bg-gray-50 flex items-center justify-center selection:bg-red-600 selection:text-white relative p-4">

    <div class="absolute inset-0 z-[-1] bg-grid-pattern">
        <div class="absolute inset-0 bg-gradient-to-b from-white/40 via-white/80 to-white"></div>
        
        <div class="absolute top-[-10%] right-[-5%] w-[500px] h-[500px] rounded-full bg-gradient-to-bl from-red-200/50 to-orange-100/30 blur-[90px] pointer-events-none"></div>
        <div class="absolute bottom-[-10%] left-[-5%] w-[500px] h-[500px] rounded-full bg-gradient-to-tr from-gray-200/60 to-blue-50/40 blur-[90px] pointer-events-none"></div>
    </div>

    <div class="w-full max-w-[420px] relative z-10">
        
        <div class="bg-white/70 backdrop-blur-2xl p-8 sm:p-10 shadow-2xl shadow-gray-200/50 rounded-[2rem] border border-white/80 ring-1 ring-gray-100/50 flex flex-col">
            
            <div class="text-center mb-8">
                <img class="mx-auto h-12 w-auto object-contain drop-shadow-sm mb-4" src="{{ asset('images/logo.png') }}" alt="Logo PT Seagma">
                <h2 class="text-xl font-bold tracking-tight text-gray-900 font-tegas leading-tight">
                    PT SEMERU AGUNG MANDIRI
                </h2>
                <p class="mt-1 text-[10px] font-bold tracking-[0.2em] text-red-600 uppercase">
                    Portal Helpdesk Resmi
                </p>
            </div>

            @if ($errors->any())
                <div class="mb-5 bg-red-50/80 border border-red-100 rounded-xl p-3 flex items-center gap-3">
                    <svg class="h-4 w-4 text-red-600 shrink-0" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.28 7.22a.75.75 0 00-1.06 1.06L8.94 10l-1.72 1.72a.75.75 0 101.06 1.06L10 11.06l1.72 1.72a.75.75 0 101.06-1.06L11.06 10l1.72-1.72a.75.75 0 00-1.06-1.06L10 8.94 8.28 7.22z" clip-rule="evenodd" />
                    </svg>
                    <p class="text-xs font-medium text-red-600">Email atau kata sandi tidak valid.</p>
                </div>
            @endif

            <form class="space-y-5" action="{{ route('login') }}" method="POST">
                @csrf

                <div>
                    <label for="email" class="sr-only">Alamat Email</label>
                    <input id="email" name="email" type="email" autocomplete="email" required value="{{ old('email') }}" placeholder="Alamat Email"
                        class="block w-full rounded-xl border-0 py-3 px-4 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-200 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-red-600 focus:bg-white bg-gray-50/50 sm:text-sm sm:leading-6 transition-all duration-300 outline-none">
                </div>

                <div>
                    <label for="password" class="sr-only">Kata Sandi</label>
                    <input id="password" name="password" type="password" autocomplete="current-password" required placeholder="Kata Sandi"
                        class="block w-full rounded-xl border-0 py-3 px-4 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-200 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-red-600 focus:bg-white bg-gray-50/50 sm:text-sm sm:leading-6 transition-all duration-300 outline-none">
                </div>

                <div class="flex items-center justify-between pt-1">
                    <div class="flex items-center">
                        <input id="remember" name="remember" type="checkbox" class="h-4 w-4 rounded border-gray-300 text-red-600 focus:ring-red-600 transition duration-200">
                        <label for="remember" class="ml-2 block text-xs text-gray-500 select-none">
                            Ingat saya
                        </label>
                    </div>

                    @if (Route::has('password.request'))
                        <a href="{{ route('password.request') }}" class="text-xs font-medium text-gray-500 hover:text-red-600 transition-colors duration-200">
                            Lupa sandi?
                        </a>
                    @endif
                </div>

                <div class="pt-3">
                    <button type="submit" class="flex w-full justify-center rounded-xl bg-gray-900 px-4 py-3.5 text-sm font-bold tracking-wide text-white shadow-md hover:bg-red-600 hover:shadow-lg hover:-translate-y-0.5 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-red-600 transition-all duration-300">
                        MASUK SISTEM
                    </button>
                </div>
            </form>
        </div>
    </div>

    <div class="absolute bottom-6 w-full text-center z-10">
        <p class="text-[10px] font-medium tracking-widest text-gray-400 uppercase">
            &copy; {{ date('Y') }} Sistem Informasi Manajemen
        </p>
    </div>

</body>
</html>