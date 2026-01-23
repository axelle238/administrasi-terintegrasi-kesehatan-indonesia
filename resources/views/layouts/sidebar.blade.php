<aside class="flex flex-col w-64 h-screen px-4 py-8 bg-white border-r rtl:border-r-0 rtl:border-l dark:bg-gray-900 dark:border-gray-700 hidden md:flex z-50">
    <div class="flex items-center justify-center mb-6">
        <a href="{{ route('dashboard') }}" class="flex items-center gap-2">
            <div class="p-2 bg-teal-600 rounded-lg shadow-lg">
                <!-- Heroicon: Shield Check -->
                <svg class="w-6 h-6 text-white" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12c0 1.268-.63 2.39-1.593 3.068a3.745 3.745 0 01-1.043 3.296 3.745 3.745 0 01-3.296 1.043A3.745 3.745 0 0112 21c-1.268 0-2.39-.63-3.068-1.593a3.746 3.746 0 01-3.296-1.043 3.745 3.745 0 01-1.043-3.296A3.745 3.745 0 013 12c0-1.268.63-2.39 1.593-3.068a3.745 3.745 0 011.043-3.296 3.746 3.746 0 013.296-1.043A3.746 3.746 0 0112 3c1.268 0 2.39.63 3.068 1.593a3.746 3.746 0 013.296 1.043 3.746 3.746 0 011.043 3.296A3.745 3.745 0 0121 12z" />
                </svg>
            </div>
            <span class="text-xl font-extrabold text-gray-800 dark:text-white tracking-tight">SATRIA</span>
        </a>
    </div>

    <div class="flex flex-col justify-between flex-1 mt-2 overflow-y-auto">
        <nav class="space-y-1">
            <x-nav-link-sidebar :href="route('dashboard')" :active="request()->routeIs('dashboard')" icon="home">
                Dashboard
            </x-nav-link-sidebar>

            {{-- PELAYANAN MEDIS --}}
            @if(Auth::user()->role === 'admin' || in_array(Auth::user()->role, ['dokter', 'perawat', 'staf']))
                <div class="pt-4 pb-2">
                    <p class="px-4 text-xs font-bold text-gray-400 uppercase tracking-wider">Pelayanan Medis</p>
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
                <div class="pt-4 pb-2">
                    <p class="px-4 text-xs font-bold text-gray-400 uppercase tracking-wider">Farmasi</p>
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
                <div class="pt-4 pb-2">
                    <p class="px-4 text-xs font-bold text-gray-400 uppercase tracking-wider">Keuangan</p>
                </div>

                <x-nav-link-sidebar :href="route('kasir.index')" :active="request()->routeIs('kasir.*')" icon="cash">
                    Kasir & Billing
                </x-nav-link-sidebar>
            @endif

            {{-- MANAJEMEN SDM (HR) --}}
            @if(Auth::user()->role === 'admin')
                <div class="pt-4 pb-2">
                    <p class="px-4 text-xs font-bold text-gray-400 uppercase tracking-wider">Kepegawaian</p>
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

            {{-- CUTI (Accessible to all for request, Admin for manage) --}}
            <x-nav-link-sidebar :href="route('kepegawaian.cuti.index')" :active="request()->routeIs('kepegawaian.cuti.*')" icon="document-text">
                Cuti & Izin
            </x-nav-link-sidebar>

            {{-- INVENTARIS --}}
            @if(Auth::user()->role === 'admin' || Auth::user()->role === 'staf')
                <div class="pt-4 pb-2">
                    <p class="px-4 text-xs font-bold text-gray-400 uppercase tracking-wider">Inventaris</p>
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

                <x-nav-link-sidebar :href="route('barang.maintenance')" :active="request()->routeIs('barang.maintenance')" icon="tool">
                    Pemeliharaan
                </x-nav-link-sidebar>

                <x-nav-link-sidebar :href="route('barang.pengadaan.index')" :active="request()->routeIs('barang.pengadaan.*')" icon="shopping-cart">
                    Pengadaan
                </x-nav-link-sidebar>

                <x-nav-link-sidebar :href="route('barang.laporan')" :active="request()->routeIs('barang.laporan')" icon="document-report">
                    Laporan Inventaris
                </x-nav-link-sidebar>
            @endif

            {{-- ADMINISTRASI --}}
            @if(Auth::user()->role === 'admin' || Auth::user()->role === 'staf')
                <div class="pt-4 pb-2">
                    <p class="px-4 text-xs font-bold text-gray-400 uppercase tracking-wider">Administrasi</p>
                </div>

                <x-nav-link-sidebar :href="route('surat.index')" :active="request()->routeIs('surat.*')" icon="mail">
                    Surat Menyurat
                </x-nav-link-sidebar>
            @endif

            {{-- LAPORAN --}}
            @if(Auth::user()->role === 'admin' || Auth::user()->role === 'staf')
                <div class="pt-4 pb-2">
                    <p class="px-4 text-xs font-bold text-gray-400 uppercase tracking-wider">Laporan</p>
                </div>

                <x-nav-link-sidebar :href="route('laporan.index')" :active="request()->routeIs('laporan.index')" icon="chart-bar">
                    Laporan Statistik
                </x-nav-link-sidebar>

                @if(Auth::user()->role === 'admin' || Auth::user()->role === 'apoteker')
                    <x-nav-link-sidebar :href="route('laporan.lplpo')" :active="request()->routeIs('laporan.lplpo')" icon="document-report">
                        Laporan LPLPO
                    </x-nav-link-sidebar>
                @endif
            @endif

            {{-- SYSTEM INTERNAL --}}
            @if(Auth::user()->role === 'admin')
                <div class="pt-4 pb-2">
                    <p class="px-4 text-xs font-bold text-gray-400 uppercase tracking-wider">Sistem Internal</p>
                </div>

                <x-nav-link-sidebar :href="route('system.user.index')" :active="request()->routeIs('system.user.*')" icon="user-group">
                    Manajemen User
                </x-nav-link-sidebar>

                <x-nav-link-sidebar :href="route('system.poli.index')" :active="request()->routeIs('system.poli.*')" icon="office-building">
                    Master Poli
                </x-nav-link-sidebar>

                <x-nav-link-sidebar :href="route('system.tindakan.index')" :active="request()->routeIs('system.tindakan.*')" icon="collection">
                    Master Tindakan
                </x-nav-link-sidebar>

                <x-nav-link-sidebar :href="route('system.setting.index')" :active="request()->routeIs('system.setting.*')" icon="cog">
                    Pengaturan
                </x-nav-link-sidebar>

                <x-nav-link-sidebar :href="route('activity-log')" :active="request()->routeIs('activity-log')" icon="database">
                    Log Aktivitas
                </x-nav-link-sidebar>
            @endif
        </nav>

        <div class="mt-8 pt-4 border-t border-gray-200 dark:border-gray-700">
             <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="flex items-center w-full px-4 py-2 text-gray-600 transition-colors duration-200 transform rounded-lg dark:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-800 hover:text-gray-700 dark:hover:text-gray-200 group">
                    <svg class="w-5 h-5 group-hover:text-red-600 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path></svg>
                    <span class="mx-4 font-medium group-hover:text-red-600 transition-colors">Log Out</span>
                </button>
            </form>
        </div>
    </div>
</aside>

<!-- Mobile Sidebar Overlay -->
<div x-show="sidebarOpen" @click="sidebarOpen = false" x-transition:enter="transition-opacity ease-linear duration-300" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100" x-transition:leave="transition-opacity ease-linear duration-300" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0" class="fixed inset-0 z-40 bg-gray-900/50 md:hidden"></div>

<!-- Mobile Sidebar -->
<div x-show="sidebarOpen" x-transition:enter="transition ease-in-out duration-300 transform" x-transition:enter-start="-translate-x-full" x-transition:enter-end="translate-x-0" x-transition:leave="transition ease-in-out duration-300 transform" x-transition:leave-start="translate-x-0" x-transition:leave-end="-translate-x-full" class="fixed inset-y-0 left-0 z-50 w-64 bg-white dark:bg-gray-900 md:hidden overflow-y-auto">
    <div class="flex flex-col h-full px-4 py-8">
         <div class="flex items-center justify-center mb-6 gap-2">
            <div class="p-1.5 bg-teal-600 rounded-lg shadow-lg">
                <!-- Heroicon: Shield Check -->
                <svg class="w-5 h-5 text-white" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12c0 1.268-.63 2.39-1.593 3.068a3.745 3.745 0 01-1.043 3.296 3.745 3.745 0 01-3.296 1.043A3.745 3.745 0 0112 21c-1.268 0-2.39-.63-3.068-1.593a3.746 3.746 0 01-3.296-1.043 3.745 3.745 0 01-1.043-3.296A3.745 3.745 0 013 12c0-1.268.63-2.39 1.593-3.068a3.745 3.745 0 011.043-3.296 3.746 3.746 0 013.296-1.043A3.746 3.746 0 0112 3c1.268 0 2.39.63 3.068 1.593a3.746 3.746 0 013.296 1.043 3.746 3.746 0 011.043 3.296A3.745 3.745 0 0121 12z" />
                </svg>
            </div>
            <span class="text-xl font-extrabold text-gray-800 dark:text-white">SATRIA</span>
        </div>
        
        <!-- Mobile Nav Content (Duplicate of Desktop for simplicity) -->
        <nav class="space-y-1">
            <x-nav-link-sidebar :href="route('dashboard')" :active="request()->routeIs('dashboard')" icon="home">
                Dashboard
            </x-nav-link-sidebar>

            {{-- PELAYANAN MEDIS MOBILE --}}
            @if(Auth::user()->role === 'admin' || in_array(Auth::user()->role, ['dokter', 'perawat', 'staf']))
                <div class="pt-4 pb-2">
                    <p class="px-4 text-xs font-bold text-gray-400 uppercase tracking-wider">Pelayanan Medis</p>
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

            {{-- FARMASI MOBILE --}}
            @if(Auth::user()->role === 'admin' || Auth::user()->role === 'apoteker')
                <div class="pt-4 pb-2">
                    <p class="px-4 text-xs font-bold text-gray-400 uppercase tracking-wider">Farmasi</p>
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

            {{-- KEUANGAN MOBILE --}}
            @if(Auth::user()->role === 'admin' || Auth::user()->role === 'staf')
                <div class="pt-4 pb-2">
                    <p class="px-4 text-xs font-bold text-gray-400 uppercase tracking-wider">Keuangan</p>
                </div>

                <x-nav-link-sidebar :href="route('kasir.index')" :active="request()->routeIs('kasir.*')" icon="cash">
                    Kasir & Billing
                </x-nav-link-sidebar>
            @endif

            {{-- MANAJEMEN SDM MOBILE --}}
            @if(Auth::user()->role === 'admin')
                <div class="pt-4 pb-2">
                    <p class="px-4 text-xs font-bold text-gray-400 uppercase tracking-wider">Kepegawaian</p>
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

            {{-- CUTI MOBILE --}}
            <x-nav-link-sidebar :href="route('kepegawaian.cuti.index')" :active="request()->routeIs('kepegawaian.cuti.*')" icon="document-text">
                Cuti & Izin
            </x-nav-link-sidebar>

            {{-- INVENTARIS MOBILE --}}
            @if(Auth::user()->role === 'admin' || Auth::user()->role === 'staf')
                <div class="pt-4 pb-2">
                    <p class="px-4 text-xs font-bold text-gray-400 uppercase tracking-wider">Inventaris</p>
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

                <x-nav-link-sidebar :href="route('barang.maintenance')" :active="request()->routeIs('barang.maintenance')" icon="tool">
                    Pemeliharaan
                </x-nav-link-sidebar>

                <x-nav-link-sidebar :href="route('barang.pengadaan.index')" :active="request()->routeIs('barang.pengadaan.*')" icon="shopping-cart">
                    Pengadaan
                </x-nav-link-sidebar>

                <x-nav-link-sidebar :href="route('barang.laporan')" :active="request()->routeIs('barang.laporan')" icon="document-report">
                    Laporan Inventaris
                </x-nav-link-sidebar>
            @endif

            {{-- ADMINISTRASI MOBILE --}}
            @if(Auth::user()->role === 'admin' || Auth::user()->role === 'staf')
                <div class="pt-4 pb-2">
                    <p class="px-4 text-xs font-bold text-gray-400 uppercase tracking-wider">Administrasi</p>
                </div>

                <x-nav-link-sidebar :href="route('surat.index')" :active="request()->routeIs('surat.*')" icon="mail">
                    Surat Menyurat
                </x-nav-link-sidebar>
            @endif

            {{-- LAPORAN MOBILE --}}
            @if(Auth::user()->role === 'admin' || Auth::user()->role === 'staf')
                <div class="pt-4 pb-2">
                    <p class="px-4 text-xs font-bold text-gray-400 uppercase tracking-wider">Laporan</p>
                </div>

                <x-nav-link-sidebar :href="route('laporan.index')" :active="request()->routeIs('laporan.index')" icon="chart-bar">
                    Laporan Statistik
                </x-nav-link-sidebar>

                @if(Auth::user()->role === 'admin' || Auth::user()->role === 'apoteker')
                    <x-nav-link-sidebar :href="route('laporan.lplpo')" :active="request()->routeIs('laporan.lplpo')" icon="document-report">
                        Laporan LPLPO
                    </x-nav-link-sidebar>
                @endif
            @endif

            {{-- SYSTEM INTERNAL MOBILE --}}
            @if(Auth::user()->role === 'admin')
                <div class="pt-4 pb-2">
                    <p class="px-4 text-xs font-bold text-gray-400 uppercase tracking-wider">Sistem Internal</p>
                </div>

                <x-nav-link-sidebar :href="route('system.user.index')" :active="request()->routeIs('system.user.*')" icon="user-group">
                    Manajemen User
                </x-nav-link-sidebar>

                <x-nav-link-sidebar :href="route('system.poli.index')" :active="request()->routeIs('system.poli.*')" icon="office-building">
                    Master Poli
                </x-nav-link-sidebar>

                <x-nav-link-sidebar :href="route('system.tindakan.index')" :active="request()->routeIs('system.tindakan.*')" icon="collection">
                    Master Tindakan
                </x-nav-link-sidebar>

                <x-nav-link-sidebar :href="route('system.setting.index')" :active="request()->routeIs('system.setting.*')" icon="cog">
                    Pengaturan
                </x-nav-link-sidebar>

                <x-nav-link-sidebar :href="route('activity-log')" :active="request()->routeIs('activity-log')" icon="database">
                    Log Aktivitas
                </x-nav-link-sidebar>
            @endif
        </nav>

        <div class="mt-8 pt-4 border-t border-gray-200 dark:border-gray-700">
             <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="flex items-center w-full px-4 py-2 text-gray-600 transition-colors duration-200 transform rounded-lg dark:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-800 hover:text-gray-700 dark:hover:text-gray-200 group">
                    <svg class="w-5 h-5 group-hover:text-red-600 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path></svg>
                    <span class="mx-4 font-medium group-hover:text-red-600 transition-colors">Log Out</span>
                </button>
            </form>
        </div>
    </div>
</div>