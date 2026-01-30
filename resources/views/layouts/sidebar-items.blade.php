<!-- COMMAND CENTER -->
<x-nav.link :href="route('dashboard')" :active="request()->routeIs('dashboard')" icon="chip">
    <x-slot:slot>
        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6V4m0 2a2 2 0 100 4m0-4a2 2 0 110 4m-6 8a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4m6 6v10m6-2a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4"></path></svg>
    </x-slot:slot>
    Dashboard Utama
</x-nav.link>

<!-- KLASTER 1: MANAJEMEN -->
@if(Auth::user()->role === 'admin' || Auth::user()->role === 'kapus')
    <x-nav.dropdown label="Manajemen" :active="request()->routeIs('hrd.*') || request()->routeIs('pegawai.*') || request()->routeIs('finance.*') || request()->routeIs('barang.*')">
        <x-slot:icon>
            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path></svg>
        </x-slot:icon>
        
        <x-nav.link-child :href="route('hrd.dashboard')" :active="request()->routeIs('hrd.dashboard')">
            Dashboard SDM
        </x-nav.link-child>
        <x-nav.link-child :href="route('pegawai.index')" :active="request()->routeIs('pegawai.*')">
            Data Pegawai
        </x-nav.link-child>
        <x-nav.link-child :href="route('finance.dashboard')" :active="request()->routeIs('finance.dashboard')">
            Keuangan & Billing
        </x-nav.link-child>
        <x-nav.link-child :href="route('barang.dashboard')" :active="request()->routeIs('barang.dashboard')">
            Aset & Logistik
        </x-nav.link-child>
    </x-nav.dropdown>
@endif

<!-- KLASTER 2: IBU & ANAK -->
@if(Auth::user()->role === 'admin' || in_array(Auth::user()->role, ['dokter', 'perawat', 'bidan']))
    <x-nav.dropdown label="Ibu & Anak" :active="request()->query('cluster') == 2">
        <x-slot:icon>
            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path></svg>
        </x-slot:icon>

        <x-nav.link-child :href="route('antrean.index', ['cluster' => 2])" :active="request()->routeIs('antrean.*') && request()->query('cluster') == 2">
            Antrean KIA
        </x-nav.link-child>
        <x-nav.link-child :href="route('medical.dashboard', ['cluster' => 2])" :active="request()->routeIs('medical.dashboard') && request()->query('cluster') == 2">
            Statistik KIA
        </x-nav.link-child>
    </x-nav.dropdown>
@endif

<!-- KLASTER 3: DEWASA & LANSIA -->
@if(Auth::user()->role === 'admin' || in_array(Auth::user()->role, ['dokter', 'perawat']))
    <x-nav.dropdown label="Layanan Medis" :active="request()->routeIs('antrean.index') && !request()->query('cluster') || request()->routeIs('rekam-medis.*') || request()->routeIs('surat.*')">
        <x-slot:icon>
            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"></path></svg>
        </x-slot:icon>

        <x-nav.link-child :href="route('antrean.index')" :active="request()->routeIs('antrean.index') && !request()->query('cluster')">
            Poliklinik Umum
        </x-nav.link-child>
        <x-nav.link-child :href="route('rekam-medis.index')" :active="request()->routeIs('rekam-medis.*')">
            Rekam Medis (RME)
        </x-nav.link-child>
        <x-nav.link-child :href="route('surat.keterangan.index')" :active="request()->routeIs('surat.keterangan.*')">
            Persuratan Medis
        </x-nav.link-child>
    </x-nav.dropdown>
@endif

<!-- KLASTER 4: PENYAKIT MENULAR -->
@if(Auth::user()->role === 'admin' || in_array(Auth::user()->role, ['dokter', 'perawat', 'surveilans']))
    <x-nav.dropdown label="Pencegahan Penyakit" :active="request()->routeIs('medical.penyakit.*')">
        <x-slot:icon>
            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
        </x-slot:icon>
        <x-nav.link-child :href="route('medical.penyakit.index')" :active="request()->routeIs('medical.penyakit.*')">
            Surveilans P2P
        </x-nav.link-child>
        <x-nav.link-child :href="route('ukm.index')" :active="request()->routeIs('ukm.*')">
            Kegiatan UKM
        </x-nav.link-child>
    </x-nav.dropdown>
@endif

<!-- LINTAS KLASTER -->
@if(Auth::user()->role === 'admin' || in_array(Auth::user()->role, ['dokter', 'perawat', 'apoteker', 'staf']))
    <x-nav.dropdown label="Penunjang" :active="request()->routeIs('pharmacy.*') || request()->routeIs('apotek.*') || request()->routeIs('obat.*') || request()->routeIs('rawat-inap.*') || request()->routeIs('pasien.*')">
        <x-slot:icon>
            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.384-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z"></path></svg>
        </x-slot:icon>

        <x-nav.link-child :href="route('pharmacy.dashboard')" :active="request()->routeIs('pharmacy.*') || request()->routeIs('obat.*')">
            Farmasi & Obat
        </x-nav.link-child>
        <x-nav.link-child :href="route('rawat-inap.index')" :active="request()->routeIs('rawat-inap.*')">
            Rawat Inap
        </x-nav.link-child>
        <x-nav.link-child :href="route('pasien.index')" :active="request()->routeIs('pasien.*')">
            Database Pasien
        </x-nav.link-child>
    </x-nav.dropdown>
@endif

<!-- KLASTER 5: MASYARAKAT (Public) -->
@if(Auth::user()->role === 'admin')
    <x-nav.dropdown label="Masyarakat" :active="request()->routeIs('public.*') || request()->routeIs('admin.berita.*') || request()->routeIs('admin.masyarakat.*')">
        <x-slot:icon>
            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
        </x-slot:icon>

        <x-nav.link-child :href="route('public.dashboard')" :active="request()->routeIs('public.dashboard')">
            Portal Masyarakat
        </x-nav.link-child>
        <x-nav.link-child :href="route('admin.berita.index')" :active="request()->routeIs('admin.berita.*')">
            Manajemen Berita
        </x-nav.link-child>
        <x-nav.link-child :href="route('admin.masyarakat.pengaduan.index')" :active="request()->routeIs('admin.masyarakat.*')">
            Pusat Pengaduan
        </x-nav.link-child>
    </x-nav.dropdown>
@endif

<!-- SYSTEM & SECURITY -->
@if(Auth::user()->role === 'admin')
    <x-nav.dropdown label="Sistem & Keamanan" :active="request()->routeIs('system.*') || request()->routeIs('security.*')">
        <x-slot:icon>
            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
        </x-slot:icon>

        <x-nav.link-child :href="route('system.info')" :active="request()->routeIs('system.info')">
            Status Sistem
        </x-nav.link-child>
        <x-nav.link-child :href="route('system.setting.index')" :active="request()->routeIs('system.setting.*')">
            Pengaturan Global
        </x-nav.link-child>
        <x-nav.link-child :href="route('security.dashboard')" :active="request()->routeIs('security.*')">
            Keamanan Siber
        </x-nav.link-child>
    </x-nav.dropdown>

    <x-nav.dropdown label="Tema Tampilan" :active="request()->routeIs('system.setting.index')">
        <x-slot:icon>
            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21a4 4 0 01-4-4V5a2 2 0 012-2h4a2 2 0 012 2v12a4 4 0 01-4 4zm0 0h12a2 2 0 002-2v-4a2 2 0 00-2-2h-2.343M11 7.343l1.172-1.172a4 4 0 115.656 5.656L10 17.657l-1.414-1.414L11 7.343z"></path></svg>
        </x-slot:icon>
        <x-nav.link-child :href="route('system.setting.index', ['tab' => 'tampilan'])" :active="false">
            Ganti Template Depan
        </x-nav.link-child>
    </x-nav.dropdown>
@endif

<!-- PORTAL PEGAWAI -->
<div class="mt-6 mb-2 px-4">
    <p class="text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] mb-2 font-display">Personal</p>
</div>
<x-nav.link :href="route('kepegawaian.dashboard')" :active="request()->routeIs('kepegawaian.dashboard')" icon="user-circle">
    <x-slot:icon>
        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5.121 17.804A13.937 13.937 0 0112 16c2.5 0 4.847.655 6.879 1.804M15 10a3 3 0 11-6 0 3 3 0 016 0zm6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
    </x-slot:icon>
    Portal Pegawai
</x-nav.link>

<div class="pb-24"></div>