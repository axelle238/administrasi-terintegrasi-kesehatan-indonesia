<!-- Utama -->
<div class="mb-2 px-4 mt-2">
    <p class="text-[11px] font-bold text-slate-500 uppercase tracking-wider mb-2 font-[Outfit]">Utama</p>
</div>

<x-nav-link-sidebar :href="route('dashboard')" :active="request()->routeIs('dashboard')" icon="home" color="blue">
    Dashboard
</x-nav-link-sidebar>

<!-- Klinis / Medis -->
@if(Auth::user()->role === 'admin' || in_array(Auth::user()->role, ['dokter', 'perawat', 'staf']))
    <div class="mt-8 mb-2 px-4">
        <p class="text-[11px] font-bold text-slate-500 uppercase tracking-wider mb-2 font-[Outfit]">Layanan Medis</p>
    </div>
    
    <x-nav-link-sidebar :href="route('antrean.index')" :active="request()->routeIs('antrean.*')" icon="ticket" color="cyan">
        Antrean & Triage
    </x-nav-link-sidebar>

    <x-nav-link-sidebar :href="route('pasien.index')" :active="request()->routeIs('pasien.*')" icon="users" color="cyan">
        Database Pasien
    </x-nav-link-sidebar>

    @if(Auth::user()->role === 'admin' || in_array(Auth::user()->role, ['dokter', 'perawat']))
        <x-nav-link-sidebar :href="route('rekam-medis.index')" :active="request()->routeIs('rekam-medis.*')" icon="clipboard-list" color="cyan">
            Rekam Medis (RME)
        </x-nav-link-sidebar>

        <x-nav-link-sidebar :href="route('rawat-inap.index')" :active="request()->routeIs('rawat-inap.index')" icon="office-building" color="cyan">
            Rawat Inap
        </x-nav-link-sidebar>
        
        <x-nav-link-sidebar :href="route('rawat-inap.kamar')" :active="request()->routeIs('rawat-inap.kamar')" icon="view-grid" color="cyan">
            Monitoring Kamar
        </x-nav-link-sidebar>
        
        <x-nav-link-sidebar :href="route('surat.keterangan.index')" :active="request()->routeIs('surat.keterangan.*')" icon="document-text" color="cyan">
            Surat Keterangan
        </x-nav-link-sidebar>
        
        <x-nav-link-sidebar :href="route('system.poli.index')" :active="request()->routeIs('system.poli.*')" icon="collection" color="cyan">
            Data Poli/Unit
        </x-nav-link-sidebar>
    @endif
@endif

<!-- Farmasi -->
@if(Auth::user()->role === 'admin' || Auth::user()->role === 'apoteker')
    <div class="mt-8 mb-2 px-4">
        <p class="text-[11px] font-bold text-slate-500 uppercase tracking-wider mb-2 font-[Outfit]">Farmasi & Obat</p>
    </div>

    <x-nav-link-sidebar :href="route('apotek.index')" :active="request()->routeIs('apotek.*')" icon="beaker" color="emerald">
        Layanan Resep
    </x-nav-link-sidebar>

    <x-nav-link-sidebar :href="route('obat.index')" :active="request()->routeIs('obat.index') || request()->routeIs('obat.create') || request()->routeIs('obat.edit')" icon="cube" color="emerald">
        Inventaris Obat
    </x-nav-link-sidebar>

    <x-nav-link-sidebar :href="route('obat.stock-opname')" :active="request()->routeIs('obat.stock-opname')" icon="refresh" color="emerald">
        Stok Opname
    </x-nav-link-sidebar>
    
    <x-nav-link-sidebar :href="route('laporan.lplpo')" :active="request()->routeIs('laporan.lplpo')" icon="document-report" color="emerald">
        Laporan LPLPO
    </x-nav-link-sidebar>
@endif

<!-- Keuangan -->
@if(Auth::user()->role === 'admin' || Auth::user()->role === 'staf')
    <div class="mt-8 mb-2 px-4">
        <p class="text-[11px] font-bold text-slate-500 uppercase tracking-wider mb-2 font-[Outfit]">Keuangan</p>
    </div>

    <x-nav-link-sidebar :href="route('kasir.index')" :active="request()->routeIs('kasir.*')" icon="credit-card" color="teal">
        Kasir & Billing
    </x-nav-link-sidebar>
@endif

<!-- SDM & Admin -->
@if(Auth::user()->role === 'admin')
    <div class="mt-8 mb-2 px-4">
        <p class="text-[11px] font-bold text-slate-500 uppercase tracking-wider mb-2 font-[Outfit]">Administrasi</p>
    </div>

    <x-nav-link-sidebar :href="route('pegawai.index')" :active="request()->routeIs('pegawai.*')" icon="identification" color="violet">
        Data Pegawai
    </x-nav-link-sidebar>

    <x-nav-link-sidebar :href="route('jadwal-jaga.index')" :active="request()->routeIs('jadwal-jaga.*')" icon="calendar" color="violet">
        Jadwal & Shift
    </x-nav-link-sidebar>
    
    <x-nav-link-sidebar :href="route('kepegawaian.kinerja.index')" :active="request()->routeIs('kepegawaian.kinerja.*')" icon="chart-pie" color="violet">
        Kinerja Pegawai
    </x-nav-link-sidebar>

    <x-nav-link-sidebar :href="route('kepegawaian.gaji.index')" :active="request()->routeIs('kepegawaian.gaji.*')" icon="cash" color="violet">
        Penggajian
    </x-nav-link-sidebar>
    
    <x-nav-link-sidebar :href="route('surat.index')" :active="request()->routeIs('surat.index') || request()->routeIs('surat.create')" icon="mail" color="violet">
        Persuratan
    </x-nav-link-sidebar>
@endif

<!-- Akses Umum -->
<div class="mt-8 mb-2 px-4">
    <p class="text-[11px] font-bold text-slate-500 uppercase tracking-wider mb-2 font-[Outfit]">Umum</p>
</div>
<x-nav-link-sidebar :href="route('kepegawaian.cuti.index')" :active="request()->routeIs('kepegawaian.cuti.*')" icon="document-text" color="orange">
    Pengajuan Cuti
</x-nav-link-sidebar>

<!-- Aset -->
@if(Auth::user()->role === 'admin' || Auth::user()->role === 'staf')
     <div class="mt-8 mb-2 px-4">
        <p class="text-[11px] font-bold text-slate-500 uppercase tracking-wider mb-2 font-[Outfit]">Aset & Fasilitas</p>
    </div>

    <x-nav-link-sidebar :href="route('barang.dashboard')" :active="request()->routeIs('barang.dashboard')" icon="chart-bar" color="indigo">
        Dashboard Aset
    </x-nav-link-sidebar>

    <x-nav-link-sidebar :href="route('barang.index')" :active="request()->routeIs('barang.index')" icon="archive" color="indigo">
        Data Aset
    </x-nav-link-sidebar>
    
    <x-nav-link-sidebar :href="route('barang.pengadaan.index')" :active="request()->routeIs('barang.pengadaan.*')" icon="shopping-cart" color="indigo">
        Pengadaan
    </x-nav-link-sidebar>
    
    <x-nav-link-sidebar :href="route('barang.maintenance')" :active="request()->routeIs('barang.maintenance')" icon="tool" color="indigo">
        Pemeliharaan
    </x-nav-link-sidebar>
    
    <x-nav-link-sidebar :href="route('ruangan.index')" :active="request()->routeIs('ruangan.*')" icon="office-building" color="indigo">
        Ruangan
    </x-nav-link-sidebar>
@endif

<!-- Sistem -->
@if(Auth::user()->role === 'admin')
    <div class="mt-8 mb-2 px-4">
        <p class="text-[11px] font-bold text-slate-500 uppercase tracking-wider mb-2 font-[Outfit]">Sistem</p>
    </div>

    <x-nav-link-sidebar :href="route('system.user.index')" :active="request()->routeIs('system.user.*')" icon="shield-check" color="slate">
        Manajemen Pengguna
    </x-nav-link-sidebar>

    <x-nav-link-sidebar :href="route('system.setting.index')" :active="request()->routeIs('system.setting.*')" icon="cog" color="slate">
        Pengaturan Aplikasi
    </x-nav-link-sidebar>
    
    <x-nav-link-sidebar :href="route('system.info')" :active="request()->routeIs('system.info')" icon="chart-bar" color="slate">
        Informasi Sistem
    </x-nav-link-sidebar>
    
    <x-nav-link-sidebar :href="route('activity-log')" :active="request()->routeIs('activity-log')" icon="clock" color="slate">
        Log Aktivitas
    </x-nav-link-sidebar>
@endif

<div class="pb-20"></div>