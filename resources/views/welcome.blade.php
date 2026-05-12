<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Helpdesk Portal - Mitra Resmi PT Telkom Indonesia</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&family=Roboto+Slab:wght@600;700;800&display=swap" rel="stylesheet">

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        /* Mengatur font default untuk seluruh halaman menjadi sangat formal */
        body {
            font-family: 'Roboto', sans-serif;
        }
        /* Mengatur font khusus yang tegas dan kokoh untuk nama perusahaan & judul */
        .font-tegas {
            font-family: 'Roboto Slab', serif;
        }
    </style>
</head>
<body class="antialiased bg-gray-50 text-gray-900">

    <nav class="bg-white border-b border-gray-200 sticky top-0 z-50 shadow-sm">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-20">
                <div class="flex items-center">
                    
                    <div class="flex-shrink-0 flex items-center gap-4">
                        <img src="{{ asset('images/logo.png') }}" alt="Logo Perusahaan" class="h-12 w-auto object-contain">
                        
                        <span class="text-2xl font-extrabold text-gray-800 font-tegas tracking-tight uppercase">
                            PT. SEAGMA
                        </span>
                        
                        <div class="w-px h-8 bg-gray-300 hidden sm:block"></div>
                        
                        <span class="text-2x1 font-bold text-red-600 tracking-wider uppercase hidden sm:block">
                            Mitra Resmi Telkom
                        </span>
                    </div>

                </div>

                <div class="flex items-center gap-3">
                    @if (Route::has('login'))
                        @auth
                            <a href="{{ url('/dashboard') }}" class="text-sm font-bold text-gray-700 hover:text-red-600 transition uppercase">Ke Dashboard</a>
                        @else
                            <a href="{{ route('login') }}" class="px-5 py-2.5 text-sm font-bold text-gray-700 bg-white border border-gray-300 rounded shadow-sm hover:bg-gray-50 hover:border-red-300 transition uppercase">Log in</a>
                            
                            @if (Route::has('register'))
                                <a href="{{ route('register') }}" class="px-5 py-2.5 text-sm font-bold text-white bg-red-600 rounded shadow-sm hover:bg-red-700 transition uppercase">Register</a>
                            @endif
                        @endauth
                    @endif
                </div>
            </div>
        </div>
    </nav>

    <div class="relative bg-white overflow-hidden border-b border-gray-200">
        <div class="max-w-7xl mx-auto">
            <div class="relative z-10 pb-8 bg-white sm:pb-16 md:pb-20 lg:max-w-2xl lg:w-full lg:pb-28 xl:pb-32 pt-10">
                
                <svg class="hidden lg:block absolute right-0 inset-y-0 h-full w-48 text-white transform translate-x-1/2" fill="currentColor" viewBox="0 0 100 100" preserveAspectRatio="none" aria-hidden="true">
                    <polygon points="50,0 100,0 100,100 0,100" />
                </svg>

                <main class="mt-10 mx-auto max-w-7xl px-4 sm:mt-12 sm:px-6 md:mt-16 lg:mt-20 lg:px-8 xl:mt-28">
                    <div class="sm:text-center lg:text-left">
                        <h1 class="text-4xl tracking-tight font-extrabold text-gray-900 sm:text-5xl md:text-6xl font-tegas uppercase">
                            <span class="block xl:inline">Infrastruktur &</span>
                            <span class="block text-red-600 xl:inline">Dukungan Teknis</span>
                        </h1>
                        <p class="mt-3 text-base text-gray-600 sm:mt-5 sm:text-lg sm:max-w-xl sm:mx-auto lg:mx-0 md:mt-5 md:text-xl leading-relaxed">
                            Portal Helpdesk Resmi untuk pelaporan gangguan dan koordinasi teknis. Kami berkomitmen menjaga keandalan jaringan secara profesional dan responsif.
                        </p>
                        <div class="mt-5 sm:mt-8 sm:flex sm:justify-center lg:justify-start">
                            <div class="rounded shadow-sm">
                                <a href="{{ route('login') }}" class="w-full flex items-center justify-center px-8 py-3 border border-transparent text-base font-bold rounded text-white bg-red-600 hover:bg-red-700 md:py-4 md:text-lg md:px-10 transition duration-200 uppercase tracking-wide">
                                    Akses Portal Bantuan
                                </a>
                            </div>
                        </div>
                    </div>
                </main>
            </div>
        </div>
        
        <div class="lg:absolute lg:inset-y-0 lg:right-0 lg:w-1/2">
            <img class="h-56 w-full object-cover sm:h-72 md:h-96 lg:w-full lg:h-full" src="https://images.unsplash.com/photo-1544197150-b99a580bb7a8?q=80&w=2070&auto=format&fit=crop" alt="Network Technology">
        </div>
    </div>

    <div class="py-16 bg-gray-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="lg:text-center">
                <h2 class="text-base text-red-600 font-bold tracking-widest uppercase">Layanan Teknis</h2>
                <p class="mt-2 text-3xl leading-8 font-extrabold tracking-tight text-gray-900 sm:text-4xl font-tegas uppercase">
                    Prioritas Penanganan
                </p>
                <p class="mt-4 max-w-2xl text-lg text-gray-600 lg:mx-auto">
                    Sistem pelaporan terpusat untuk memastikan setiap kendala tertangani dengan standar operasional prosedur yang ketat.
                </p>
            </div>

            <div class="mt-12">
                <dl class="space-y-10 md:space-y-0 md:grid md:grid-cols-3 md:gap-x-10 md:gap-y-12">
                    <div class="relative bg-white p-8 rounded shadow-sm border border-gray-200">
                        <dt>
                            <div class="absolute flex items-center justify-center h-14 w-14 rounded bg-red-600 text-white">
                                <svg class="h-7 w-7" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 5v2m0 4v2m0 4v2M5 5a2 2 0 00-2 2v3a2 2 0 110 4v3a2 2 0 002 2h14a2 2 0 002-2v-3a2 2 0 110-4V7a2 2 0 00-2-2H5z" /></svg>
                            </div>
                            <p class="ml-20 text-xl leading-6 font-bold text-gray-900 font-tegas">PELAPORAN CEPAT</p>
                        </dt>
                        <dd class="mt-4 ml-20 text-base text-gray-600 leading-relaxed">
                            Pembuatan tiket laporan gangguan secara sistematis untuk pencatatan dan respons yang lebih cepat.
                        </dd>
                    </div>

                    <div class="relative bg-white p-8 rounded shadow-sm border border-gray-200">
                        <dt>
                            <div class="absolute flex items-center justify-center h-14 w-14 rounded bg-red-600 text-white">
                                <svg class="h-7 w-7" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                            </div>
                            <p class="ml-20 text-xl leading-6 font-bold text-gray-900 font-tegas">PEMANTAUAN STATUS</p>
                        </dt>
                        <dd class="mt-4 ml-20 text-base text-gray-600 leading-relaxed">
                            Lacak progres penanganan masalah secara transparan, mulai dari penerimaan laporan hingga resolusi.
                        </dd>
                    </div>

                    <div class="relative bg-white p-8 rounded shadow-sm border border-gray-200">
                        <dt>
                            <div class="absolute flex items-center justify-center h-14 w-14 rounded bg-red-600 text-white">
                                <svg class="h-7 w-7" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" /></svg>
                            </div>
                            <p class="ml-20 text-xl leading-6 font-bold text-gray-900 font-tegas">TEKNISI SERTIFIKASI</p>
                        </dt>
                        <dd class="mt-4 ml-20 text-base text-gray-600 leading-relaxed">
                            Penugasan teknisi lapangan yang kompeten dan bersertifikasi untuk menjamin kualitas perbaikan.
                        </dd>
                    </div>
                </dl>
            </div>
        </div>
    </div>

    <footer class="bg-gray-900 text-gray-400">
        <div class="max-w-7xl mx-auto py-10 px-4 sm:px-6 lg:px-8 text-center border-t border-gray-800">
            <p class="text-sm tracking-wide font-bold uppercase">© {{ date('Y') }} PT Semeru Agung Mandiri</p>
            <p class="text-xs mt-2">Mitra Resmi PT Telkom Indonesia. All rights reserved.</p>
        </div>
    </footer>

</body>
</html>