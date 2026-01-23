<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\TransaksiObatController;
use App\Http\Controllers\SuratController;
use App\Http\Controllers\PasienController;
use App\Http\Controllers\KasirController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', \App\Livewire\Dashboard::class)->middleware(['auth', 'verified'])->name('dashboard');
Route::get('/antrean/monitor', \App\Livewire\Antrean\Monitor::class)->name('antrean.monitor');
Route::get('/kiosk', \App\Livewire\Antrean\Kiosk::class)->name('antrean.kiosk'); // Self-service
Route::get('/survey', \App\Livewire\Survey\Create::class)->name('survey.create');

Route::middleware('auth')->group(function () {
    Route::get('/profile', \App\Livewire\Profile\Edit::class)->name('profile.edit');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::get('/kepegawaian/cuti', \App\Livewire\Kepegawaian\Cuti\Index::class)->name('kepegawaian.cuti.index');

    // ADMIN
    Route::middleware('can:admin')->group(function () {
        Route::get('/activity-log', \App\Livewire\Admin\ActivityLog::class)->name('activity-log');
        Route::get('/system/poli', \App\Livewire\System\Poli\Index::class)->name('system.poli.index');
        Route::get('/system/users', \App\Livewire\System\User\Index::class)->name('system.user.index');
        Route::get('/system/settings', \App\Livewire\System\Setting\Index::class)->name('system.setting.index');
        Route::get('/system/surat-templates', \App\Livewire\Surat\Template\Index::class)->name('system.surat-template.index');
        Route::get('/system/tindakan', \App\Livewire\System\Tindakan\Index::class)->name('system.tindakan.index');
        Route::get('/kepegawaian/gaji', \App\Livewire\Kepegawaian\Gaji\Index::class)->name('kepegawaian.gaji.index');
        Route::get('/pegawai', \App\Livewire\Pegawai\Index::class)->name('pegawai.index');
        Route::get('/pegawai/create', \App\Livewire\Pegawai\Create::class)->name('pegawai.create');
        Route::get('/pegawai/{pegawai}/edit', \App\Livewire\Pegawai\Edit::class)->name('pegawai.edit');
        Route::get('/shift', \App\Livewire\Shift\Index::class)->name('shift.index');
        Route::get('/shift/create', \App\Livewire\Shift\Create::class)->name('shift.create');
        Route::get('/shift/{shift}/edit', \App\Livewire\Shift\Edit::class)->name('shift.edit');
        Route::get('/jadwal-jaga', \App\Livewire\JadwalJaga\Index::class)->name('jadwal-jaga.index');
        Route::get('/jadwal-jaga/create', \App\Livewire\JadwalJaga\Create::class)->name('jadwal-jaga.create');
        Route::get('/jadwal-jaga/{jadwalJaga}/edit', \App\Livewire\JadwalJaga\Edit::class)->name('jadwal-jaga.edit');
        // Kinerja
        Route::get('/kepegawaian/kinerja', \App\Livewire\Kepegawaian\Kinerja\Index::class)->name('kepegawaian.kinerja.index');
        
        // System Internal
        Route::get('/system/backup', \App\Livewire\System\Backup::class)->name('system.backup');
    });

    // UKM & Lainnya (Bisa diakses Staf/Kapus)
    Route::middleware('can:tata_usaha')->group(function () {
        Route::get('/ukm', \App\Livewire\Ukm\Index::class)->name('ukm.index');
        Route::get('/barang/ruangan', \App\Livewire\Barang\Ruangan::class)->name('barang.ruangan');
        Route::get('/pasien', \App\Livewire\Pasien\Index::class)->name('pasien.index');
        Route::get('/pasien/create', \App\Livewire\Pasien\Create::class)->name('pasien.create');
        Route::get('/pasien/{pasien}', \App\Livewire\Pasien\Show::class)->name('pasien.show');
        Route::get('/pasien/{pasien}/edit', \App\Livewire\Pasien\Edit::class)->name('pasien.edit');
        Route::get('/pasien/{pasien}/card', [PasienController::class, 'printCard'])->name('pasien.print-card');
        Route::get('/surat', \App\Livewire\Surat\Index::class)->name('surat.index');
        Route::get('/surat/create', \App\Livewire\Surat\Create::class)->name('surat.create');
        Route::get('/surat/{surat}/edit', \App\Livewire\Surat\Edit::class)->name('surat.edit');
        Route::get('/surat/{surat}/print-disposisi', [SuratController::class, 'printDisposition'])->name('surat.print-disposisi');
        Route::get('/antrean', \App\Livewire\Antrean\Index::class)->name('antrean.index');
        Route::get('/kasir', \App\Livewire\Kasir\Index::class)->name('kasir.index');
        Route::get('/kasir/{rekamMedis}/process', \App\Livewire\Kasir\Process::class)->name('kasir.process');
        Route::get('/kasir/closing', \App\Livewire\Kasir\Closing::class)->name('kasir.closing');
        Route::get('/kasir/{id}/print', [KasirController::class, 'print'])->name('kasir.print');
        Route::get('/kategori-barang', \App\Livewire\KategoriBarang\Index::class)->name('kategori-barang.index');
        Route::get('/kategori-barang/create', \App\Livewire\KategoriBarang\Create::class)->name('kategori-barang.create');
        Route::get('/kategori-barang/{kategoriBarang}/edit', \App\Livewire\KategoriBarang\Edit::class)->name('kategori-barang.edit');
        
        // Inventory Dashboard
        Route::get('/barang/dashboard', \App\Livewire\Barang\Dashboard::class)->name('barang.dashboard');
        Route::get('/barang/laporan', \App\Livewire\Barang\Laporan::class)->name('barang.laporan');
        
        Route::get('/barang', \App\Livewire\Barang\Index::class)->name('barang.index');
        Route::get('/barang/create', \App\Livewire\Barang\Create::class)->name('barang.create');
        // Opname Routes
        Route::get('/barang/opname', \App\Livewire\Barang\OpnameIndex::class)->name('barang.opname.index');
        Route::get('/barang/opname/create', \App\Livewire\Barang\OpnameCreate::class)->name('barang.opname.create');
        
        Route::get('/barang/{barang}/print', \App\Livewire\Barang\PrintLabel::class)->name('barang.print-label');
        Route::get('/barang/{barang}', \App\Livewire\Barang\Show::class)->name('barang.show'); 
        Route::get('/barang/{barang}/edit', \App\Livewire\Barang\Edit::class)->name('barang.edit');
        Route::get('/barang/maintenance/logs', \App\Livewire\Barang\MaintenanceLog::class)->name('barang.maintenance');
        Route::get('/barang/pengadaan', \App\Livewire\Barang\Pengadaan\Index::class)->name('barang.pengadaan.index');
        Route::get('/barang/pengadaan/create', \App\Livewire\Barang\Pengadaan\Create::class)->name('barang.pengadaan.create');
        Route::get('/rawat-inap', \App\Livewire\RawatInap\Index::class)->name('rawat-inap.index');
        Route::get('/rawat-inap/kamar', \App\Livewire\RawatInap\KamarIndex::class)->name('rawat-inap.kamar');
        Route::get('/laporan/penyakit', \App\Livewire\Laporan\Penyakit::class)->name('laporan.penyakit');
    });

    // MEDIS
    Route::middleware('can:medis')->group(function () {
        Route::get('/rekam-medis', \App\Livewire\RekamMedis\Index::class)->name('rekam-medis.index');
        Route::get('/rekam-medis/create', \App\Livewire\RekamMedis\Create::class)->name('rekam-medis.create');
        Route::get('/rekam-medis/{rekamMedis}', \App\Livewire\RekamMedis\Show::class)->name('rekam-medis.show');
        Route::get('/surat/keterangan', \App\Livewire\Surat\Keterangan\Index::class)->name('surat.keterangan.index');
        Route::get('/surat/keterangan/{surat}/print', [\App\Http\Controllers\SuratKeteranganController::class, 'print'])->name('surat.print-keterangan');
    });

    // FARMASI
    Route::middleware('can:farmasi')->group(function () {
        Route::get('/obat', \App\Livewire\Obat\Index::class)->name('obat.index');
        Route::get('/obat/create', \App\Livewire\Obat\Create::class)->name('obat.create');
        Route::get('/obat/stock-opname', \App\Livewire\Obat\StockOpname::class)->name('obat.stock-opname');
        
        // NEW: Kartu Stok Route
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
