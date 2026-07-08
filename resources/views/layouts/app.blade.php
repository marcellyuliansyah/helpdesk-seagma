<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ $title ?? config('app.name', 'Laravel') }}</title>

    <link rel="icon" type="image/png" href="{{ asset('images/logo-tab.png') }}">

    <link rel="icon" type="image/jpeg" href="{{ asset('images/QAzwEeco_400x400.jpg') }}">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        body {
            background-color: #ffffff;
        }

        [x-cloak] {
            display: none !important;
        }

        .bg-grid-pattern {
            background-image:
                linear-gradient(to right, #f8f9fa 1px, transparent 1px),
                linear-gradient(to bottom, #f8f9fa 1px, transparent 1px);

            background-size: 3rem 3rem;
        }
    </style>
</head>

<body class="font-sans antialiased relative">

    {{-- BACKGROUND --}}
    <div class="fixed inset-0 z-0 bg-grid-pattern overflow-hidden">

        <div class="absolute inset-0 bg-gradient-to-b from-transparent via-white/80 to-white"></div>

        {{-- MERAH --}}
        <div
            class="absolute -top-24 right-[-5%]
            w-[600px] h-[600px]
            rounded-full
            bg-gradient-to-bl
            from-red-300/40
            to-orange-200/20
            blur-[90px]">
        </div>

        {{-- ABU --}}
        <div
            class="absolute top-[10%] left-[-10%]
            w-[500px] h-[500px]
            rounded-full
            bg-gradient-to-tr
            from-gray-300/40
            to-red-100/30
            blur-[90px]">
        </div>

    </div>

    <div class="relative z-10 min-h-screen">

        @include('layouts.navigation')

        @if (isset($header))
            <header class="bg-white shadow">
                <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                    {{ $header }}
                </div>
            </header>
        @endif

        <main>
            {{ $slot }}
        </main>
    </div>
</body>

</html>