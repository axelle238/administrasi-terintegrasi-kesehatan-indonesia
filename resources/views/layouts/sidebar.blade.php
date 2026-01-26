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

    <!-- Navigation -->
    <div class="flex-1 overflow-y-auto px-4 py-6 space-y-1 custom-scrollbar">
        
        <!-- Main -->
        <div class="mb-2 px-4 mt-2">
            <p class="text-[11px] font-bold text-slate-400 uppercase tracking-wider mb-2 font-[Outfit]">Utama</p>
        </div>
        
        <x-nav-link-sidebar :href="route('dashboard')" :active="request()->routeIs('dashboard')" icon="home" color="blue">
            Dashboard
        </x-nav-link-sidebar>

        <!-- Clinical / Medis -->
        @if(Auth::user()->role === 'admin' || in_array(Auth::user()->role, ['dokter', 'perawat', 'staf']))
            <div class="mt-8 mb-2 px-4">
                <p class="text-[11px] font-bold text-slate-400 uppercase tracking-wider mb-2 font-[Outfit]">Layanan Medis</p>
            </div>
            
            <x-nav-link-sidebar :href="route('antrean.index')" :active="request()->routeIs('antrean.*')" icon="ticket" color="cyan">
                Antrean & Triage
            </x-nav-link-sidebar>

            <x-nav-link-sidebar :href="route('pasien.index')" :active="request()->routeIs('pasien.*')" icon="users" color="cyan">
                Database Pasien
            </x-nav-link-sidebar>

            @if(Auth::user()->role === 'admin' || in_array(Auth::user()->role, ['dokter', 'perawat']))
                <x-nav-link-sidebar :href="route('rekam-medis.index')" :active="request()->routeIs('rekam-medis.*')" icon="clipboard-list" color="cyan">
                    Rekam Medis (EMR)
                </x-nav-link-sidebar>

                <x-nav-link-sidebar :href="route('rawat-inap.index')" :active="request()->routeIs('rawat-inap.index')" icon="office-building" color="cyan">
                    Rawat Inap
                </x-nav-link-sidebar>
                
                <x-nav-link-sidebar :href="route('rawat-inap.kamar')" :active="request()->routeIs('rawat-inap.kamar')" icon="view-grid" color="cyan">
                    Monitoring Bed
                </x-nav-link-sidebar>
            @endif
        @endif

        <!-- Pharmacy -->
        @if(Auth::user()->role === 'admin' || Auth::user()->role === 'apoteker')
            <div class="mt-8 mb-2 px-4">
                <p class="text-[11px] font-bold text-slate-400 uppercase tracking-wider mb-2 font-[Outfit]">Farmasi & Obat</p>
            </div>

            <x-nav-link-sidebar :href="route('apotek.index')" :active="request()->routeIs('apotek.*')" icon="beaker" color="emerald">
                Layanan Resep
            </x-nav-link-sidebar>

            <x-nav-link-sidebar :href="route('obat.index')" :active="request()->routeIs('obat.index') || request()->routeIs('obat.create') || request()->routeIs('obat.edit')" icon="cube" color="emerald">
                Inventory Obat
            </x-nav-link-sidebar>

            <x-nav-link-sidebar :href="route('obat.stock-opname')" :active="request()->routeIs('obat.stock-opname')" icon="refresh" color="emerald">
                Stock Opname
            </x-nav-link-sidebar>
        @endif

        <!-- Finance -->
        @if(Auth::user()->role === 'admin' || Auth::user()->role === 'staf')
            <div class="mt-8 mb-2 px-4">
                <p class="text-[11px] font-bold text-slate-400 uppercase tracking-wider mb-2 font-[Outfit]">Keuangan</p>
            </div>

            <x-nav-link-sidebar :href="route('kasir.index')" :active="request()->routeIs('kasir.*')" icon="credit-card" color="teal">
                Kasir & Billing
            </x-nav-link-sidebar>
        @endif

        <!-- HR & Admin -->
        @if(Auth::user()->role === 'admin')
            <div class="mt-8 mb-2 px-4">
                <p class="text-[11px] font-bold text-slate-400 uppercase tracking-wider mb-2 font-[Outfit]">Administrasi</p>
            </div>

            <x-nav-link-sidebar :href="route('pegawai.index')" :active="request()->routeIs('pegawai.*')" icon="identification" color="violet">
                Data Pegawai
            </x-nav-link-sidebar>

            <x-nav-link-sidebar :href="route('jadwal-jaga.index')" :active="request()->routeIs('jadwal-jaga.*')" icon="calendar" color="violet">
                Jadwal & Shift
            </x-nav-link-sidebar>

            <x-nav-link-sidebar :href="route('kepegawaian.gaji.index')" :active="request()->routeIs('kepegawaian.gaji.*')" icon="cash" color="violet">
                Payroll
            </x-nav-link-sidebar>
        @endif
        
        <!-- General Access -->
        <x-nav-link-sidebar :href="route('kepegawaian.cuti.index')" :active="request()->routeIs('kepegawaian.cuti.*')" icon="document-text" color="orange">
            Pengajuan Cuti
        </x-nav-link-sidebar>

        <!-- Assets -->
        @if(Auth::user()->role === 'admin' || Auth::user()->role === 'staf')
             <div class="mt-8 mb-2 px-4">
                <p class="text-[11px] font-bold text-slate-400 uppercase tracking-wider mb-2 font-[Outfit]">Inventaris</p>
            </div>

            <x-nav-link-sidebar :href="route('barang.dashboard')" :active="request()->routeIs('barang.dashboard')" icon="chart-bar" color="indigo">
                Dashboard Aset
            </x-nav-link-sidebar>

            <x-nav-link-sidebar :href="route('barang.index')" :active="request()->routeIs('barang.index')" icon="archive" color="indigo">
                Data Aset
            </x-nav-link-sidebar>
            
            <x-nav-link-sidebar :href="route('barang.maintenance')" :active="request()->routeIs('barang.maintenance')" icon="tool" color="indigo">
                Maintenance
            </x-nav-link-sidebar>
        @endif

        <!-- System -->
        @if(Auth::user()->role === 'admin')
            <div class="mt-8 mb-2 px-4">
                <p class="text-[11px] font-bold text-slate-400 uppercase tracking-wider mb-2 font-[Outfit]">System</p>
            </div>

            <x-nav-link-sidebar :href="route('system.user.index')" :active="request()->routeIs('system.user.*')" icon="shield-check" color="slate">
                User Management
            </x-nav-link-sidebar>

            <x-nav-link-sidebar :href="route('system.setting.index')" :active="request()->routeIs('system.setting.*')" icon="cog" color="slate">
                Settings
            </x-nav-link-sidebar>
        @endif
        
        <div class="pb-20"></div>

    </div>

    <!-- User Profile Strip -->
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
                <button type="submit" class="text-slate-400 hover:text-red-500 transition-colors p-2 rounded-lg hover:bg-red-50" title="Logout">
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
     class="fixed inset-y-0 left-0 z-50 w-72 bg-white md:hidden overflow-y-auto shadow-2xl border-r border-slate-200"
>
    <!-- Clone of Sidebar Content for Mobile -->
    <div class="h-[80px] flex items-center px-6 border-b border-slate-100">
         <span class="text-xl font-extrabold text-slate-800 tracking-tight">SATRIA</span>
         <span class="ml-2 text-[10px] font-bold text-blue-600 uppercase tracking-[0.2em] mt-1">Mobile</span>
    </div>
    <div class="p-4 space-y-1">
         <x-nav-link-sidebar :href="route('dashboard')" :active="request()->routeIs('dashboard')" icon="home" color="blue">Dashboard</x-nav-link-sidebar>
         <x-nav-link-sidebar :href="route('antrean.index')" :active="request()->routeIs('antrean.*')" icon="ticket" color="cyan">Antrean</x-nav-link-sidebar>
         <x-nav-link-sidebar :href="route('pasien.index')" :active="request()->routeIs('pasien.*')" icon="users" color="cyan">Pasien</x-nav-link-sidebar>
    </div>
</div>