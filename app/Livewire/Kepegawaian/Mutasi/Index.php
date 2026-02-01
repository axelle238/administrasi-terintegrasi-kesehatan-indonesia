<?php

namespace App\Livewire\Kepegawaian\Mutasi;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\RiwayatJabatan;
use App\Models\Pegawai;
use App\Models\Poli;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class Index extends Component
{
    use WithPagination;

    public $filterStatus = 'Pending'; // Pending, Disetujui, Ditolak
    
    // Form State
    public $isCreating = false;
    
    // Form Fields
    public $pegawai_id;
    public $jenis_perubahan;
    public $jabatan_baru;
    public $unit_kerja_baru;
    public $tanggal_efektif;
    public $nomor_sk;
    public $keterangan;

    public function render()
    {
        $mutasis = RiwayatJabatan::with('pegawai.user')
            ->where('status_pengajuan', $this->filterStatus)
            ->latest()
            ->paginate(10);

        return view('livewire.kepegawaian.mutasi.index', [
            'mutasis' => $mutasis,
            'pegawais' => Pegawai::with('user')->orderBy('jabatan')->get(),
            'polis' => Poli::all(), // Untuk unit kerja
            'countPending' => RiwayatJabatan::where('status_pengajuan', 'Pending')->count(),
        ])->layout('layouts.app', ['header' => 'Manajemen Karir & Mutasi']);
    }

    public function create()
    {
        $this->resetForm();
        $this->isCreating = true;
    }

    public function save()
    {
        $this->validate([
            'pegawai_id' => 'required',
            'jenis_perubahan' => 'required',
            'jabatan_baru' => 'required',
            'unit_kerja_baru' => 'required',
            'tanggal_efektif' => 'required|date',
        ]);

        $pegawai = Pegawai::find($this->pegawai_id);

        RiwayatJabatan::create([
            'pegawai_id' => $this->pegawai_id,
            'jenis_perubahan' => $this->jenis_perubahan,
            'jabatan_lama' => $pegawai->jabatan,
            'jabatan_baru' => $this->jabatan_baru,
            'unit_kerja_lama' => $pegawai->poli->nama_poli ?? 'Umum',
            'unit_kerja_baru' => $this->unit_kerja_baru,
            'tanggal_efektif' => $this->tanggal_efektif,
            'nomor_sk' => $this->nomor_sk,
            'keterangan' => $this->keterangan,
            'status_pengajuan' => 'Pending', // Default butuh approval
        ]);

        $this->isCreating = false;
        $this->resetForm();
        $this->dispatch('notify', 'success', 'Pengajuan mutasi berhasil dibuat. Menunggu persetujuan.');
    }

    public function approve($id)
    {
        $mutasi = RiwayatJabatan::findOrFail($id);
        
        DB::transaction(function() use ($mutasi) {
            // 1. Update Status Mutasi
            $mutasi->update([
                'status_pengajuan' => 'Disetujui',
                'approved_by' => Auth::id()
            ]);

            // 2. Update Data Pegawai (Hanya jika tanggal efektif <= hari ini)
            // Jika future date, bisa pakai Job Scheduler (Advanced)
            // Untuk sekarang kita asumsikan update langsung jika disetujui
            $pegawai = Pegawai::find($mutasi->pegawai_id);
            $pegawai->update([
                'jabatan' => $mutasi->jabatan_baru,
                // Logic update poli_id berdasarkan nama unit kerja bisa ditambahkan disini
            ]);
        });

        $this->dispatch('notify', 'success', 'Mutasi disetujui & data pegawai diperbarui.');
    }

    public function reject($id)
    {
        $mutasi = RiwayatJabatan::findOrFail($id);
        $mutasi->update([
            'status_pengajuan' => 'Ditolak',
            'approved_by' => Auth::id()
        ]);
        
        $this->dispatch('notify', 'error', 'Pengajuan mutasi ditolak.');
    }

    public function cancel()
    {
        $this->isCreating = false;
        $this->resetForm();
    }

    private function resetForm()
    {
        $this->reset(['pegawai_id', 'jenis_perubahan', 'jabatan_baru', 'unit_kerja_baru', 'tanggal_efektif', 'nomor_sk', 'keterangan']);
    }
}