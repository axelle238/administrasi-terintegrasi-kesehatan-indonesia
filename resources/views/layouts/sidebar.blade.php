<aside class="flex flex-col w-64 h-screen px-0 py-0 bg-gray-900 border-r border-gray-800 hidden md:flex z-50 transition-all duration-300 shadow-2xl relative overflow-hidden">
    <!-- Background Gradient & Effects -->
    <div class="absolute inset-0 z-0 opacity-20 bg-[radial-gradient(ellipse_at_top_right,_var(--tw-gradient-stops))] from-teal-500 via-transparent to-transparent pointer-events-none"></div>
    <div class="absolute bottom-0 left-0 w-full h-32 bg-gradient-to-t from-black to-transparent z-10 pointer-events-none"></div>

    <!-- Logo Section -->
    <div class="flex items-center justify-center h-20 border-b border-gray-800 z-20 relative bg-gray-900/50 backdrop-blur-sm">
        <a href="{{ route('dashboard') }}" class="flex items-center gap-3 group">
            <div class="relative flex items-center justify-center w-10 h-10 bg-gradient-to-br from-teal-500 to-emerald-600 rounded-xl shadow-lg shadow-teal-500/30 group-hover:shadow-teal-500/50 transition-all duration-300 transform group-hover:scale-105">
                <svg class="w-6 h-6 text-white" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12c0 1.268-.63 2.39-1.593 3.068a3.745 3.745 0 01-1.043 3.296 3.745 3.745 0 01-3.296 1.043A3.745 3.745 0 0112 21c-1.268 0-2.39-.63-3.068-1.593a3.746 3.746 0 01-3.296-1.043 3.745 3.745 0 01-1.043-3.296A3.745 3.745 0 013 12c0-1.268.63-2.39 1.593-3.068a3.745 3.745 0 011.043-3.296 3.746 3.746 0 013.296-1.043A3.746 3.746 0 0112 3c1.268 0 2.39.63 3.068 1.593a3.746 3.746 0 013.296 1.043 3.746 3.746 0 011.043 3.296A3.745 3.745 0 0121 12z" />
                </svg>
            </div>
            <div class="flex flex-col">
                <span class="text-2xl font-black text-white tracking-tighter leading-none font-sans">SATRIA</span>
                <span class="text-[0.6rem] font-bold text-teal-400 uppercase tracking-[0.2em] leading-tight">Enterprise</span>
            </div>
        </a>
    </div>

    <!-- Navigation Scroll Area -->
    <div class="flex flex-col flex-1 overflow-y-auto px-3 py-6 space-y-8 z-20 sidebar-scroll">
        
        <nav class="space-y-1.5">
            <x-nav-link-sidebar :href="route('dashboard')" :active="request()->routeIs('dashboard')" icon="home">
                Dashboard
            </x-nav-link-sidebar>

            {{-- PELAYANAN MEDIS --}}
            @if(Auth::user()->role === 'admin' || in_array(Auth::user()->role, ['dokter', 'perawat', 'staf']))
                <div class="mt-8 mb-3 px-3">
                    <p class="text-[10px] font-bold text-gray-500 uppercase tracking-widest border-b border-gray-800 pb-1">Medis & Pasien</p>
                </div>
                
                <x-nav-link-sidebar :href="route('antrean.index')" :active="request()->routeIs('antrean.*')" icon="ticket">
                    Antrean Pasien
                </x-nav-link-sidebar>

                <x-nav-link-sidebar :href="route('pasien.index')" :active="request()->routeIs('pasien.*')" icon="users">
                    Pendaftaran Pasien
                </x-nav-link-sidebar>

                @if(Auth::user()->role === 'admin' || in_array(Auth::user()->role, ['dokter', 'perawat']))
                    <x-nav-link-sidebar :href="route('rekam-medis.index')" :active="request()->routeIs('rekam-medis.*')" icon="clipboard">
                        Rekam Medis (RME)
                    </x-nav-link-sidebar>

                    <x-nav-link-sidebar :href="route('rawat-inap.index')" :active="request()->routeIs('rawat-inap.index')" icon="bed">
                        Rawat Inap
                    </x-nav-link-sidebar>
                    
                    <x-nav-link-sidebar :href="route('rawat-inap.kamar')" :active="request()->routeIs('rawat-inap.kamar')" icon="office-building">
                        Kamar & Bangsal
                    </x-nav-link-sidebar>
                @endif
            @endif

            {{-- FARMASI --}}
            @if(Auth::user()->role === 'admin' || Auth::user()->role === 'apoteker')
                <div class="mt-8 mb-3 px-3">
                    <p class="text-[10px] font-bold text-gray-500 uppercase tracking-widest border-b border-gray-800 pb-1">Farmasi</p>
                </div>

                <x-nav-link-sidebar :href="route('apotek.index')" :active="request()->routeIs('apotek.*')" icon="flask">
                    Layanan Resep
                </x-nav-link-sidebar>

                <x-nav-link-sidebar :href="route('obat.index')" :active="request()->routeIs('obat.index') || request()->routeIs('obat.create') || request()->routeIs('obat.edit')" icon="cube">
                    Data Obat
                </x-nav-link-sidebar>

                <x-nav-link-sidebar :href="route('obat.stock-opname')" :active="request()->routeIs('obat.stock-opname')" icon="refresh">
                    Stock Opname
                </x-nav-link-sidebar>
            @endif

            {{-- KEUANGAN --}}
            @if(Auth::user()->role === 'admin' || Auth::user()->role === 'staf')
                <div class="mt-8 mb-3 px-3">
                    <p class="text-[10px] font-bold text-gray-500 uppercase tracking-widest border-b border-gray-800 pb-1">Keuangan</p>
                </div>

                <x-nav-link-sidebar :href="route('kasir.index')" :active="request()->routeIs('kasir.*')" icon="cash">
                    Kasir & Billing
                </x-nav-link-sidebar>
            @endif

            {{-- MANAJEMEN SDM (HR) --}}
            @if(Auth::user()->role === 'admin')
                <div class="mt-8 mb-3 px-3">
                    <p class="text-[10px] font-bold text-gray-500 uppercase tracking-widest border-b border-gray-800 pb-1">Human Resource</p>
                </div>

                <x-nav-link-sidebar :href="route('pegawai.index')" :active="request()->routeIs('pegawai.*')" icon="id-card">
                    Data Pegawai
                </x-nav-link-sidebar>

                <x-nav-link-sidebar :href="route('jadwal-jaga.index')" :active="request()->routeIs('jadwal-jaga.*')" icon="calendar">
                    Jadwal Jaga
                </x-nav-link-sidebar>

                <x-nav-link-sidebar :href="route('shift.index')" :active="request()->routeIs('shift.*')" icon="clock">
                    Shift Kerja
                </x-nav-link-sidebar>

                <x-nav-link-sidebar :href="route('kepegawaian.gaji.index')" :active="request()->routeIs('kepegawaian.gaji.*')" icon="currency-dollar">
                    Penggajian
                </x-nav-link-sidebar>
            @endif

            {{-- CUTI --}}
            <x-nav-link-sidebar :href="route('kepegawaian.cuti.index')" :active="request()->routeIs('kepegawaian.cuti.*')" icon="document-text">
                Cuti & Izin
            </x-nav-link-sidebar>

            {{-- INVENTARIS --}}
            @if(Auth::user()->role === 'admin' || Auth::user()->role === 'staf')
                <div class="mt-8 mb-3 px-3">
                    <p class="text-[10px] font-bold text-gray-500 uppercase tracking-widest border-b border-gray-800 pb-1">Aset & Inventaris</p>
                </div>

                <x-nav-link-sidebar :href="route('barang.dashboard')" :active="request()->routeIs('barang.dashboard')" icon="chart-pie">
                    Dashboard Aset
                </x-nav-link-sidebar>

                <x-nav-link-sidebar :href="route('barang.index')" :active="request()->routeIs('barang.index') || request()->routeIs('barang.create') || request()->routeIs('barang.edit')" icon="archive">
                    Data Aset
                </x-nav-link-sidebar>

                <x-nav-link-sidebar :href="route('kategori-barang.index')" :active="request()->routeIs('kategori-barang.*')" icon="tag">
                    Kategori Aset
                </x-nav-link-sidebar>

                <x-nav-link-sidebar :href="route('ruangan.index')" :active="request()->routeIs('ruangan.index')" icon="office-building">
                    Data Ruangan
                </x-nav-link-sidebar>

                <x-nav-link-sidebar :href="route('supplier.index')" :active="request()->routeIs('supplier.index')" icon="truck">
                    Data Supplier
                </x-nav-link-sidebar>

                <x-nav-link-sidebar :href="route('barang.maintenance')" :active="request()->routeIs('barang.maintenance')" icon="tool">
                    Log Pemeliharaan
                </x-nav-link-sidebar>

                <x-nav-link-sidebar :href="route('barang.pengadaan.index')" :active="request()->routeIs('barang.pengadaan.*')" icon="shopping-cart">
                    Pengadaan
                </x-nav-link-sidebar>

                <x-nav-link-sidebar :href="route('barang.laporan')" :active="request()->routeIs('barang.laporan')" icon="document-report">
                    Laporan Inventaris
                </x-nav-link-sidebar>
            @endif

            {{-- SYSTEM INTERNAL --}}
            @if(Auth::user()->role === 'admin')
                <div class="mt-8 mb-3 px-3">
                    <p class="text-[10px] font-bold text-gray-500 uppercase tracking-widest border-b border-gray-800 pb-1">System</p>
                </div>

                <x-nav-link-sidebar :href="route('system.user.index')" :active="request()->routeIs('system.user.*')" icon="user-group">
                    Manajemen User
                </x-nav-link-sidebar>

                <x-nav-link-sidebar :href="route('system.setting.index')" :active="request()->routeIs('system.setting.*')" icon="cog">
                    Pengaturan
                </x-nav-link-sidebar>
            @endif
        </nav>

        <!-- Bottom User Section -->
        <div class="pt-4 border-t border-gray-800">
             <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="flex items-center w-full px-4 py-3 text-gray-400 transition-all duration-200 transform rounded-xl hover:bg-red-500/10 hover:text-red-500 group">
                    <svg class="w-5 h-5 group-hover:scale-110 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path></svg>
                    <span class="mx-3 font-medium text-sm">Sign Out</span>
                </button>
            </form>
        </div>
    </div>
</aside>

<!-- Mobile Sidebar Overlay -->
<div x-show="sidebarOpen" @click="sidebarOpen = false" x-cloak class="fixed inset-0 z-40 bg-gray-900/80 backdrop-blur-sm md:hidden transition-opacity"></div>

<!-- Mobile Sidebar (Cloned structure for simplicity) -->
<div x-show="sidebarOpen" x-transition:enter="transition ease-in-out duration-300 transform" x-transition:enter-start="-translate-x-full" x-transition:enter-end="translate-x-0" x-transition:leave="transition ease-in-out duration-300 transform" x-transition:leave-start="translate-x-0" x-transition:leave-end="-translate-x-full" class="fixed inset-y-0 left-0 z-50 w-72 bg-gray-900 md:hidden overflow-y-auto shadow-2xl">
    <!-- Mobile Content Duplicate -->
    <div class="flex flex-col h-full">
         <div class="flex items-center justify-center h-20 border-b border-gray-800">
            <span class="text-2xl font-black text-white tracking-tighter">SATRIA</span>
        </div>
        <div class="flex-1 overflow-y-auto p-4 space-y-4">
             <x-nav-link-sidebar :href="route('dashboard')" :active="request()->routeIs('dashboard')" icon="home">
                Dashboard
            </x-nav-link-sidebar>
            <!-- (Simplified mobile menu for brevity - assuming user uses main menu mostly) -->
             <div class="px-3 py-2 text-xs text-gray-500 uppercase font-bold">Menu Utama</div>
             <x-nav-link-sidebar :href="route('antrean.index')" :active="request()->routeIs('antrean.*')" icon="ticket">Antrean</x-nav-link-sidebar>
             <x-nav-link-sidebar :href="route('pasien.index')" :active="request()->routeIs('pasien.*')" icon="users">Pasien</x-nav-link-sidebar>
             <x-nav-link-sidebar :href="route('barang.index')" :active="request()->routeIs('barang.*')" icon="archive">Inventaris</x-nav-link-sidebar>
        </div>
    </div>
</div>