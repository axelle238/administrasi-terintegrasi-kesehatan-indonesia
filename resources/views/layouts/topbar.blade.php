<header class="flex items-center justify-between px-8 py-5 bg-white/90 backdrop-blur-xl border-b border-dashed border-slate-200 sticky top-0 z-40 transition-all duration-300">
    <div class="flex items-center gap-4">
        <!-- Sidebar Toggle (Mobile) -->
        <button @click="sidebarOpen = !sidebarOpen" class="p-2 text-slate-500 focus:outline-none md:hidden hover:bg-slate-100 hover:text-primary-600 rounded-xl transition-all shadow-sm">
            <svg class="w-6 h-6" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M4 6H20M4 12H20M4 18H11" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
            </svg>
        </button>

        <!-- Judul Halaman -->
        <div class="hidden md:flex flex-col">
            <h1 class="text-xl font-black text-slate-800 tracking-tight leading-tight font-[Outfit]">
                @if(isset($header))
                    {{ $header }}
                @else
                    Ringkasan Eksekutif
                @endif
            </h1>
            <span class="text-[10px] font-bold text-slate-400 uppercase tracking-[0.15em] mt-0.5">Pusat Kendali Operasional</span>
        </div>
    </div>

    <div class="flex items-center gap-4 md:gap-6">
        <!-- Pencarian -->
        <div class="hidden lg:flex relative group">
            <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                <svg class="h-4 w-4 text-slate-400 group-hover:text-primary-500 transition-colors" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                </svg>
            </div>
            <input type="text" class="block w-72 pl-11 pr-4 py-2.5 border border-slate-200 rounded-xl leading-5 bg-slate-50/50 text-slate-700 placeholder-slate-400 focus:outline-none focus:bg-white focus:ring-2 focus:ring-primary-100 focus:border-primary-400 sm:text-sm transition-all shadow-sm hover:bg-white" placeholder="Cari data pasien, dokter...">
        </div>

        <div class="h-8 w-px bg-slate-200 mx-2 hidden md:block border-l border-dashed"></div>

        <!-- Tampilan Tanggal -->
        <div class="hidden md:flex flex-col text-right mr-2">
            <span class="text-[10px] font-black text-primary-600 uppercase tracking-widest">Hari Ini</span>
            <span class="text-xs font-bold text-slate-600">{{ \Carbon\Carbon::now()->translatedFormat('l, d M Y') }}</span>
        </div>

        <!-- Notifikasi -->
        <button class="relative p-2.5 rounded-xl text-slate-400 hover:bg-primary-50 hover:text-primary-600 focus:outline-none transition-all duration-300 group">
            <div class="absolute inset-0 bg-primary-50 rounded-xl scale-0 group-hover:scale-100 transition-transform"></div>
            <svg class="w-6 h-6 relative z-10" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" />
            </svg>
            <span class="absolute top-2.5 right-2.5 w-2 h-2 bg-red-500 rounded-full shadow ring-2 ring-white animate-pulse z-20"></span>
        </button>

        <!-- Dropdown Profil -->
        <div x-data="{ dropdownOpen: false }" class="relative">
            <button @click="dropdownOpen = ! dropdownOpen" class="flex items-center gap-3 p-1.5 pr-4 rounded-full hover:bg-white hover:shadow-lg hover:shadow-slate-200/50 transition-all border border-transparent hover:border-slate-100">
                <div class="w-10 h-10 overflow-hidden rounded-full shadow-md border-2 border-white bg-gradient-to-tr from-primary-500 to-cyan-400 flex items-center justify-center text-white font-black text-sm">
                    {{ substr(Auth::user()->name, 0, 1) }}
                </div>
                <div class="hidden md:flex flex-col items-start">
                    <span class="text-sm font-bold text-slate-700 leading-none">{{ Str::limit(Auth::user()->name, 15) }}</span>
                    <span class="text-[10px] text-primary-600 font-bold uppercase tracking-wide mt-1">{{ Auth::user()->role }}</span>
                </div>
                <svg class="hidden md:block w-3 h-3 text-slate-400 transition-transform duration-300" :class="{'rotate-180': dropdownOpen}" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" /></svg>
            </button>

            <!-- Backdrop -->
            <div x-show="dropdownOpen" @click="dropdownOpen = false" class="fixed inset-0 z-30 cursor-default" style="display: none;"></div>

            <!-- Menu -->
            <div x-show="dropdownOpen" x-transition:enter="transition ease-out duration-200" x-transition:enter-start="transform opacity-0 scale-95 translate-y-2" x-transition:enter-end="transform opacity-100 scale-100 translate-y-0" x-transition:leave="transition ease-in duration-150" x-transition:leave-start="transform opacity-100 scale-100 translate-y-0" x-transition:leave-end="transform opacity-0 scale-95 translate-y-2" class="absolute right-0 z-50 w-64 mt-3 origin-top-right bg-white rounded-2xl shadow-xl ring-1 ring-black/5 divide-y divide-slate-100 focus:outline-none overflow-hidden" style="display: none;">
                
                <!-- Header -->
                <div class="px-5 py-4 bg-slate-50/50">
                    <p class="text-sm font-bold text-slate-800">{{ Auth::user()->name }}</p>
                    <p class="text-xs text-slate-500 truncate mt-0.5">{{ Auth::user()->email }}</p>
                </div>

                <div class="p-2">
                    <a href="{{ route('profile.edit') }}" class="flex items-center gap-3 px-3 py-2.5 text-sm font-bold text-slate-600 rounded-xl hover:bg-primary-50 hover:text-primary-600 transition-colors group">
                        <svg class="w-4 h-4 text-slate-400 group-hover:text-primary-500 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" /></svg>
                        Profil & Akun
                    </a>
                    <a href="#" class="flex items-center gap-3 px-3 py-2.5 text-sm font-bold text-slate-600 rounded-xl hover:bg-primary-50 hover:text-primary-600 transition-colors group">
                        <svg class="w-4 h-4 text-slate-400 group-hover:text-primary-500 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                        Pengaturan
                    </a>
                </div>
                
                <div class="p-2 bg-slate-50/50 border-t border-dashed border-slate-100">
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="flex w-full items-center gap-3 px-3 py-2.5 text-sm font-bold text-red-600 rounded-xl hover:bg-red-50 text-left transition-colors group">
                            <svg class="w-4 h-4 text-red-400 group-hover:text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" /></svg>
                            Keluar Sistem
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</header>