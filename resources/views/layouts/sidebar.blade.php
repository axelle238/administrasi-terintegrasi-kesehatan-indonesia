<aside 
    class="flex flex-col w-[280px] h-screen bg-white border-r border-slate-200 hidden md:flex z-50 transition-all duration-300 shadow-[4px_0_24px_rgba(0,0,0,0.02)] relative flex-shrink-0"
    :class="sidebarOpen ? 'translate-x-0' : 'translate-x-0'"
>
    <!-- Branding -->
    <div class="h-[80px] flex items-center px-6 border-b border-slate-100 bg-white relative z-20">
        <a href="{{ route('dashboard') }}" class="flex items-center gap-3 group w-full">
            <div class="relative flex items-center justify-center w-12 h-12 bg-gradient-to-br from-blue-600 to-cyan-500 rounded-2xl shadow-lg shadow-blue-500/20 group-hover:scale-105 transition-transform duration-300">
                <svg class="w-7 h-7 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z" />
                </svg>
            </div>
            <div class="flex flex-col">
                <span class="text-2xl font-extrabold text-slate-800 tracking-tight font-[Outfit]">SATRIA</span>
                <span class="text-[10px] font-bold text-blue-600 uppercase tracking-[0.2em]">Enterprise</span>
            </div>
        </a>
    </div>

    <!-- Navigasi Desktop -->
    <div class="flex-1 overflow-y-auto px-4 py-6 space-y-1 custom-scrollbar">
        @include('layouts.sidebar-items')
    </div>

    <!-- Strip Profil Pengguna -->
    <div class="p-4 border-t border-slate-200 bg-slate-50">
        <div class="flex items-center gap-3">
            <div class="w-10 h-10 rounded-full bg-white flex items-center justify-center text-blue-600 font-bold text-sm shadow-md border border-slate-200">
                {{ substr(Auth::user()->name, 0, 1) }}
            </div>
            <div class="flex-1 min-w-0">
                <p class="text-sm font-bold text-slate-800 truncate">{{ Auth::user()->name }}</p>
                <p class="text-xs text-slate-500 truncate">{{ Auth::user()->role }}</p>
            </div>
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="text-slate-400 hover:text-red-500 transition-colors p-2 rounded-lg hover:bg-red-50" title="Keluar">
                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                    </svg>
                </button>
            </form>
        </div>
    </div>
</aside>

<!-- Mobile Overlay & Sidebar -->
<div x-show="sidebarOpen" @click="sidebarOpen = false" x-cloak class="fixed inset-0 z-40 bg-slate-900/50 backdrop-blur-sm md:hidden transition-opacity"></div>

<div x-show="sidebarOpen" 
     x-transition:enter="transition ease-in-out duration-300 transform" 
     x-transition:enter-start="-translate-x-full" 
     x-transition:enter-end="translate-x-0" 
     x-transition:leave="transition ease-in-out duration-300 transform" 
     x-transition:leave-start="translate-x-0" 
     x-transition:leave-end="-translate-x-full" 
     class="fixed inset-y-0 left-0 z-50 w-72 bg-white md:hidden overflow-y-auto shadow-2xl border-r border-slate-200 flex flex-col"
>
    <!-- Header Mobile -->
    <div class="h-[80px] flex items-center px-6 border-b border-slate-100 flex-shrink-0">
         <span class="text-xl font-extrabold text-slate-800 tracking-tight">SATRIA</span>
         <span class="ml-2 text-[10px] font-bold text-blue-600 uppercase tracking-[0.2em] mt-1">Mobile</span>
    </div>
    
    <!-- Navigasi Mobile -->
    <div class="flex-1 overflow-y-auto p-4 space-y-1">
         @include('layouts.sidebar-items')
    </div>
    
    <!-- User Strip Mobile -->
    <div class="p-4 border-t border-slate-200 bg-slate-50 flex-shrink-0">
        <div class="flex items-center gap-3">
             <div class="w-10 h-10 rounded-full bg-blue-100 flex items-center justify-center text-blue-600 font-bold text-sm">
                {{ substr(Auth::user()->name, 0, 1) }}
            </div>
            <div class="flex-1 min-w-0">
                <p class="text-sm font-bold text-slate-800 truncate">{{ Auth::user()->name }}</p>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="text-xs text-red-500 hover:text-red-700">Keluar Sistem</button>
                </form>
            </div>
        </div>
    </div>
</div>