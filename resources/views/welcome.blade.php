<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Helpdesk Portal - Mitra Resmi PT Telkom Indonesia</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600&family=Poppins:wght@500;600;700;800&display=swap" rel="stylesheet">

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        body {
            font-family: 'Inter', sans-serif;
            background-color: #ffffff;
        }
        .font-tegas {
            font-family: 'Poppins', sans-serif;
        }
        /* Efek garis grid yang lebih lembut */
        .bg-grid-pattern {
            background-image: linear-gradient(to right, #f8f9fa 1px, transparent 1px), linear-gradient(to bottom, #f8f9fa 1px, transparent 1px);
            background-size: 3rem 3rem;
        }
    </style>
</head>
<body class="antialiased text-gray-800 selection:bg-red-600 selection:text-white relative">

    <div class="absolute inset-x-0 top-0 z-[-1] h-[90vh] bg-grid-pattern overflow-hidden">
        <div class="absolute inset-0 bg-gradient-to-b from-transparent via-white/80 to-white"></div>
        
        <div class="absolute -top-24 right-[-5%] w-[600px] h-[600px] rounded-full bg-gradient-to-bl from-red-300/40 to-orange-200/20 blur-[90px] pointer-events-none"></div>
        
        <div class="absolute top-[10%] left-[-10%] w-[500px] h-[500px] rounded-full bg-gradient-to-tr from-gray-300/40 to-red-100/30 blur-[90px] pointer-events-none"></div>
    </div>

    <nav x-data="{ mobileMenuOpen: false }" class="bg-white/70 backdrop-blur-md border-b border-gray-100/50 sticky top-0 z-50 transition-all duration-300">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-20 items-center">
            
            <div class="flex items-center min-w-0 flex-1 sm:flex-none">
                <a href="#" class="flex items-center gap-2 sm:gap-3 group min-w-0">
                    <img src="{{ asset('images/logo.png') }}" alt="Logo" class="h-8 w-auto sm:h-10 object-contain drop-shadow-sm group-hover:scale-105 transition-transform duration-300 shrink-0">
                    
                    <div class="flex flex-col sm:flex-row sm:items-center sm:gap-2 min-w-0">
                        <span class="text-sm sm:text-base md:text-lg font-bold text-gray-900 tracking-tight font-tegas truncate">
                            PT. SEAGMA
                        </span>
                        <span class="hidden md:inline text-xs md:text-sm font-medium text-gray-400 border-l border-gray-200 pl-2 font-mono tracking-wider uppercase">
                            Mitra Telkom
                        </span>
                    </div>
                </a>
            </div>

            @if (Route::has('login'))
                <div class="hidden sm:flex sm:items-center sm:gap-4 shrink-0">
                    @auth
                        <a href="{{ url('/dashboard') }}" class="inline-flex items-center px-4 py-2 border border-gray-100 rounded-xl text-xs font-semibold uppercase tracking-widest text-gray-600 bg-white/80 hover:bg-gray-50 hover:text-gray-900 shadow-sm transition-all duration-300">
                            Dashboard
                        </a>
                    @else
                        <a href="{{ route('login') }}" class="text-xs font-semibold uppercase tracking-widest text-gray-600 hover:text-gray-900 transition-colors py-2 px-3">
                            Log in
                        </a>

                        {{-- @if (Route::has('register'))
                            <a href="{{ route('register') }}" class="inline-flex items-center px-5 py-2.5 bg-gray-950 hover:bg-red-600 text-white text-xs font-bold uppercase tracking-widest rounded-xl shadow-md transition-all duration-300 transform hover:-translate-y-0.5">
                                Register
                            </a>
                        @endif --}}
                    @endauth
                </div>
            @endif

            <div class="flex items-center sm:hidden shrink-0 ml-4">
                <button @click="mobileMenuOpen = !mobileMenuOpen" class="inline-flex items-center justify-center p-2.5 rounded-xl text-gray-500 hover:text-gray-900 bg-gray-50/80 border border-gray-100/80 focus:outline-none transition-all duration-200">
                    <svg class="h-5 w-5" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{'hidden': mobileMenuOpen, 'inline-flex': !mobileMenuOpen }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{'hidden': !mobileMenuOpen, 'inline-flex': mobileMenuOpen }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>

        </div>
    </div>

    <div x-show="mobileMenuOpen"
         x-transition:enter="transition ease-out duration-200"
         x-transition:enter-start="opacity-0 -translate-y-4"
         x-transition:enter-end="opacity-100 translate-y-0"
         x-transition:leave="transition ease-in duration-150"
         x-transition:leave-start="opacity-100 translate-y-0"
         x-transition:leave-end="opacity-0 -translate-y-4"
         class="absolute top-full left-0 w-full bg-white/95 backdrop-blur-xl border-b border-gray-100 shadow-2xl px-5 py-4 space-y-2 sm:hidden z-50"
         style="display: none;">
        
        @if (Route::has('login'))
            <div class="flex flex-col gap-2 pt-2">
                @auth
                    <a href="{{ url('/dashboard') }}" class="w-full text-center px-4 py-3 rounded-xl text-xs font-bold uppercase tracking-wider text-gray-700 bg-gray-50 hover:bg-gray-100 transition-all">
                        Masuk ke Dashboard
                    </a>
                @else
                    <a href="{{ route('login') }}" class="w-full text-center px-4 py-3 rounded-xl text-xs font-bold uppercase tracking-wider text-gray-600 bg-gray-50 hover:bg-gray-100 transition-all">
                        Log in
                    </a>

                    @if (Route::has('register'))
                        <a href="{{ route('register') }}" class="w-full text-center px-4 py-3 rounded-xl text-xs font-bold uppercase tracking-wider text-white bg-gray-950 hover:bg-red-600 transition-all">
                            Register Baru
                        </a>
                    @endif
                @endauth
            </div>
        @endif
    </nav>

    <main class="relative px-6 lg:px-8 flex flex-col items-center justify-start text-center pt-16 pb-10">
        <div class="mx-auto max-w-4xl pt-8 sm:pt-12">
            
            <div class="hidden sm:mb-8 sm:flex sm:justify-center">
                <div class="relative rounded-full px-4 py-1.5 text-sm leading-6 text-gray-600 ring-1 ring-gray-200/80 bg-white/60 backdrop-blur-sm hover:ring-red-600/30 hover:bg-red-50 transition-all duration-300 shadow-sm">
                    Portal Bantuan Teknis Resmi. <a href="{{ route('login') }}" class="font-semibold text-red-600"><span class="absolute inset-0" aria-hidden="true"></span>Akses sekarang <span aria-hidden="true">&rarr;</span></a>
                </div>
            </div>

            <h1 class="text-4xl tracking-tight font-extrabold text-gray-900 sm:text-6xl font-tegas leading-tight">
                Infrastruktur <span class="font-light text-gray-300">/</span> <br>
                <span class="text-transparent bg-clip-text bg-gradient-to-r from-gray-900 via-red-700 to-red-500">
                    Dukungan Teknis
                </span>
            </h1>
            
            <div class="mt-8 flex items-center justify-center gap-x-6">
                <a href="{{ route('login') }}" class="rounded-full bg-gray-900 px-8 py-3.5 text-sm font-semibold text-white shadow-md hover:bg-red-600 hover:shadow-lg hover:-translate-y-1 transition-all duration-300">
                    Buat Laporan Tiket
                </a>
                <a href="#layanan" class="text-sm font-semibold leading-6 text-gray-600 hover:text-red-600 transition-colors duration-200">
                    Pelajari Prosedur <span aria-hidden="true">↓</span>
                </a>
            </div>
        </div>
    </main>

    <div id="layanan" class="py-12 sm:py-16 relative z-10">
        <div class="max-w-7xl mx-auto px-6 lg:px-8">
            <div class="mx-auto max-w-2xl lg:text-center">
                <h2 class="text-xs font-bold leading-7 text-red-600 tracking-widest uppercase">Standar Operasional</h2>
                <p class="mt-1 text-2xl font-bold tracking-tight text-gray-900 sm:text-3xl font-tegas">Prioritas Penanganan</p>
            </div>

            <div class="mx-auto mt-10 max-w-2xl sm:mt-12 lg:max-w-none">
                <dl class="grid max-w-xl grid-cols-1 gap-x-8 gap-y-10 lg:max-w-none lg:grid-cols-3">
                    
                    <div class="flex flex-col items-start bg-white p-6 sm:p-8 rounded-3xl border border-gray-100 hover:border-red-100 hover:shadow-xl hover:shadow-red-500/5 transition-all duration-300 group shadow-sm">
                        <div class="rounded-2xl bg-gray-50 p-3 ring-1 ring-gray-100 group-hover:bg-red-50 group-hover:ring-red-100 transition-colors duration-300 mb-5">
                            <svg class="h-6 w-6 text-gray-700 group-hover:text-red-600 transition-colors" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 13.5l10.5-11.25L12 10.5h8.25L9.75 21.75 12 13.5H3.75z" />
                            </svg>
                        </div>
                        <dt class="text-lg font-semibold leading-7 text-gray-900 font-tegas">
                            Pelaporan Cepat
                        </dt>
                        <dd class="mt-2 flex flex-auto flex-col text-sm sm:text-base leading-7 text-gray-500 font-light">
                            <p class="flex-auto">Pembuatan tiket laporan gangguan secara sistematis untuk pencatatan dan respons waktu-nyata.</p>
                        </dd>
                    </div>

                    <div class="flex flex-col items-start bg-white p-6 sm:p-8 rounded-3xl border border-gray-100 hover:border-red-100 hover:shadow-xl hover:shadow-red-500/5 transition-all duration-300 group shadow-sm">
                        <div class="rounded-2xl bg-gray-50 p-3 ring-1 ring-gray-100 group-hover:bg-red-50 group-hover:ring-red-100 transition-colors duration-300 mb-5">
                            <svg class="h-6 w-6 text-gray-700 group-hover:text-red-600 transition-colors" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M15.042 21.672L13.684 16.6m0 0l-2.51 2.225.569-9.47 5.227 7.917-3.286-.672zm-7.518-.267A8.25 8.25 0 1120.25 10.5M8.288 14.212A5.25 5.25 0 1117.25 10.5" />
                            </svg>
                        </div>
                        <dt class="text-lg font-semibold leading-7 text-gray-900 font-tegas">
                            Pemantauan Status
                        </dt>
                        <dd class="mt-2 flex flex-auto flex-col text-sm sm:text-base leading-7 text-gray-500 font-light">
                            <p class="flex-auto">Lacak progres penanganan masalah secara transparan, mulai dari penerimaan laporan hingga resolusi akhir.</p>
                        </dd>
                    </div>

                    <div class="flex flex-col items-start bg-white p-6 sm:p-8 rounded-3xl border border-gray-100 hover:border-red-100 hover:shadow-xl hover:shadow-red-500/5 transition-all duration-300 group shadow-sm">
                        <div class="rounded-2xl bg-gray-50 p-3 ring-1 ring-gray-100 group-hover:bg-red-50 group-hover:ring-red-100 transition-colors duration-300 mb-5">
                            <svg class="h-6 w-6 text-gray-700 group-hover:text-red-600 transition-colors" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12c0 1.268-.63 2.39-1.593 3.068a3.745 3.745 0 01-1.043 3.296 3.745 3.745 0 01-3.296 1.043A3.745 3.745 0 0112 21c-1.268 0-2.39-.63-3.068-1.593a3.746 3.746 0 01-3.296-1.043 3.745 3.745 0 01-1.043-3.296A3.745 3.745 0 013 12c0-1.268.63-2.39 1.593-3.068a3.745 3.745 0 011.043-3.296 3.746 3.746 0 013.296-1.043A3.746 3.746 0 0112 3c1.268 0 2.39.63 3.068 1.593a3.746 3.746 0 013.296 1.043 3.746 3.746 0 011.043 3.296A3.745 3.745 0 0121 12z" />
                            </svg>
                        </div>
                        <dt class="text-lg font-semibold leading-7 text-gray-900 font-tegas">
                            Teknisi Sertifikasi
                        </dt>
                        <dd class="mt-2 flex flex-auto flex-col text-sm sm:text-base leading-7 text-gray-500 font-light">
                            <p class="flex-auto">Penugasan teknisi lapangan yang kompeten dan tersertifikasi untuk menjamin kualitas perbaikan infrastruktur.</p>
                        </dd>
                    </div>

                </dl>
            </div>
        </div>
    </div>

    <footer class="bg-white border-t border-gray-100 mt-4">
        <div class="max-w-7xl mx-auto py-8 px-6 md:flex md:items-center md:justify-between lg:px-8">
            <div class="flex justify-center md:order-2 space-x-6">
                <span class="text-xs font-medium tracking-widest text-gray-400 uppercase">Mitra Resmi PT Telkom Indonesia</span>
            </div>
            <div class="mt-4 md:order-1 md:mt-0">
                <p class="text-center text-xs leading-5 text-gray-500 font-light">
                    &copy; {{ date('Y') }} PT Semeru Agung Mandiri. All rights reserved.
                </p>
            </div>
        </div>
    </footer>

</body>
</html>