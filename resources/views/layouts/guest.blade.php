<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Helpdesk Portal') }} - Otentikasi</title>

        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&family=Roboto+Slab:wght@600;700;800&display=swap" rel="stylesheet">

        @vite(['resources/css/app.css', 'resources/js/app.js'])

        <style>
            body { font-family: 'Roboto', sans-serif; }
            .font-tegas { font-family: 'Roboto Slab', serif; }
        </style>
    </head>
    <body class="font-sans text-gray-900 antialiased bg-gray-100">
        <div class="min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0">
            <div class="text-center">
                <a href="/" class="flex flex-col items-center gap-2">
                    <img src="{{ asset('images/logo.png') }}" alt="Logo" class="h-16 w-auto object-contain">
                    <span class="text-2xl font-extrabold text-gray-800 font-tegas tracking-tight uppercase mt-2">PT Semeru Agung Mandiri</span>
                    <span class="text-xs font-bold text-red-600 tracking-widest uppercase">Portal Helpdesk Resmi</span>
                </a>
            </div>

            <div class="w-full sm:max-w-md mt-8 px-8 py-8 bg-white shadow-md border border-gray-200 rounded-sm overflow-hidden">
                {{ $slot }}
            </div>
            
            <div class="mt-8 text-center text-xs text-gray-400 font-bold uppercase tracking-widest">
                &copy; {{ date('Y') }} Sistem Informasi Manajemen
            </div>
        </div>
    </body>
</html>