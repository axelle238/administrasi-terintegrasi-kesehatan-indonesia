<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\TransaksiObatController;
use App\Http\Controllers\SuratController;
use App\Http\Controllers\PasienController;
use App\Http\Controllers\KasirController;
use App\Models\Setting;
use App\Models\Poli;
use App\Models\Berita;
use App\Models\Fasilitas;
use App\Models\JadwalJaga;
use Carbon\Carbon;

Route::get('/', function () {
    // ... (Logika Landing Page tetap sama) ...
    // 1. Ambil Semua Pengaturan dari DB
    $dbSettings = Setting::all()->pluck('value', 'key')->toArray();

    // 2. Default Values (Fallback)
    $defaults = [
        'app_name' => 'SATRIA',
        'app_tagline' => 'Sistem Kesehatan',
        'app_description' => 'Sistem Administrasi Kesehatan Terintegrasi Indonesia',
        'app_address' => '-',
        'app_phone' => '-',
        'app_email' => '-',
        'hero_title' => 'Layanan Kesehatan',
        'hero_subtitle' => '',
        'announcement_active' => '0',
        'announcement_text' => '',
        'primary_color' => '#2563eb',
        'show_jadwal_dokter' => '1',
        'show_layanan_poli' => '1',
        'show_fasilitas' => '1',
        'show_pengaduan_cta' => '1',
        'footer_text' => 'SATRIA - Sistem Kesehatan Terintegrasi',
        'front_theme' => 'high-tech',
    ];

    // 3. Gabungkan DB settings dengan Defaults
    $pengaturan = array_merge($defaults, $dbSettings);

    // 4. Data Dinamis
    $layanan = Poli::all();
    // NEW: Load Alur & Harga
    $alurPelayanan = \App\Models\AlurPelayanan::where('is_active', true)->orderBy('urutan')->get();
    $hargaLayanan = \App\Models\Tindakan::where('is_active', true)->whereNotNull('harga')->inRandomOrder()->limit(6)->get();
    
    // NEW: Load CMS Sections
    $cmsSections = \App\Models\LandingComponent::all()->keyBy('section_key');

    $jadwalHariIni = JadwalJaga::with(['pegawai.user', 'shift'])
        ->whereDate('tanggal', Carbon::today())
        ->get();
    $beritaTerbaru = Berita::with('penulis')
        ->where('status', 'published')
        ->latest()
        ->take(3)
        ->get();
    $fasilitas = Fasilitas::where('is_active', true)
        ->latest()
        ->take(6)
        ->get();
    $stats = [
        'pasien_total' => \App\Models\Pasien::count(),
        'dokter_total' => \App\Models\Pegawai::where('jabatan', 'LIKE', '%Dokter%')->count(),
        'layanan_total' => \App\Models\RekamMedis::count(),
    ];

    // 5. Tentukan View Berdasarkan Tema
    $view = 'themes.' . $pengaturan['front_theme'];
    if (!view()->exists($view)) {
        $view = 'themes.high-tech'; // Fallback
    }

    return view($view, compact('pengaturan', 'layanan', 'jadwalHariIni', 'beritaTerbaru', 'fasilitas', 'stats', 'alurPelayanan', 'hargaLayanan', 'cmsSections'));
});

Route::get('/dashboard', \App\Livewire\Dashboard::class)->middleware(['auth', 'verified'])->name('dashboard');
Route::get('/antrean/monitor', \App\Livewire\Antrean\Monitor::class)->name('antrean.monitor');
Route::get('/kiosk', \App\Livewire\Antrean\Kiosk::class)->name('antrean.kiosk');
Route::get('/survey', \App\Livewire\Survey\Create::class)->name('survey.create');
Route::get('/pengaduan', \App\Livewire\Masyarakat\PengaduanPublic::class)->name('pengaduan.public');
Route::get('/alur-pelayanan', \App\Livewire\Public\AlurPelayanan::class)->name('alur-pelayanan.index');

Route::middleware('auth')->group(function () {
    // === PORTAL PEGAWAI (USER) ===
    // Route khusus user (Self-Service)
    Route::prefix('kepegawaian')->name('kepegawaian.')->group(function () {
        Route::get('/dashboard', \App\Livewire\Kepegawaian\DashboardPegawai::class)->name('dashboard');
        Route::get('/cuti', \App\Livewire\Kepegawaian\Cuti\Index::class)->name('cuti.index'); // Self Request
        Route::get('/jadwal/tukar', \App\Livewire\Kepegawaian\Jadwal\Swap::class)->name('jadwal.swap');
        Route::get('/aktivitas/create', \App\Livewire\Kepegawaian\Aktivitas\Form::class)->name('aktivitas.create');
        Route::get('/aktivitas', \App\Livewire\Kepegawaian\Aktivitas\Index::class)->name('aktivitas.index');
        Route::get('/pelatihan', \App\Livewire\Kepegawaian\Pelatihan\Index::class)->name('pelatihan.index');
        Route::get('/presensi', \App\Livewire\Kepegawaian\Presensi\Index::class)->name('presensi.index'); // Absen
        Route::get('/presensi/upacara', \App\Livewire\Kepegawaian\Upacara\Index::class)->name('presensi.upacara.index'); // Upacara (NEW)
        Route::get('/presensi/history', \App\Livewire\Kepegawaian\Presensi\History::class)->name('presensi.history');
        Route::get('/lembur', \App\Livewire\Kepegawaian\Lembur\Index::class)->name('lembur.index'); // Self Request
        Route::get('/gaji', \App\Livewire\Kepegawaian\Gaji\Index::class)->name('gaji.index'); // Self Slip
        Route::get('/gaji/{id}/print', function($id) {
            // Logic Print Slip User
             $gaji = \App\Models\Penggajian::where('user_id', auth()->id())->findOrFail($id);
             return view('print.slip-gaji', compact('gaji'));
        })->name('gaji.print');
        
        // HRIS Advanced Features (New)
        Route::get('/kredensial', \App\Livewire\Kepegawaian\Kredensial\Index::class)->name('kredensial.index');
        Route::get('/diklat', \App\Livewire\Kepegawaian\Diklat\Index::class)->name('diklat.index');
        Route::get('/mutasi-jabatan', \App\Livewire\Kepegawaian\Mutasi\Index::class)->name('mutasi.index');
        Route::get('/inventaris-pegawai', \App\Livewire\Kepegawaian\Aset\Index::class)->name('aset-pegawai.index');
        Route::get('/kinerja-kpi', \App\Livewire\Kepegawaian\Kinerja\Assessment::class)->name('kinerja.assessment');
        Route::get('/offboarding', \App\Livewire\Kepegawaian\Offboarding\Index::class)->name('offboarding.index');
    });

    Route::get('/notifications', \App\Livewire\System\Notification\Index::class)->name('system.notification.index');
    Route::get('/profile', \App\Livewire\Profile\Edit::class)->name('profile.edit');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // === MANAJEMEN KEPEGAWAIAN (ADMIN) ===
    Route::middleware('can:admin')->prefix('hrd')->name('hrd.')->group(function () {
        Route::get('/dashboard', \App\Livewire\Hrd\Dashboard::class)->name('dashboard');
        
        // Komponen Baru (Admin Specific)
        Route::get('/cuti', \App\Livewire\Hrd\Cuti\Index::class)->name('cuti.index'); // Admin Approval
        Route::get('/lembur', \App\Livewire\Hrd\Lembur\Index::class)->name('lembur.index'); // Admin Approval
        Route::get('/presensi', \App\Livewire\Hrd\Presensi\Index::class)->name('presensi.index'); // Monitoring
        
        // Legacy/Shared Components (Jika masih dipakai Admin tapi route beda)
        // Sebaiknya dipindah jika memungkinkan, tapi untuk sekarang kita routing ulang
        // Route::get('/pegawai', ...) -> Tetap di root/admin group bawah
    });

    // ADMIN routes (General) ...
    Route::middleware('can:admin')->group(function () {
        // ... (Route admin lainnya tetap sama)
        Route::get('/security/dashboard', \App\Livewire\Security\Dashboard::class)->name('security.dashboard');
        Route::get('/activity-log', \App\Livewire\Admin\ActivityLog::class)->name('activity-log');
        Route::get('/activity-log/{id}', \App\Livewire\Admin\ActivityLogShow::class)->name('activity-log.show');
        Route::get('/system/dashboard', \App\Livewire\System\Dashboard::class)->name('system.dashboard');
        Route::get('/system/poli', \App\Livewire\System\Poli\Index::class)->name('system.poli.index');
        Route::get('/system/poli/create', \App\Livewire\System\Poli\Create::class)->name('system.poli.create');
        Route::get('/system/poli/{poli}/edit', \App\Livewire\System\Poli\Edit::class)->name('system.poli.edit');
        Route::get('/system/users', \App\Livewire\System\User\Index::class)->name('system.user.index');
        Route::get('/system/settings', \App\Livewire\System\Setting\Index::class)->name('system.setting.index');
        Route::get('/system/roles', \App\Livewire\System\Role\Index::class)->name('system.role.index');
        Route::get('/system/roles/create', \App\Livewire\System\Role\Form::class)->name('system.role.create');
        Route::get('/system/roles/{id}/edit', \App\Livewire\System\Role\Form::class)->name('system.role.edit');
        Route::get('/system/integrations', \App\Livewire\System\Integration\Index::class)->name('system.integration.index');
        Route::get('/system/cms', \App\Livewire\System\Cms\Index::class)->name('system.cms.index'); // New CMS Route
        Route::get('/system/surat-templates', \App\Livewire\Surat\Template\Index::class)->name('system.surat-template.index');
        Route::get('/system/tindakan', \App\Livewire\System\Tindakan\Index::class)->name('system.tindakan.index');
        Route::get('/system/alur-pelayanan', \App\Livewire\System\Alur\Index::class)->name('system.alur.index');
        Route::get('/system/jenis-pelayanan', \App\Livewire\System\JenisPelayanan\Index::class)->name('system.jenis-pelayanan.index'); // New Route
        Route::get('/system/harga-layanan', \App\Livewire\System\Harga\Index::class)->name('system.harga.index');
        // Route::get('/hrd/dashboard', ...) -> Sudah dipindah ke group HRD
        
        // Manajemen Gaji Admin (Proses Gaji)
        Route::get('/kepegawaian/gaji-admin', \App\Livewire\Kepegawaian\Gaji\Index::class)->name('kepegawaian.gaji.admin.index'); // Perlu dicek, ini conflict dengan user?
        // Admin Gaji biasanya "Create Gaji" atau "List Semua Gaji"
        // Kita gunakan route lama tapi rename name-nya biar jelas
        Route::get('/admin/gaji', \App\Livewire\Admin\Gaji\Index::class)->name('admin.gaji.index'); 
        Route::get('/admin/gaji/create', \App\Livewire\Kepegawaian\Gaji\Create::class)->name('admin.gaji.create');
        
        Route::get('/pegawai', \App\Livewire\Pegawai\Index::class)->name('pegawai.index');
        Route::get('/pegawai/create', \App\Livewire\Pegawai\Create::class)->name('pegawai.create');
        Route::get('/pegawai/{pegawai}', \App\Livewire\Pegawai\Show::class)->name('pegawai.edit'); // Dossier View (Edit Unified)
        Route::get('/shift', \App\Livewire\Shift\Index::class)->name('shift.index');
        Route::get('/shift/create', \App\Livewire\Shift\Create::class)->name('shift.create');
        Route::get('/shift/{shift}/edit', \App\Livewire\Shift\Edit::class)->name('shift.edit');
        Route::get('/jadwal-jaga', \App\Livewire\JadwalJaga\Index::class)->name('jadwal-jaga.index');
        Route::get('/jadwal-jaga/create', \App\Livewire\JadwalJaga\Create::class)->name('jadwal-jaga.create');
        Route::get('/jadwal-jaga/{jadwalJaga}/edit', \App\Livewire\JadwalJaga\Edit::class)->name('jadwal-jaga.edit');
        Route::get('/kepegawaian/kinerja', \App\Livewire\Kepegawaian\Kinerja\Index::class)->name('kepegawaian.kinerja.index');
        Route::get('/system/backup', \App\Livewire\System\Backup::class)->name('system.backup');
        Route::get('/admin/berita', \App\Livewire\Admin\Berita\Index::class)->name('admin.berita.index');
        Route::get('/admin/berita/create', \App\Livewire\Admin\Berita\Create::class)->name('admin.berita.create');
        Route::get('/admin/berita/{berita}/edit', \App\Livewire\Admin\Berita\Edit::class)->name('admin.berita.edit');
        Route::get('/admin/fasilitas', \App\Livewire\Admin\Fasilitas\Index::class)->name('admin.fasilitas.index');
        Route::get('/admin/fasilitas/create', \App\Livewire\Admin\Fasilitas\Create::class)->name('admin.fasilitas.create');
        Route::get('/admin/fasilitas/{fasilitas}/edit', \App\Livewire\Admin\Fasilitas\Edit::class)->name('admin.fasilitas.edit');
    });

    // MASYARAKAT
    Route::middleware('can:admin')->group(function () {
        Route::get('/public/dashboard', \App\Livewire\Public\Dashboard::class)->name('public.dashboard');
        Route::get('/masyarakat', \App\Livewire\Masyarakat\Index::class)->name('masyarakat.index');
        Route::get('/masyarakat/pengaduan', \App\Livewire\Admin\Masyarakat\PengaduanIndex::class)->name('admin.masyarakat.pengaduan.index');
        Route::get('/masyarakat/pengaduan/{pengaduan}', \App\Livewire\Admin\Masyarakat\PengaduanShow::class)->name('admin.masyarakat.pengaduan.show');
    });

    // UKM & Lainnya
    Route::middleware('can:tata_usaha')->group(function () {
        Route::get('/ukm/dashboard', \App\Livewire\Ukm\Dashboard::class)->name('ukm.dashboard');
        Route::get('/ukm', \App\Livewire\Ukm\Index::class)->name('ukm.index');
        Route::get('/ukm/create', \App\Livewire\Ukm\Create::class)->name('ukm.create');
        Route::get('/ruangan', \App\Livewire\Ruangan\Index::class)->name('ruangan.index');
        Route::get('/ruangan/create', \App\Livewire\Ruangan\Create::class)->name('ruangan.create');
        Route::get('/ruangan/{ruangan}/edit', \App\Livewire\Ruangan\Edit::class)->name('ruangan.edit');
        Route::get('/supplier', \App\Livewire\Supplier\Index::class)->name('supplier.index');
        Route::get('/supplier/create', \App\Livewire\Supplier\Create::class)->name('supplier.create');
        Route::get('/supplier/{supplier}/edit', \App\Livewire\Supplier\Edit::class)->name('supplier.edit');
        Route::get('/barang/ruangan', \App\Livewire\Barang\Ruangan::class)->name('barang.ruangan');
        Route::get('/pasien', \App\Livewire\Pasien\Index::class)->name('pasien.index');
        Route::get('/pasien/create', \App\Livewire\Pasien\Create::class)->name('pasien.create');
        Route::get('/pasien/{pasien}', \App\Livewire\Pasien\Show::class)->name('pasien.show');
        Route::get('/pasien/{pasien}/edit', \App\Livewire\Pasien\Edit::class)->name('pasien.edit');
        Route::get('/pasien/{pasien}/card', [PasienController::class, 'printCard'])->name('pasien.print-card');
        Route::get('/surat', \App\Livewire\Surat\Index::class)->name('surat.index');
        Route::get('/surat/create', \App\Livewire\Surat\Create::class)->name('surat.create');
        Route::get('/surat/{surat}/edit', \App\Livewire\Surat\Edit::class)->name('surat.edit');
        Route::get('/surat/{surat}/disposisi', \App\Livewire\Surat\Disposisi\Manage::class)->name('surat.disposisi.manage');
        Route::get('/surat/{surat}/print-disposisi', [SuratController::class, 'printDisposition'])->name('surat.print-disposisi');
        Route::get('/antrean', \App\Livewire\Antrean\Index::class)->name('antrean.index');
        Route::get('/finance/dashboard', \App\Livewire\Finance\Dashboard::class)->name('finance.dashboard');
        Route::get('/kasir', \App\Livewire\Kasir\Index::class)->name('kasir.index');
        Route::get('/kasir/{rekamMedis}/process', \App\Livewire\Kasir\Process::class)->name('kasir.process');
        Route::get('/kasir/closing', \App\Livewire\Kasir\Closing::class)->name('kasir.closing');
        Route::get('/kasir/{id}/print', [KasirController::class, 'print'])->name('kasir.print');
        Route::get('/kategori-barang', \App\Livewire\KategoriBarang\Index::class)->name('kategori-barang.index');
        Route::get('/kategori-barang/create', \App\Livewire\KategoriBarang\Create::class)->name('kategori-barang.create');
        Route::get('/kategori-barang/{kategoriBarang}/edit', \App\Livewire\KategoriBarang\Edit::class)->name('kategori-barang.edit');
        Route::get('/barang/dashboard', \App\Livewire\Barang\Dashboard::class)->name('barang.dashboard');
        Route::get('/barang/laporan', \App\Livewire\Barang\Laporan::class)->name('barang.laporan');
        Route::get('/barang/penyusutan', \App\Livewire\Barang\Penyusutan::class)->name('barang.penyusutan');
        Route::get('/barang/penghapusan', \App\Livewire\Barang\Penghapusan\Index::class)->name('barang.penghapusan.index');
        Route::get('/barang/penghapusan/create', \App\Livewire\Barang\Penghapusan\Create::class)->name('barang.penghapusan.create');
        Route::get('/barang', \App\Livewire\Barang\Index::class)->name('barang.index');
        Route::get('/barang/create', \App\Livewire\Barang\Create::class)->name('barang.create');
        Route::get('/barang/opname', \App\Livewire\Barang\OpnameIndex::class)->name('barang.opname.index');
        Route::get('/barang/opname/create', \App\Livewire\Barang\OpnameStart::class)->name('barang.opname.create');
        Route::get('/barang/opname/{opname}/input', \App\Livewire\Barang\OpnameCreate::class)->name('barang.opname.input');
        Route::get('/barang/mutasi/create', \App\Livewire\Barang\Mutasi\Create::class)->name('barang.mutasi.create');
        Route::get('/barang/mutasi', \App\Livewire\Barang\Mutasi\Index::class)->name('barang.mutasi.index');
        Route::get('/barang/mutasi/{mutasi}/print', [\App\Http\Controllers\MutasiController::class, 'print'])->name('barang.mutasi.print');
        Route::get('/barang/penghapusan/{penghapusan}/print', [\App\Http\Controllers\PenghapusanController::class, 'print'])->name('barang.penghapusan.print');
        Route::get('/barang/peminjaman/create', \App\Livewire\Barang\Peminjaman\Create::class)->name('barang.peminjaman.create');
        Route::get('/barang/peminjaman/{peminjaman}/kembali', \App\Livewire\Barang\Peminjaman\Kembali::class)->name('barang.peminjaman.kembali');
        Route::get('/barang/peminjaman', \App\Livewire\Barang\Peminjaman\Index::class)->name('barang.peminjaman.index');
        Route::get('/barang/peminjaman/{peminjaman}/print', [\App\Http\Controllers\PeminjamanController::class, 'print'])->name('barang.peminjaman.print');
        Route::get('/barang/print-labels', \App\Livewire\Barang\PrintLabelsBulk::class)->name('barang.print-labels-bulk');
        Route::get('/barang/maintenance/create', \App\Livewire\Barang\Maintenance\Create::class)->name('barang.maintenance.create');
        Route::get('/barang/maintenance/logs', \App\Livewire\Barang\MaintenanceLog::class)->name('barang.maintenance');
        Route::get('/barang/{barang}/maintenance/create', \App\Livewire\Barang\Maintenance\Create::class)->name('barang.maintenance.create.specific');
        Route::get('/barang/pengadaan', \App\Livewire\Barang\Pengadaan\Index::class)->name('barang.pengadaan.index');
        Route::get('/barang/pengadaan/create', \App\Livewire\Barang\Pengadaan\Create::class)->name('barang.pengadaan.create');
        Route::get('/barang/{barang}/print', \App\Livewire\Barang\PrintLabel::class)->name('barang.print-label');
        Route::get('/barang/{barang}', \App\Livewire\Barang\Show::class)->name('barang.show'); 
        Route::get('/barang/{barang}/edit', \App\Livewire\Barang\Edit::class)->name('barang.edit');
        Route::get('/rawat-inap', \App\Livewire\RawatInap\Index::class)->name('rawat-inap.index');
        Route::get('/rawat-inap/kamar', \App\Livewire\RawatInap\KamarIndex::class)->name('rawat-inap.kamar');
        Route::get('/rawat-inap/create', \App\Livewire\RawatInap\Create::class)->name('rawat-inap.create');
        Route::get('/rawat-inap/{rawatInap}/checkout', \App\Livewire\RawatInap\Checkout::class)->name('rawat-inap.checkout');
        Route::get('/laporan/penyakit', \App\Livewire\Laporan\Penyakit::class)->name('laporan.penyakit');
    });

    // MEDIS
    Route::middleware('can:medis')->group(function () {
        Route::get('/medical/dashboard', \App\Livewire\Medical\Dashboard::class)->name('medical.dashboard');
        Route::get('/rekam-medis', \App\Livewire\RekamMedis\Index::class)->name('rekam-medis.index');
        Route::get('/rekam-medis/create', \App\Livewire\RekamMedis\Create::class)->name('rekam-medis.create');
        Route::get('/rekam-medis/{rekamMedis}', \App\Livewire\RekamMedis\Show::class)->name('rekam-medis.show');
        Route::get('/penyakit/icd10', \App\Livewire\Medical\Penyakit\Index::class)->name('medical.penyakit.index');
        Route::get('/surat/keterangan', \App\Livewire\Surat\Keterangan\Index::class)->name('surat.keterangan.index');
        Route::get('/surat/keterangan/{surat}/print', [\App\Http\Controllers\SuratKeteranganController::class, 'print'])->name('surat.print-keterangan');
    });

    // FARMASI
    Route::middleware('can:farmasi')->group(function () {
        Route::get('/pharmacy/dashboard', \App\Livewire\Pharmacy\Dashboard::class)->name('pharmacy.dashboard');
        Route::get('/obat', \App\Livewire\Obat\Index::class)->name('obat.index');
        Route::get('/obat/create', \App\Livewire\Obat\Create::class)->name('obat.create');
        Route::get('/obat/stock-opname', \App\Livewire\Obat\StockOpname::class)->name('obat.stock-opname');
        Route::get('/obat/{obat}/kartu-stok', \App\Livewire\Obat\KartuStok::class)->name('obat.kartu-stok');
        Route::get('/obat/{obat}/edit', \App\Livewire\Obat\Edit::class)->name('obat.edit');
        Route::resource('transaksi-obat', TransaksiObatController::class);
        Route::get('/apotek', \App\Livewire\Apotek\Index::class)->name('apotek.index');
        Route::get('/apotek/{rekamMedis}/process', \App\Livewire\Apotek\Process::class)->name('apotek.process');
        Route::get('/apotek/{rekamMedis}/print-etiket', [\App\Http\Controllers\ApotekController::class, 'printEtiket'])->name('apotek.print-etiket');
        Route::get('/laporan/lplpo', \App\Livewire\Laporan\Lplpo::class)->name('laporan.lplpo');
        Route::get('/laporan/narkotika', \App\Livewire\Laporan\Narkotika::class)->name('laporan.narkotika');
    });

    Route::middleware('can:tata_usaha')->group(function () {
        Route::get('/laporan', \App\Livewire\Laporan\Index::class)->name('laporan.index');
    });
});

require __DIR__.'/auth.php';