<nav x-data="{ open: false }" class="bg-white/70 backdrop-blur-md border-b border-gray-100/50 sticky top-0 z-50 transition-all duration-300">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-20">
            
            <div class="flex items-center">
                <div class="shrink-0 flex items-center gap-4">
                    <a href="{{ route('dashboard') }}" class="flex items-center gap-2.5 sm:gap-3 group">
                        <img src="{{ asset('images/logo.png') }}" alt="Logo" class="h-9 sm:h-10 w-auto object-contain drop-shadow-sm group-hover:scale-105 transition-transform duration-300">
                        <span class="text-sm sm:text-lg font-bold text-gray-900 tracking-tight font-tegas transition-colors duration-300">
                            PT SEMERU AGUNG MANDIRI
                        </span>
                    </a>
                </div>
            </div>

            <div class="hidden sm:flex sm:items-center sm:ms-6">
                <div class="relative" x-data="{ dropdownOpen: false }" @click.away="dropdownOpen = false">
                    <button @click="dropdownOpen = !dropdownOpen" class="inline-flex items-center px-4 py-2 border border-gray-100 rounded-xl text-xs font-semibold uppercase tracking-widest text-gray-600 bg-white/80 hover:bg-gray-50 hover:text-gray-900 hover:border-gray-300 shadow-sm transition-all duration-300 outline-none">
                        <div class="flex items-center gap-2">
                            <span class="w-1.5 h-1.5 rounded-full bg-green-500 inline-block animate-pulse"></span>
                            <span>{{ Auth::user()->name }}</span>
                        </div>

                        <div class="ms-2">
                            <svg class="fill-current h-4 w-4 text-gray-400 group-hover:text-gray-600 transition-colors" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                            </svg>
                        </div>
                    </button>

                    <div x-show="dropdownOpen" 
                         x-transition:enter="transition ease-out duration-200"
                         x-transition:enter-start="transform opacity-0 scale-95 -translate-y-2"
                         x-transition:enter-end="transform opacity-100 scale-100 translate-y-0"
                         x-transition:leave="transition ease-in duration-75"
                         x-transition:leave-start="transform opacity-100 scale-100 translate-y-0"
                         x-transition:leave-end="transform opacity-0 scale-95 -translate-y-2"
                         class="absolute right-0 mt-2 w-48 rounded-2xl bg-white/90 backdrop-blur-xl border border-gray-100 shadow-xl shadow-gray-200/50 py-2 z-50"
                         style="display: none;">
                        
                        <div class="px-4 py-2 text-[10px] font-bold text-gray-400 uppercase tracking-widest border-b border-gray-50 mb-1">
                            Manajemen Sesi
                        </div>

                        <a href="{{ route('profile.edit') }}" class="block px-4 py-2.5 text-xs font-medium text-gray-600 hover:bg-gray-50 hover:text-gray-900 transition-colors">
                            Pengaturan Profil
                        </a>

                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <a href="{{ route('logout') }}"
                               onclick="event.preventDefault(); this.closest('form').submit();"
                               class="block px-4 py-2.5 text-xs font-bold text-red-600 hover:bg-red-50 transition-colors">
                                Keluar Sistem
                            </a>
                        </form>
                    </div>
                </div>
            </div>

            <div class="-me-2 flex items-center sm:hidden">
                <button @click="open = ! open" class="inline-flex items-center justify-center p-2.5 rounded-xl text-gray-500 hover:text-gray-900 bg-gray-50/50 hover:bg-gray-100/80 border border-gray-100 focus:outline-none transition-all duration-200">
                    <svg class="h-5 w-5" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{'hidden': open, 'inline-flex': ! open }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{'hidden': ! open, 'inline-flex': open }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <div x-show="open"
         x-transition:enter="transition ease-out duration-200"
         x-transition:enter-start="opacity-0 -translate-y-4"
         x-transition:enter-end="opacity-100 translate-y-0"
         x-transition:leave="transition ease-in duration-150"
         x-transition:leave-start="opacity-100 translate-y-0"
         x-transition:leave-end="opacity-0 -translate-y-4"
         class="absolute top-full left-0 w-full bg-white/95 backdrop-blur-xl border-b border-gray-100 shadow-xl px-5 py-4 space-y-4 sm:hidden z-50"
         style="display: none;">
        
        <div class="pt-2 pb-3 border-b border-gray-50 flex items-center gap-3 px-2">
            <div class="relative shrink-0">
                <div class="w-9 h-9 rounded-xl bg-gray-950 flex items-center justify-center text-white text-xs font-bold uppercase tracking-wide font-tegas shadow-sm">
                    {{ Str::substr(Auth::user()->name, 0, 2) }}
                </div>
                <span class="absolute -bottom-0.5 -right-0.5 w-2.5 h-2.5 rounded-full bg-green-500 border-2 border-white animate-pulse"></span>
            </div>
            <div>
                <div class="text-xs font-bold text-gray-950 uppercase tracking-wide font-tegas">{{ Auth::user()->name }}</div>
                <div class="text-[10px] text-gray-400 font-mono mt-0.5">{{ Auth::user()->email }}</div>
            </div>
        </div>
        
        <div class="space-y-1.5">
            <a href="{{ route('profile.edit') }}" class="flex items-center px-4 py-3 rounded-xl text-xs font-semibold uppercase tracking-wider text-gray-600 bg-gray-50/50 hover:bg-gray-100/80 hover:text-gray-900 transition-all duration-200">
                <svg class="w-4 h-4 mr-2.5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                Pengaturan Profil
            </a>
            
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="w-full flex items-center px-4 py-3 rounded-xl text-xs font-bold uppercase tracking-wider text-red-600 bg-red-50/30 hover:bg-red-50 hover:text-red-700 transition-all duration-200 text-left">
                    <svg class="w-4 h-4 mr-2.5 text-red-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/></svg>
                    Keluar Sistem
                </button>
            </form>
        </div>
    </div>
</nav>