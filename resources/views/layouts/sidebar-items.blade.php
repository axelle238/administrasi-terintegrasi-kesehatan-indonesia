<!-- A. DASHBOARD UTAMA -->
<x-nav.dropdown label="Dashboard Utama" :active="request()->routeIs('dashboard') || request()->routeIs('system.notification.*')">
    <x-slot:icon>
        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"></path></svg>
    </x-slot:icon>
    <x-nav.link-child :href="route('dashboard')" :active="request()->routeIs('dashboard')">Ringkasan Eksekutif</x-nav.link-child>
    <x-nav.link-child :href="route('system.notification.index')" :active="request()->routeIs('system.notification.*')">Pusat Notifikasi</x-nav.link-child>
</x-nav.dropdown>

<!-- B. KESEHATAN -->
@if(Auth::user()->can('medis') || Auth::user()->role === 'admin')
<x-nav.dropdown label="Kesehatan" :active="request()->routeIs('medical.*') || request()->routeIs('antrean.*') || request()->routeIs('rekam-medis.*') || request()->routeIs('rawat-inap.*') || request()->routeIs('pharmacy.*') || request()->routeIs('obat.*') || request()->routeIs('surat.keterangan.*')">
    <x-slot:icon>
        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.384-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z"></path></svg>
    </x-slot:icon>
    
    <div class="px-4 py-2 mt-2 text-[10px] font-bold text-slate-400 uppercase tracking-widest border-b border-dashed border-slate-200 mb-1">Monitoring Medis</div>
    <x-nav.link-child :href="route('medical.dashboard')" :active="request()->routeIs('medical.dashboard')">Dashboard Medis Utama</x-nav.link-child>
    
    <div class="px-4 py-2 mt-2 text-[10px] font-bold text-slate-400 uppercase tracking-widest border-b border-dashed border-slate-200 mb-1">Layanan Pasien</div>
    <x-nav.link-child :href="route('antrean.index')" :active="request()->routeIs('antrean.index')">Poliklinik & Antrean</x-nav.link-child>
    <x-nav.link-child :href="route('rekam-medis.index')" :active="request()->routeIs('rekam-medis.index')">Rekam Medis Digital (RME)</x-nav.link-child>
    <x-nav.link-child :href="route('rawat-inap.index')" :active="request()->routeIs('rawat-inap.*')">Rawat Inap (Ranap)</x-nav.link-child>
    
    <div class="px-4 py-2 mt-2 text-[10px] font-bold text-slate-400 uppercase tracking-widest border-b border-dashed border-slate-200 mb-1">Penunjang Medis</div>
    <x-nav.link-child :href="route('pharmacy.dashboard')" :active="request()->routeIs('pharmacy.*') || request()->routeIs('obat.*')">Dashboard Farmasi</x-nav.link-child>
    <x-nav.link-child :href="route('obat.index')" :active="request()->routeIs('obat.index')">Inventaris Obat & BMHP</x-nav.link-child>
    <x-nav.link-child :href="route('surat.keterangan.index')" :active="request()->routeIs('surat.keterangan.*')">Surat Keterangan Medis</x-nav.link-child>
</x-nav.dropdown>
@endif

<!-- C. KESEHATAN MASYARAKAT -->
@if(Auth::user()->can('tata_usaha') || Auth::user()->role === 'admin')
<x-nav.dropdown label="Kesehatan Masyarakat" :active="request()->routeIs('ukm.*') || request()->routeIs('masyarakat.*') || request()->routeIs('public.*')">
    <x-slot:icon>
        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
    </x-slot:icon>
    
    <div class="px-4 py-2 mt-2 text-[10px] font-bold text-slate-400 uppercase tracking-widest border-b border-dashed border-slate-200 mb-1">Monitoring UKM</div>
    <x-nav.link-child :href="route('ukm.dashboard')" :active="request()->routeIs('ukm.dashboard')">Dashboard Kesmas Utama</x-nav.link-child>
    
    <div class="px-4 py-2 mt-2 text-[10px] font-bold text-slate-400 uppercase tracking-widest border-b border-dashed border-slate-200 mb-1">Program & Surveilans</div>
    <x-nav.link-child :href="route('medical.penyakit.index')" :active="request()->routeIs('medical.penyakit.*')">Surveilans P2P (Penyakit)</x-nav.link-child>
    <x-nav.link-child :href="route('ukm.kegiatan.index')" :active="request()->routeIs('ukm.kegiatan.*')">Kegiatan UKM Luar Gedung</x-nav.link-child>
    
    <div class="px-4 py-2 mt-2 text-[10px] font-bold text-slate-400 uppercase tracking-widest border-b border-dashed border-slate-200 mb-1">Data Kependudukan</div>
    <x-nav.link-child :href="route('masyarakat.index')" :active="request()->routeIs('masyarakat.*')">Basis Data Masyarakat</x-nav.link-child>
    <x-nav.link-child :href="route('admin.masyarakat.pengaduan.index')" :active="request()->routeIs('admin.masyarakat.pengaduan.*')">Pusat Pengaduan Publik</x-nav.link-child>
</x-nav.dropdown>
@endif

<!-- D. MANAJEMEN KEPEGAWAIAN -->
@if(Auth::user()->can('admin'))
<x-nav.dropdown label="Manajemen Kepegawaian" :active="request()->routeIs('hrd.*') || request()->routeIs('pegawai.*') || request()->routeIs('shift.*') || request()->routeIs('jadwal-jaga.*') || request()->routeIs('kepegawaian.*') || request()->routeIs('mutasi.*') || request()->routeIs('aset-pegawai.*') || request()->routeIs('kinerja.*') || request()->routeIs('offboarding.*')">
    <x-slot:icon>
        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
    </x-slot:icon>
    
    <div class="px-4 py-2 mt-2 text-[10px] font-bold text-slate-400 uppercase tracking-widest border-b border-dashed border-slate-200 mb-1">Eksekutif HR</div>
    <x-nav.link-child :href="route('hrd.dashboard')" :active="request()->routeIs('hrd.dashboard')">Dashboard Kepegawaian Utama</x-nav.link-child>

    <div class="px-4 py-2 mt-2 text-[10px] font-bold text-slate-400 uppercase tracking-widest border-b border-dashed border-slate-200 mb-1">Sistem Informasi SDM</div>
    <x-nav.link-child :href="route('pegawai.index')" :active="request()->routeIs('pegawai.index') || request()->routeIs('pegawai.create')">Database Pegawai Terpusat</x-nav.link-child>
    <x-nav.link-child :href="route('kepegawaian.kredensial.index')" :active="request()->routeIs('kepegawaian.kredensial.index')">Monitoring STR & SIP</x-nav.link-child>
    <x-nav.link-child :href="route('kepegawaian.aset-pegawai.index')" :active="request()->routeIs('kepegawaian.aset-pegawai.index')">Aset & Inventaris Pegawai</x-nav.link-child>

    <div class="px-4 py-2 mt-2 text-[10px] font-bold text-slate-400 uppercase tracking-widest border-b border-dashed border-slate-200 mb-1">Manajemen Operasional</div>
    <x-nav.link-child :href="route('jadwal-jaga.index')" :active="request()->routeIs('jadwal-jaga.*')">Penjadwalan Dinas (Roster)</x-nav.link-child>
    <x-nav.link-child :href="route('shift.index')" :active="request()->routeIs('shift.*')">Konfigurasi Master Shift</x-nav.link-child>
    <x-nav.link-child :href="route('hrd.presensi.index')" :active="request()->routeIs('hrd.presensi.*')">Audit & Rekap Presensi</x-nav.link-child>

    <div class="px-4 py-2 mt-2 text-[10px] font-bold text-slate-400 uppercase tracking-widest border-b border-dashed border-slate-200 mb-1">Kesejahteraan & Kinerja</div>
    <x-nav.link-child :href="route('admin.gaji.index')" :active="request()->routeIs('admin.gaji.*')">Sistem Payroll (Gaji)</x-nav.link-child>
    <x-nav.link-child :href="route('hrd.cuti.index')" :active="request()->routeIs('hrd.cuti.*')">Verifikasi Cuti & Izin</x-nav.link-child>
    <x-nav.link-child :href="route('kepegawaian.kinerja.assessment')" :active="request()->routeIs('kepegawaian.kinerja.assessment')">Evaluasi Kinerja (KPI)</x-nav.link-child>
    
    <div class="px-4 py-2 mt-2 text-[10px] font-bold text-slate-400 uppercase tracking-widest border-b border-dashed border-slate-200 mb-1">Siklus Hidup Pegawai</div>
    <x-nav.link-child :href="route('kepegawaian.mutasi.index')" :active="request()->routeIs('kepegawaian.mutasi.index')">Mutasi, Promosi & Demosi</x-nav.link-child>
    <x-nav.link-child :href="route('kepegawaian.diklat.index')" :active="request()->routeIs('kepegawaian.diklat.index')">Diklat & Pengembangan</x-nav.link-child>
    <x-nav.link-child :href="route('kepegawaian.offboarding.index')" :active="request()->routeIs('kepegawaian.offboarding.index')">Offboarding & Pensiun</x-nav.link-child>
</x-nav.dropdown>
@endif

<!-- E. MANAJEMEN KEUANGAN -->
@if(Auth::user()->can('admin'))
<x-nav.dropdown label="Manajemen Keuangan" :active="request()->routeIs('finance.*') || request()->routeIs('kasir.*')">
    <x-slot:icon>
        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
    </x-slot:icon>
    
    <div class="px-4 py-2 mt-2 text-[10px] font-bold text-slate-400 uppercase tracking-widest border-b border-dashed border-slate-200 mb-1">Laporan Eksekutif</div>
    <x-nav.link-child :href="route('finance.dashboard')" :active="request()->routeIs('finance.dashboard')">Dashboard Keuangan Utama</x-nav.link-child>
    
    <div class="px-4 py-2 mt-2 text-[10px] font-bold text-slate-400 uppercase tracking-widest border-b border-dashed border-slate-200 mb-1">Operasional Pendapatan</div>
    <x-nav.link-child :href="route('kasir.index')" :active="request()->routeIs('kasir.index')">Point of Sale (Kasir)</x-nav.link-child>
    <x-nav.link-child :href="route('kasir.closing')" :active="request()->routeIs('kasir.closing')">Laporan Closing Kasir</x-nav.link-child>
    
    <div class="px-4 py-2 mt-2 text-[10px] font-bold text-slate-400 uppercase tracking-widest border-b border-dashed border-slate-200 mb-1">Pengeluaran & Anggaran</div>
    <x-nav.link-child :href="route('admin.gaji.index')" :active="request()->routeIs('admin.gaji.*')">Realisasi Gaji Pegawai</x-nav.link-child>
</x-nav.dropdown>
@endif

<!-- F. MANAJEMEN ASET DAN INVENTARIS BARANG -->
@if(Auth::user()->can('tata_usaha') || Auth::user()->role === 'admin')
<x-nav.dropdown label="Manajemen Aset dan Inventaris barang" :active="request()->routeIs('barang.*') || request()->routeIs('supplier.*') || request()->routeIs('ruangan.*') || request()->routeIs('kategori-barang.*')">
    <x-slot:icon>
        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path></svg>
    </x-slot:icon>
    
    <div class="px-4 py-2 mt-2 text-[10px] font-bold text-slate-400 uppercase tracking-widest border-b border-dashed border-slate-200 mb-1">Ringkasan Aset</div>
    <x-nav.link-child :href="route('barang.dashboard')" :active="request()->routeIs('barang.dashboard')">Dashboard Aset Utama</x-nav.link-child>
    <x-nav.link-child :href="route('barang.laporan')" :active="request()->routeIs('barang.laporan')">Buku Inventaris Barang</x-nav.link-child>
    <x-nav.link-child :href="route('barang.penyusutan')" :active="request()->routeIs('barang.penyusutan')">Penyusutan Aset (Depresiasi)</x-nav.link-child>

    <div class="px-4 py-2 mt-2 text-[10px] font-bold text-slate-400 uppercase tracking-widest border-b border-dashed border-slate-200 mb-1">Manajemen Stok</div>
    <x-nav.link-child :href="route('barang.index')" :active="request()->routeIs('barang.index') || request()->routeIs('barang.create')">Master Data Barang</x-nav.link-child>
    <x-nav.link-child :href="route('barang.opname.index')" :active="request()->routeIs('barang.opname.*')">Stok Opname Berkala</x-nav.link-child>
    <x-nav.link-child :href="route('barang.mutasi.index')" :active="request()->routeIs('barang.mutasi.*')">Mutasi Antar Ruangan</x-nav.link-child>

    <div class="px-4 py-2 mt-2 text-[10px] font-bold text-slate-400 uppercase tracking-widest border-b border-dashed border-slate-200 mb-1">Logistik & Pemeliharaan</div>
    <x-nav.link-child :href="route('barang.pengadaan.index')" :active="request()->routeIs('barang.pengadaan.*')">Pengadaan & Penerimaan</x-nav.link-child>
    <x-nav.link-child :href="route('barang.peminjaman.index')" :active="request()->routeIs('barang.peminjaman.*')">Peminjaman & Pengembalian</x-nav.link-child>
    <x-nav.link-child :href="route('barang.maintenance')" :active="request()->routeIs('barang.maintenance')">Jadwal Maintenance Aset</x-nav.link-child>
    <x-nav.link-child :href="route('barang.penghapusan.index')" :active="request()->routeIs('barang.penghapusan.*')">Penghapusan (Write-off)</x-nav.link-child>

    <div class="px-4 py-2 mt-2 text-[10px] font-bold text-slate-400 uppercase tracking-widest border-b border-dashed border-slate-200 mb-1">Parameter Aset</div>
    <x-nav.link-child :href="route('kategori-barang.index')" :active="request()->routeIs('kategori-barang.*')">Kategori & Kelompok</x-nav.link-child>
    <x-nav.link-child :href="route('ruangan.index')" :active="request()->routeIs('ruangan.*')">Lokasi & Ruangan</x-nav.link-child>
    <x-nav.link-child :href="route('supplier.index')" :active="request()->routeIs('supplier.*')">Rekanan (Vendor/Supplier)</x-nav.link-child>
</x-nav.dropdown>
@endif

<!-- G. MANAJEMEN SISTEM PENGATURAN TERPUSAT -->
@if(Auth::user()->role === 'admin')
<x-nav.dropdown label="Manajemen Sistem Pengaturan Terpusat" :active="request()->routeIs('system.*') || request()->routeIs('admin.berita.*')">
    <x-slot:icon>
        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
    </x-slot:icon>
    
    <div class="px-4 py-2 mt-2 text-[10px] font-bold text-slate-400 uppercase tracking-widest border-b border-dashed border-slate-200 mb-1">Status Sistem</div>
    <x-nav.link-child :href="route('system.dashboard')" :active="request()->routeIs('system.dashboard')">Dashboard Kendali Sistem</x-nav.link-child>
    <x-nav.link-child :href="route('system.integration.index')" :active="request()->routeIs('system.integration.*')">Monitoring Integrasi API</x-nav.link-child>

    <div class="px-4 py-2 mt-2 text-[10px] font-bold text-slate-400 uppercase tracking-widest border-b border-dashed border-slate-200 mb-1">Pengaturan Konten (CMS)</div>
    <x-nav.link-child :href="route('system.cms.index')" :active="request()->routeIs('system.cms.*')">Konfigurasi Halaman Depan</x-nav.link-child>
    <x-nav.link-child :href="route('admin.berita.index')" :active="request()->routeIs('admin.berita.*')">Manajemen Berita & Artikel</x-nav.link-child>
    <x-nav.link-child :href="route('system.jenis-pelayanan.index')" :active="request()->routeIs('system.jenis-pelayanan.*')">Katalog Jenis Pelayanan</x-nav.link-child>
    <x-nav.link-child :href="route('system.alur.index')" :active="request()->routeIs('system.alur.*')">Visualisasi Alur Layanan</x-nav.link-child>

    <div class="px-4 py-2 mt-2 text-[10px] font-bold text-slate-400 uppercase tracking-widest border-b border-dashed border-slate-200 mb-1">Parameter Global</div>
    <x-nav.link-child :href="route('system.setting.index')" :active="request()->routeIs('system.setting.index')">Variabel Sistem Global</x-nav.link-child>
    <x-nav.link-child :href="route('system.poli.index')" :active="request()->routeIs('system.poli.*')">Master Unit Kerja / Poli</x-nav.link-child>
    <x-nav.link-child :href="route('system.tindakan.index')" :active="request()->routeIs('system.tindakan.*')">Tarif & Tindakan Medis</x-nav.link-child>
    <x-nav.link-child :href="route('system.surat-template.index')" :active="request()->routeIs('system.surat-template.*')">Editor Template Surat</x-nav.link-child>

    <div class="px-4 py-2 mt-2 text-[10px] font-bold text-slate-400 uppercase tracking-widest border-b border-dashed border-slate-200 mb-1">Identitas & Akses</div>
    <x-nav.link-child :href="route('system.user.index')" :active="request()->routeIs('system.user.*')">Manajemen Akun Pengguna</x-nav.link-child>
    <x-nav.link-child :href="route('system.role.index')" :active="request()->routeIs('system.role.*')">Matriks Hak Akses (Role)</x-nav.link-child>
</x-nav.dropdown>
@endif

<!-- H. MANAJEMEN KEAMANAN TERPUSAT -->
@if(Auth::user()->role === 'admin')
<x-nav.dropdown label="Manajemen Keamanan Terpusat" :active="request()->routeIs('security.*') || request()->routeIs('activity-log') || request()->routeIs('system.backup')">
    <x-slot:icon>
        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path></svg>
    </x-slot:icon>
    
    <div class="px-4 py-2 mt-2 text-[10px] font-bold text-slate-400 uppercase tracking-widest border-b border-dashed border-slate-200 mb-1">Pusat Keamanan</div>
    <x-nav.link-child :href="route('security.dashboard')" :active="request()->routeIs('security.dashboard')">Dashboard Keamanan Siber</x-nav.link-child>
    <x-nav.link-child :href="route('activity-log')" :active="request()->routeIs('activity-log')">Log Audit Jejak Digital</x-nav.link-child>
    
    <div class="px-4 py-2 mt-2 text-[10px] font-bold text-slate-400 uppercase tracking-widest border-b border-dashed border-slate-200 mb-1">Ketahanan Data</div>
    <x-nav.link-child :href="route('system.backup')" :active="request()->routeIs('system.backup')">Manajemen Cadangan (Backup)</x-nav.link-child>
</x-nav.dropdown>
@endif

<!-- PERSONAL -->
<div class="mt-6 mb-2 px-4">
    <p class="text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] mb-2 font-display">Layanan Mandiri</p>
</div>

<!-- PORTAL PEGAWAI -->
<x-nav.dropdown label="Portal Pegawai" :active="request()->routeIs('kepegawaian.*') || request()->routeIs('profile.*')">
    <x-slot:icon>
        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
    </x-slot:icon>
    
    <div class="px-4 py-2 mt-2 text-[10px] font-bold text-slate-400 uppercase tracking-widest border-b border-dashed border-slate-200 mb-1">Area Kerja Mandiri</div>
    <x-nav.link-child :href="route('kepegawaian.dashboard')" :active="request()->routeIs('kepegawaian.dashboard')">Beranda Personalia Saya</x-nav.link-child>
    <x-nav.link-child :href="route('kepegawaian.presensi.index')" :active="request()->routeIs('kepegawaian.presensi.index')">Absensi Kehadiran Digital</x-nav.link-child>
    <x-nav.link-child :href="route('kepegawaian.aktivitas.index')" :active="request()->routeIs('kepegawaian.aktivitas.index')">Log Aktivitas Kerja (LKH)</x-nav.link-child>

    <div class="px-4 py-2 mt-2 text-[10px] font-bold text-slate-400 uppercase tracking-widest border-b border-dashed border-slate-200 mb-1">Permohonan Mandiri</div>
    <x-nav.link-child :href="route('kepegawaian.cuti.index')" :active="request()->routeIs('kepegawaian.cuti.index')">Pengajuan Cuti & Izin</x-nav.link-child>
    <x-nav.link-child :href="route('kepegawaian.lembur.index')" :active="request()->routeIs('kepegawaian.lembur.index')">Laporan Lembur Mandiri</x-nav.link-child>
    <x-nav.link-child :href="route('kepegawaian.jadwal.swap')" :active="request()->routeIs('kepegawaian.jadwal.swap')">Pertukaran Shift Kerja</x-nav.link-child>
    
    <div class="px-4 py-2 mt-2 text-[10px] font-bold text-slate-400 uppercase tracking-widest border-b border-dashed border-slate-200 mb-1">Profil & Keuangan</div>
    <x-nav.link-child :href="route('profile.edit')" :active="request()->routeIs('profile.edit')">Data Pribadi & Dokumen</x-nav.link-child>
    <x-nav.link-child :href="route('kepegawaian.gaji.index')" :active="request()->routeIs('kepegawaian.gaji.index')">Unduh Slip Gaji (Payroll)</x-nav.link-child>
</x-nav.dropdown>