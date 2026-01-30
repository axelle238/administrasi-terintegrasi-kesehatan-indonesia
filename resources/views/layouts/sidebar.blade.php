<aside 
    class="flex flex-col w-[280px] h-screen bg-white hidden md:flex z-50 transition-all duration-300 shadow-[4px_0_24px_rgba(0,0,0,0.02)] border-r border-dashed border-slate-200 relative flex-shrink-0 sticky top-0"
    :class="sidebarOpen ? 'translate-x-0' : 'translate-x-0'"
>
    <!-- Branding -->
    <div class="h-[90px] flex items-center px-8 border-b border-dashed border-slate-200 bg-white relative z-20">
        <a href="{{ route('dashboard') }}" class="flex items-center gap-4 group w-full">
            <div class="relative flex items-center justify-center w-10 h-10 bg-white border-2 border-blue-100 rounded-xl shadow-sm group-hover:border-blue-500 group-hover:shadow-blue-200 transition-all duration-300">
                <svg class="w-6 h-6 text-blue-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z" />
                </svg>
            </div>
            <div class="flex flex-col">
                <span class="text-xl font-black text-slate-800 tracking-tight font-[Outfit] leading-none">SATRIA</span>
                <span class="text-[10px] font-bold text-slate-400 uppercase tracking-[0.2em] mt-1">Health System</span>
            </div>
        </a>
    </div>

    <!-- Navigasi Desktop -->
    <div class="flex-1 overflow-y-auto px-5 py-8 space-y-1 custom-scrollbar">
        @include('layouts.sidebar-items')
    </div>

    <!-- Strip Profil Pengguna -->
    <div class="p-5 border-t border-dashed border-slate-200 bg-white">
        <div class="flex items-center gap-3 p-3 rounded-2xl border border-slate-100 bg-slate-50/50 hover:bg-white hover:shadow-lg hover:shadow-blue-500/5 hover:border-blue-100 transition-all duration-300 group">
            <div class="w-10 h-10 rounded-xl bg-white flex items-center justify-center text-blue-600 font-black text-sm shadow-sm border border-slate-100 group-hover:bg-blue-600 group-hover:text-white transition-colors">
                {{ substr(Auth::user()->name, 0, 1) }}
            </div>
            <div class="flex-1 min-w-0">
                <p class="text-sm font-bold text-slate-800 truncate group-hover:text-blue-700 transition-colors">{{ Auth::user()->name }}</p>
                <p class="text-[10px] font-bold text-slate-400 uppercase tracking-wider truncate">{{ Auth::user()->role }}</p>
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
     class="fixed inset-y-0 left-0 z-50 w-[280px] bg-white md:hidden overflow-y-auto shadow-2xl flex flex-col"
>
    <!-- Header Mobile -->
    <div class="h-[90px] flex items-center px-8 border-b border-dashed border-slate-200 flex-shrink-0">
         <span class="text-xl font-black text-slate-800 tracking-tight font-[Outfit]">SATRIA</span>
         <span class="ml-2 text-[10px] font-bold text-blue-600 uppercase tracking-[0.2em] mt-1">Mobile</span>
    </div>
    
    <!-- Navigasi Mobile -->
    <div class="flex-1 overflow-y-auto px-5 py-6 space-y-1">
         @include('layouts.sidebar-items')
    </div>
    
    <!-- User Strip Mobile -->
    <div class="p-5 border-t border-dashed border-slate-200 bg-slate-50 flex-shrink-0">
        <div class="flex items-center gap-3">
             <div class="w-10 h-10 rounded-xl bg-blue-100 flex items-center justify-center text-blue-600 font-bold text-sm">
                {{ substr(Auth::user()->name, 0, 1) }}
            </div>
            <div class="flex-1 min-w-0">
                <p class="text-sm font-bold text-slate-800 truncate">{{ Auth::user()->name }}</p>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="text-xs font-bold text-red-500 hover:text-red-700 uppercase tracking-wider mt-1">Keluar Sistem</button>
                </form>
            </div>
        </div>
    </div>
</div>