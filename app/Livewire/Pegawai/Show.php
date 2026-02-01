<?php

namespace App\Livewire\Pegawai;

use Livewire\Component;
use Livewire\WithFileUploads;
use App\Models\Pegawai;
use App\Models\User;
use App\Models\KeluargaPegawai;
use App\Models\RiwayatJabatanPegawai;
use App\Models\RiwayatPendidikanPegawai;
use App\Models\DokumenPegawai;
use App\Models\Poli;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;

class Show extends Component
{
    use WithFileUploads;

    public Pegawai $pegawai;
    public $activeTab = 'profil';
    
    // === Data Master (Dropdowns) ===
    public $polis;

    // === Form States (Toggle Visibility) ===
    public $isEditingProfil = false;
    public $showKeluargaForm = false;
    public $showPendidikanForm = false;
    public $showKarirForm = false;
    public $showDokumenForm = false;

    // === Profil Form Binding (Langsung ke Model Pegawai tidak disarankan untuk deep nesting, jadi kita mapping manual atau pakai rules)
    // Kita gunakan property terpisah untuk editing agar aman
    public $formProfil = [];

    // === Keluarga Form ===
    public $formKeluarga = [
        'nama' => '', 'nik' => '', 'hubungan' => 'Istri', 'tanggal_lahir' => '', 
        'jenis_kelamin' => 'P', 'pekerjaan' => '', 'status_tunjangan' => false
    ];

    // === Pendidikan Form ===
    public $formPendidikan = [
        'jenjang' => 'S1', 'nama_institusi' => '', 'jurusan' => '', 
        'tahun_lulus' => '', 'ipk' => '', 'nomor_ijazah' => ''
    ];

    // === Dokumen Form ===
    public $formDokumen = [
        'nama_dokumen' => '', 'kategori_dokumen' => 'Identitas', 
        'tipe_file' => '', 'tanggal_kadaluarsa' => '', 'keterangan' => ''
    ];
    public $uploadFile; // Temporary upload

    // === Karir Form ===
    public $formKarir = [
        'jenis_mutasi' => 'Promosi', 'jabatan_baru' => '', 'unit_kerja_baru' => '', 
        'tanggal_mulai' => '', 'nomor_sk' => '', 'keterangan' => ''
    ];

    protected $listeners = ['refreshDossier' => '$refresh'];

    protected $queryString = ['activeTab' => ['except' => 'profil']];

    public function mount(Pegawai $pegawai)
    {
        $this->pegawai = $pegawai->load([
            'user', 'poli', 'keluarga', 'riwayatJabatan', 'pendidikan', 'dokumen'
        ]);
        
        $this->polis = Poli::all();
        $this->initFormProfil();
    }

    public function setTab($tab)
    {
        $this->activeTab = $tab;
    }

    // ==========================================
    // 1. LOGIKA PROFIL
    // ==========================================
    
    public function initFormProfil()
    {
        $p = $this->pegawai;
        $this->formProfil = [
            // Identitas
            'nik' => $p->nik,
            'kk' => $p->kk,
            'nama' => $p->user->name,
            'email' => $p->user->email,
            'nip' => $p->nip,
            'tempat_lahir' => $p->tempat_lahir,
            'tanggal_lahir' => $p->tanggal_lahir,
            'jenis_kelamin' => $p->jenis_kelamin,
            'agama' => $p->agama,
            'golongan_darah' => $p->golongan_darah,
            'status_pernikahan' => $p->status_pernikahan,
            'alamat' => $p->alamat,
            'no_telepon' => $p->no_telepon,
            
            // Kepegawaian
            'jabatan' => $p->jabatan,
            'poli_id' => $p->poli_id,
            'status_kepegawaian' => $p->status_kepegawaian,
            'tanggal_masuk' => $p->tanggal_masuk,
            'npwp' => $p->npwp,
            
            // Keuangan
            'nama_bank' => $p->nama_bank,
            'nomor_rekening' => $p->nomor_rekening,
            'pemilik_rekening' => $p->pemilik_rekening,
            'no_bpjs_kesehatan' => $p->no_bpjs_kesehatan,
            'no_bpjs_ketenagakerjaan' => $p->no_bpjs_ketenagakerjaan,

            // Darurat
            'kontak_darurat_nama' => $p->kontak_darurat_nama,
            'kontak_darurat_relasi' => $p->kontak_darurat_relasi,
            'kontak_darurat_telp' => $p->kontak_darurat_telp,
        ];
    }

    public function toggleEditProfil()
    {
        $this->isEditingProfil = !$this->isEditingProfil;
        if (!$this->isEditingProfil) $this->initFormProfil(); // Reset jika cancel
    }

    public function updateProfil()
    {
        $this->validate([
            'formProfil.nama' => 'required|string|max:255',
            'formProfil.email' => ['required', 'email', Rule::unique('users', 'email')->ignore($this->pegawai->user_id)],
            'formProfil.nik' => ['nullable', 'numeric', Rule::unique('pegawais', 'nik')->ignore($this->pegawai->id)],
            'formProfil.nip' => ['required', Rule::unique('pegawais', 'nip')->ignore($this->pegawai->id)],
        ]);

        DB::transaction(function () {
            // Update User
            $this->pegawai->user->update([
                'name' => $this->formProfil['nama'],
                'email' => $this->formProfil['email'],
            ]);

            // Update Pegawai
            $this->pegawai->update([
                'nik' => $this->formProfil['nik'],
                'kk' => $this->formProfil['kk'],
                'nip' => $this->formProfil['nip'],
                'tempat_lahir' => $this->formProfil['tempat_lahir'],
                'tanggal_lahir' => $this->formProfil['tanggal_lahir'],
                'jenis_kelamin' => $this->formProfil['jenis_kelamin'],
                'agama' => $this->formProfil['agama'],
                'golongan_darah' => $this->formProfil['golongan_darah'],
                'status_pernikahan' => $this->formProfil['status_pernikahan'],
                'alamat' => $this->formProfil['alamat'],
                'no_telepon' => $this->formProfil['no_telepon'],
                'jabatan' => $this->formProfil['jabatan'],
                'poli_id' => $this->formProfil['poli_id'],
                'status_kepegawaian' => $this->formProfil['status_kepegawaian'],
                'tanggal_masuk' => $this->formProfil['tanggal_masuk'],
                'npwp' => $this->formProfil['npwp'],
                'nama_bank' => $this->formProfil['nama_bank'],
                'nomor_rekening' => $this->formProfil['nomor_rekening'],
                'pemilik_rekening' => $this->formProfil['pemilik_rekening'],
                'no_bpjs_kesehatan' => $this->formProfil['no_bpjs_kesehatan'],
                'no_bpjs_ketenagakerjaan' => $this->formProfil['no_bpjs_ketenagakerjaan'],
                'kontak_darurat_nama' => $this->formProfil['kontak_darurat_nama'],
                'kontak_darurat_relasi' => $this->formProfil['kontak_darurat_relasi'],
                'kontak_darurat_telp' => $this->formProfil['kontak_darurat_telp'],
            ]);
        });

        $this->isEditingProfil = false;
        $this->dispatch('notify', 'success', 'Profil pegawai berhasil diperbarui.');
    }

    // ==========================================
    // 2. LOGIKA KELUARGA
    // ==========================================

    public function saveKeluarga()
    {
        $this->validate([
            'formKeluarga.nama' => 'required',
            'formKeluarga.hubungan' => 'required',
        ]);

        KeluargaPegawai::create([
            'pegawai_id' => $this->pegawai->id,
            'nama' => $this->formKeluarga['nama'],
            'nik' => $this->formKeluarga['nik'],
            'hubungan' => $this->formKeluarga['hubungan'],
            'tanggal_lahir' => $this->formKeluarga['tanggal_lahir'],
            'jenis_kelamin' => $this->formKeluarga['jenis_kelamin'],
            'pekerjaan' => $this->formKeluarga['pekerjaan'],
            'status_tunjangan' => $this->formKeluarga['status_tunjangan'] ?? false,
        ]);

        $this->showKeluargaForm = false;
        $this->reset('formKeluarga');
        $this->pegawai->load('keluarga');
        $this->dispatch('notify', 'success', 'Anggota keluarga ditambahkan.');
    }

    public function deleteKeluarga($id)
    {
        KeluargaPegawai::findOrFail($id)->delete();
        $this->pegawai->load('keluarga');
        $this->dispatch('notify', 'success', 'Data keluarga dihapus.');
    }

    // ==========================================
    // 3. LOGIKA PENDIDIKAN
    // ==========================================

    public function savePendidikan()
    {
        $this->validate([
            'formPendidikan.nama_institusi' => 'required',
            'formPendidikan.jenjang' => 'required',
            'formPendidikan.tahun_lulus' => 'required|numeric',
        ]);

        RiwayatPendidikanPegawai::create([
            'pegawai_id' => $this->pegawai->id,
            'jenjang' => $this->formPendidikan['jenjang'],
            'nama_institusi' => $this->formPendidikan['nama_institusi'],
            'jurusan' => $this->formPendidikan['jurusan'],
            'tahun_lulus' => $this->formPendidikan['tahun_lulus'],
            'ipk' => $this->formPendidikan['ipk'],
            'nomor_ijazah' => $this->formPendidikan['nomor_ijazah'],
        ]);

        $this->showPendidikanForm = false;
        $this->reset('formPendidikan');
        $this->pegawai->load('pendidikan');
        $this->dispatch('notify', 'success', 'Riwayat pendidikan ditambahkan.');
    }

    public function deletePendidikan($id)
    {
        RiwayatPendidikanPegawai::findOrFail($id)->delete();
        $this->pegawai->load('pendidikan');
        $this->dispatch('notify', 'success', 'Riwayat pendidikan dihapus.');
    }

    // ==========================================
    // 4. LOGIKA DOKUMEN
    // ==========================================

    public function saveDokumen()
    {
        $this->validate([
            'formDokumen.nama_dokumen' => 'required',
            'uploadFile' => 'required|file|max:5120', // Max 5MB
        ]);

        $path = $this->uploadFile->store('dokumen_pegawai', 'public');

        DokumenPegawai::create([
            'pegawai_id' => $this->pegawai->id,
            'nama_dokumen' => $this->formDokumen['nama_dokumen'],
            'kategori_dokumen' => $this->formDokumen['kategori_dokumen'],
            'file_path' => $path,
            'tipe_file' => $this->uploadFile->extension(),
            'tanggal_kadaluarsa' => $this->formDokumen['tanggal_kadaluarsa'],
            'keterangan' => $this->formDokumen['keterangan'],
        ]);

        $this->showDokumenForm = false;
        $this->reset('formDokumen', 'uploadFile');
        $this->pegawai->load('dokumen');
        $this->dispatch('notify', 'success', 'Dokumen berhasil diunggah.');
    }

    public function deleteDokumen($id)
    {
        $doc = DokumenPegawai::findOrFail($id);
        if(Storage::disk('public')->exists($doc->file_path)) {
            Storage::disk('public')->delete($doc->file_path);
        }
        $doc->delete();
        $this->pegawai->load('dokumen');
        $this->dispatch('notify', 'success', 'Dokumen dihapus.');
    }

    // ==========================================
    // 5. LOGIKA KARIR
    // ==========================================

    public function saveKarir()
    {
        $this->validate([
            'formKarir.jabatan_baru' => 'required',
            'formKarir.tanggal_mulai' => 'required|date',
        ]);

        DB::transaction(function() {
            // Catat history
            RiwayatJabatanPegawai::create([
                'pegawai_id' => $this->pegawai->id,
                'jenis_mutasi' => $this->formKarir['jenis_mutasi'],
                'jabatan_baru' => $this->formKarir['jabatan_baru'],
                'unit_kerja_baru' => $this->formKarir['unit_kerja_baru'],
                'nomor_sk' => $this->formKarir['nomor_sk'],
                'tanggal_mulai' => $this->formKarir['tanggal_mulai'],
                'keterangan' => $this->formKarir['keterangan'],
            ]);

            // Update Master Data
            $this->pegawai->update([
                'jabatan' => $this->formKarir['jabatan_baru'],
            ]);
            
            // Opsional: Update Poli jika unit kerja berubah dan poli ada
            // Disini kita biarkan manual di profil utama agar lebih terkontrol
        });

        $this->showKarirForm = false;
        $this->reset('formKarir');
        $this->pegawai->load('riwayatJabatan');
        $this->initFormProfil(); // Refresh data form profil karena jabatan berubah
        $this->dispatch('notify', 'success', 'Riwayat karir dicatat & jabatan diperbarui.');
    }

    public function render()
    {
        return view('livewire.pegawai.show', [
            'age' => $this->pegawai->tanggal_lahir ? Carbon::parse($this->pegawai->tanggal_lahir)->age : '-',
            'masa_kerja' => $this->pegawai->tanggal_masuk ? Carbon::parse($this->pegawai->tanggal_masuk)->diffForHumans(null, true) : '-'
        ])->layout('layouts.app', ['header' => 'Dossier Pegawai Digital']);
    }
}