<?php

namespace App\Livewire\Kepegawaian\Offboarding;

use Livewire\Component;
use Livewire\WithPagination;
use Livewire\WithFileUploads;
use App\Models\PengajuanBerhenti;
use App\Models\Pegawai;
use Illuminate\Support\Facades\Storage;

class Index extends Component
{
    use WithPagination;
    use WithFileUploads;

    public $filterStatus = 'Pending';
    
    // Form
    public $isCreating = false;
    public $pegawai_id;
    public $jenis_berhenti = 'Resign';
    public $tanggal_pengajuan;
    public $tanggal_efektif_keluar;
    public $alasan;
    public $file_surat;

    // Clearance
    public $selectedPengajuanId;
    public $clearance_aset = false;
    public $clearance_keuangan = false;
    public $clearance_dokumen = false;
    public $catatan_hrd;

    public function render()
    {
        $pengajuans = PengajuanBerhenti::with('pegawai.user')
            ->where('status_approval', $this->filterStatus)
            ->latest()
            ->paginate(10);

        return view('livewire.kepegawaian.offboarding.index', [
            'pengajuans' => $pengajuans,
            'pegawais' => Pegawai::with('user')->where('status_kepegawaian', '!=', 'Resign')->orderBy('jabatan')->get(),
        ])->layout('layouts.app', ['header' => 'Manajemen Terminasi & Offboarding']);
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
            'jenis_berhenti' => 'required',
            'tanggal_pengajuan' => 'required|date',
            'tanggal_efektif_keluar' => 'required|date|after:tanggal_pengajuan',
            'alasan' => 'required',
            'file_surat' => 'nullable|file|max:2048|mimes:pdf,jpg,png'
        ]);

        $path = $this->file_surat ? $this->file_surat->store('offboarding', 'public') : null;

        PengajuanBerhenti::create([
            'pegawai_id' => $this->pegawai_id,
            'jenis_berhenti' => $this->jenis_berhenti,
            'tanggal_pengajuan' => $this->tanggal_pengajuan,
            'tanggal_efektif_keluar' => $this->tanggal_efektif_keluar,
            'alasan' => $this->alasan,
            'file_surat' => $path,
            'status_approval' => 'Pending'
        ]);

        $this->isCreating = false;
        $this->resetForm();
        $this->dispatch('notify', 'success', 'Pengajuan berhenti diproses.');
    }

    public function openClearance($id)
    {
        $p = PengajuanBerhenti::findOrFail($id);
        $this->selectedPengajuanId = $id;
        $this->clearance_aset = $p->clearance_aset;
        $this->clearance_keuangan = $p->clearance_keuangan;
        $this->clearance_dokumen = $p->clearance_dokumen;
        $this->catatan_hrd = $p->catatan_hrd;
    }

    public function approve()
    {
        $p = PengajuanBerhenti::findOrFail($this->selectedPengajuanId);
        
        if (!$this->clearance_aset || !$this->clearance_keuangan || !$this->clearance_dokumen) {
            $this->addError('clearance_check', 'Semua checklist clearance harus diselesaikan sebelum persetujuan.');
            return;
        }

        $p->update([
            'clearance_aset' => $this->clearance_aset,
            'clearance_keuangan' => $this->clearance_keuangan,
            'clearance_dokumen' => $this->clearance_dokumen,
            'catatan_hrd' => $this->catatan_hrd,
            'status_approval' => 'Disetujui'
        ]);

        // Update Pegawai Status
        $p->pegawai->update(['status_kepegawaian' => 'Resign']); // Atau non-aktif sesuai logika bisnis

        $this->dispatch('notify', 'success', 'Pengunduran diri disetujui. Status pegawai diperbarui.');
        $this->selectedPengajuanId = null;
    }

    public function reject()
    {
        $p = PengajuanBerhenti::findOrFail($this->selectedPengajuanId);
        $p->update([
            'catatan_hrd' => $this->catatan_hrd,
            'status_approval' => 'Ditolak'
        ]);
        
        $this->dispatch('notify', 'error', 'Pengajuan ditolak.');
        $this->selectedPengajuanId = null;
    }

    public function cancel()
    {
        $this->isCreating = false;
        $this->selectedPengajuanId = null;
        $this->resetForm();
    }

    private function resetForm()
    {
        $this->reset(['pegawai_id', 'jenis_berhenti', 'tanggal_pengajuan', 'tanggal_efektif_keluar', 'alasan', 'file_surat']);
    }
}