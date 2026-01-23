<?php

namespace App\Livewire\Kepegawaian\Cuti;

use App\Models\PengajuanCuti;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\WithPagination;

class Index extends Component
{
    use WithPagination;

    public $jenis_cuti;
    public $tanggal_mulai;
    public $tanggal_selesai;
    public $keterangan;
    
    public $isOpen = false;
    public $cutiId;
    public $isAdmin = false;
    
    // Approval specific
    public $catatan_admin;

    protected $rules = [
        'jenis_cuti' => 'required|in:Cuti Tahunan,Sakit,Izin,Cuti Melahirkan',
        'tanggal_mulai' => 'required|date',
        'tanggal_selesai' => 'required|date|after_or_equal:tanggal_mulai',
        'keterangan' => 'required|string|max:255',
    ];

    public function mount()
    {
        $this->isAdmin = Auth::user()->role === 'admin';
    }

    public function create()
    {
        $this->resetInputFields();
        $this->isOpen = true;
    }

    private function resetInputFields()
    {
        $this->jenis_cuti = 'Cuti Tahunan';
        $this->tanggal_mulai = '';
        $this->tanggal_selesai = '';
        $this->keterangan = '';
        $this->cutiId = null;
        $this->catatan_admin = '';
    }

    public function save()
    {
        $this->validate();

        PengajuanCuti::create([
            'user_id' => Auth::id(),
            'jenis_cuti' => $this->jenis_cuti,
            'tanggal_mulai' => $this->tanggal_mulai,
            'tanggal_selesai' => $this->tanggal_selesai,
            'keterangan' => $this->keterangan,
            'status' => 'Pending',
        ]);

        $this->dispatch('notify', 'success', 'Pengajuan cuti berhasil dikirim.');
        $this->isOpen = false;
        $this->resetInputFields();
    }

    public function approve($id)
    {
        if (!$this->isAdmin) return;
        
        $cuti = PengajuanCuti::find($id);
        $cuti->update(['status' => 'Disetujui', 'catatan_admin' => 'Disetujui oleh Admin']);
        $this->dispatch('notify', 'success', 'Cuti disetujui.');
    }

    public function reject($id)
    {
        if (!$this->isAdmin) return;

        $cuti = PengajuanCuti::find($id);
        $cuti->update(['status' => 'Ditolak', 'catatan_admin' => 'Ditolak oleh Admin']);
        $this->dispatch('notify', 'success', 'Cuti ditolak.');
    }

    public function cancel($id)
    {
        $cuti = PengajuanCuti::find($id);
        if ($cuti->user_id == Auth::id() && $cuti->status == 'Pending') {
            $cuti->delete();
            $this->dispatch('notify', 'success', 'Pengajuan dibatalkan.');
        }
    }

    public function render()
    {
        $query = PengajuanCuti::with('user')->latest();

        if (!$this->isAdmin) {
            $query->where('user_id', Auth::id());
        }

        return view('livewire.kepegawaian.cuti.index', [
            'cutis' => $query->paginate(10)
        ])->layout('layouts.app', ['header' => 'Manajemen Cuti Pegawai']);
    }
}