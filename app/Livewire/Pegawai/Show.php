<?php

namespace App\Livewire\Pegawai;

use Livewire\Component;
use Livewire\WithFileUploads;
use App\Models\Pegawai;
use App\Models\KeluargaPegawai;
use App\Models\RiwayatJabatan;
use App\Models\RiwayatPendidikan;
use App\Models\Pelanggaran;
use Illuminate\Support\Facades\DB;

class Show extends Component
{
    use WithFileUploads;

    public $pegawai;
    public $activeTab = 'profil';
    
    // --- State Form Inline ---
    public $showKeluargaForm = false;
    public $showPendidikanForm = false;
    public $showKarirForm = false;
    public $showPelanggaranForm = false;

    // --- Model Binding Forms ---
    // Keluarga
    public $keluarga_nama, $keluarga_hubungan, $keluarga_nik, $keluarga_tgl_lahir, $keluarga_bpjs = false;
    
    // Pendidikan
    public $pendidikan_jenjang, $pendidikan_institusi, $pendidikan_jurusan, $pendidikan_tahun;
    
    // Karir
    public $karir_jenis, $karir_jabatan, $karir_unit, $karir_tgl, $karir_sk;
    
    // Pelanggaran
    public $sanksi_jenis, $sanksi_tingkat, $sanksi_tgl, $sanksi_desc;

    protected $listeners = ['refreshDossier' => '$refresh'];

    public function mount($pegawai)
    {
        // Route binding otomatis akan mengisi $pegawai jika type-hinted di method render atau injection
        // Tapi karena kita pakai parameter 'pegawai' di route, kita load manual/auto
        $this->pegawai = Pegawai::with([
            'user', 
            'poli', 
            'keluarga', 
            'riwayatKarir', 
            'pendidikan', 
            'pelanggaran'
        ])->findOrFail($pegawai->id);
    }

    public function setTab($tab)
    {
        $this->activeTab = $tab;
    }

    // === LOGIC KELUARGA ===
    public function saveKeluarga()
    {
        $this->validate([
            'keluarga_nama' => 'required',
            'keluarga_hubungan' => 'required',
        ]);

        KeluargaPegawai::create([
            'pegawai_id' => $this->pegawai->id,
            'nama' => $this->keluarga_nama,
            'hubungan' => $this->keluarga_hubungan,
            'nik' => $this->keluarga_nik,
            'tanggal_lahir' => $this->keluarga_tgl_lahir,
            'tertanggung_bpjs' => $this->keluarga_bpjs
        ]);

        $this->reset(['keluarga_nama', 'keluarga_hubungan', 'keluarga_nik', 'keluarga_tgl_lahir', 'keluarga_bpjs']);
        $this->showKeluargaForm = false;
        $this->pegawai->refresh();
        $this->dispatch('notify', 'success', 'Data keluarga berhasil ditambahkan.');
    }

    public function deleteKeluarga($id)
    {
        KeluargaPegawai::find($id)->delete();
        $this->pegawai->refresh();
        $this->dispatch('notify', 'success', 'Data keluarga dihapus.');
    }

    // === LOGIC PENDIDIKAN ===
    public function savePendidikan()
    {
        $this->validate([
            'pendidikan_jenjang' => 'required',
            'pendidikan_institusi' => 'required',
            'pendidikan_tahun' => 'required|numeric',
        ]);

        RiwayatPendidikan::create([
            'pegawai_id' => $this->pegawai->id,
            'jenjang' => $this->pendidikan_jenjang,
            'institusi' => $this->pendidikan_institusi,
            'jurusan' => $this->pendidikan_jurusan,
            'tahun_lulus' => $this->pendidikan_tahun
        ]);

        $this->reset(['pendidikan_jenjang', 'pendidikan_institusi', 'pendidikan_jurusan', 'pendidikan_tahun']);
        $this->showPendidikanForm = false;
        $this->pegawai->refresh();
        $this->dispatch('notify', 'success', 'Riwayat pendidikan berhasil ditambahkan.');
    }

    // === LOGIC KARIR (MUTASI/PROMOSI) ===
    public function saveKarir()
    {
        $this->validate([
            'karir_jenis' => 'required',
            'karir_jabatan' => 'required',
            'karir_tgl' => 'required|date',
        ]);

        // Simpan Jabatan Lama
        $jabatanLama = $this->pegawai->jabatan;
        $unitLama = $this->pegawai->poli->nama_poli ?? 'Umum';

        DB::transaction(function() use ($jabatanLama, $unitLama) {
            RiwayatJabatan::create([
                'pegawai_id' => $this->pegawai->id,
                'jenis_perubahan' => $this->karir_jenis,
                'jabatan_lama' => $jabatanLama,
                'jabatan_baru' => $this->karir_jabatan,
                'unit_kerja_lama' => $unitLama,
                'unit_kerja_baru' => $this->karir_unit ?? '-',
                'tanggal_efektif' => $this->karir_tgl,
                'nomor_sk' => $this->karir_sk
            ]);

            // Update Master Pegawai
            $this->pegawai->update([
                'jabatan' => $this->karir_jabatan,
                // Logic update unit/poli jika diperlukan bisa disini
            ]);
        });

        $this->reset(['karir_jenis', 'karir_jabatan', 'karir_unit', 'karir_tgl', 'karir_sk']);
        $this->showKarirForm = false;
        $this->pegawai->refresh();
        $this->dispatch('notify', 'success', 'Riwayat karir & jabatan pegawai diperbarui.');
    }

    // === LOGIC PELANGGARAN ===
    public function savePelanggaran()
    {
        $this->validate([
            'sanksi_jenis' => 'required',
            'sanksi_tingkat' => 'required',
            'sanksi_tgl' => 'required|date',
            'sanksi_desc' => 'required'
        ]);

        Pelanggaran::create([
            'pegawai_id' => $this->pegawai->id,
            'jenis_pelanggaran' => $this->sanksi_jenis,
            'tingkat_sanksi' => $this->sanksi_tingkat,
            'tanggal_kejadian' => $this->sanksi_tgl,
            'deskripsi_kejadian' => $this->sanksi_desc,
            'status' => 'Aktif'
        ]);

        $this->reset(['sanksi_jenis', 'sanksi_tingkat', 'sanksi_tgl', 'sanksi_desc']);
        $this->showPelanggaranForm = false;
        $this->pegawai->refresh();
        $this->dispatch('notify', 'warning', 'Catatan pelanggaran ditambahkan ke rekam jejak.');
    }

    public function render()
    {
        return view('livewire.pegawai.show')->layout('layouts.app', ['header' => 'File Digital Pegawai']);
    }
}