<!-- COMMAND CENTER -->
<div class="mb-2 px-4 mt-2">
    <p class="text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] mb-2 font-display">Command Center</p>
</div>

<x-nav-link-sidebar :href="route('dashboard')" :active="request()->routeIs('dashboard')" icon="chip" color="indigo">
    Dashboard Utama
</x-nav-link-sidebar>

<!-- KLASTER 1: MANAJEMEN -->
@if(Auth::user()->role === 'admin' || Auth::user()->role === 'kapus')
    <div class="mt-6 mb-2 px-4">
        <p class="text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] mb-2 font-display">Klaster 1: Manajemen</p>
    </div>
    
    <x-nav-link-sidebar :href="route('hrd.dashboard')" :active="request()->routeIs('hrd.*') || request()->routeIs('pegawai.*')" icon="briefcase" color="slate">
        SDM & Kepegawaian
    </x-nav-link-sidebar>

    <x-nav-link-sidebar :href="route('finance.dashboard')" :active="request()->routeIs('finance.*') || request()->routeIs('kasir.*')" icon="currency-dollar" color="slate">
        Keuangan & Billing
    </x-nav-link-sidebar>

    <x-nav-link-sidebar :href="route('barang.dashboard')" :active="request()->routeIs('barang.*') || request()->routeIs('supplier.*')" icon="archive" color="slate">
        Aset & Logistik
    </x-nav-link-sidebar>
    
    <x-nav-link-sidebar :href="route('system.setting.index')" :active="request()->routeIs('system.*') || request()->routeIs('security.*')" icon="cog" color="slate">
        Sistem & Keamanan
    </x-nav-link-sidebar>
@endif

<!-- KLASTER 2: IBU & ANAK -->
@if(Auth::user()->role === 'admin' || in_array(Auth::user()->role, ['dokter', 'perawat', 'bidan']))
    <div class="mt-6 mb-2 px-4">
        <p class="text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] mb-2 font-display">Klaster 2: Ibu & Anak</p>
    </div>

    <x-nav-link-sidebar :href="route('antrean.index')" :active="request()->routeIs('antrean.*') && request()->query('cluster') == 2" icon="heart" color="rose">
        Antrean KIA
    </x-nav-link-sidebar>
    
    <!-- Placeholder untuk fitur spesifik KIA nanti -->
    <x-nav-link-sidebar :href="route('medical.dashboard')" :active="request()->routeIs('medical.dashboard') && request()->query('cluster') == 2" icon="chart-pie" color="rose">
        Statistik KIA
    </x-nav-link-sidebar>
@endif

<!-- KLASTER 3: DEWASA & LANSIA -->
@if(Auth::user()->role === 'admin' || in_array(Auth::user()->role, ['dokter', 'perawat']))
    <div class="mt-6 mb-2 px-4">
        <p class="text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] mb-2 font-display">Klaster 3: Usia Produktif</p>
    </div>

    <x-nav-link-sidebar :href="route('antrean.index')" :active="request()->routeIs('antrean.*') && !request()->query('cluster')" icon="users" color="blue">
        Poliklinik Umum
    </x-nav-link-sidebar>

    <x-nav-link-sidebar :href="route('rekam-medis.index')" :active="request()->routeIs('rekam-medis.*')" icon="clipboard-list" color="blue">
        Rekam Medis (RME)
    </x-nav-link-sidebar>
    
    <x-nav-link-sidebar :href="route('surat.keterangan.index')" :active="request()->routeIs('surat.*')" icon="document-text" color="blue">
        Persuratan Medis
    </x-nav-link-sidebar>
@endif

<!-- KLASTER 4: PENYAKIT MENULAR -->
@if(Auth::user()->role === 'admin' || in_array(Auth::user()->role, ['dokter', 'perawat', 'surveilans']))
    <div class="mt-6 mb-2 px-4">
        <p class="text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] mb-2 font-display">Klaster 4: P2P</p>
    </div>

    <x-nav-link-sidebar :href="route('medical.penyakit.index')" :active="request()->routeIs('medical.penyakit.*')" icon="shield-exclamation" color="orange">
        Surveilans Penyakit
    </x-nav-link-sidebar>
@endif

<!-- LINTAS KLASTER -->
@if(Auth::user()->role === 'admin' || in_array(Auth::user()->role, ['dokter', 'perawat', 'apoteker', 'staf']))
    <div class="mt-6 mb-2 px-4">
        <p class="text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] mb-2 font-display">Lintas Klaster</p>
    </div>

    <x-nav-link-sidebar :href="route('pharmacy.dashboard')" :active="request()->routeIs('pharmacy.*') || request()->routeIs('apotek.*') || request()->routeIs('obat.*')" icon="beaker" color="emerald">
        Farmasi & Obat
    </x-nav-link-sidebar>
    
    <x-nav-link-sidebar :href="route('rawat-inap.index')" :active="request()->routeIs('rawat-inap.*')" icon="office-building" color="teal">
        Rawat Inap
    </x-nav-link-sidebar>
    
    <x-nav-link-sidebar :href="route('pasien.index')" :active="request()->routeIs('pasien.*')" icon="identification" color="teal">
        Database Pasien
    </x-nav-link-sidebar>
@endif

<!-- PORTAL PEGAWAI -->
<div class="mt-6 mb-2 px-4">
    <p class="text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] mb-2 font-display">Personal</p>
</div>
<x-nav-link-sidebar :href="route('kepegawaian.dashboard')" :active="request()->routeIs('kepegawaian.*')" icon="user-circle" color="violet">
    Portal Pegawai
</x-nav-link-sidebar>

<div class="pb-24"></div>
