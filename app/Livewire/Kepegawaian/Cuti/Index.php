<?php

namespace App\Livewire\Kepegawaian\Cuti;

use App\Models\PengajuanCuti;
use App\Models\Pegawai;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\WithFileUploads;
use Carbon\Carbon;

class Index extends Component
{
    use WithPagination, WithFileUploads;

    public $jenis_cuti;
    public $tanggal_mulai;
    public $tanggal_selesai;
    public $keterangan;
    public $file_bukti; // New
    public $durasi_hari = 0;
    
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
        'file_bukti' => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:2048', // 2MB Max
    ];

    public function mount()
    {
        $this->isAdmin = Auth::user()->role === 'admin' || Auth::user()->can('hrd');
    }

    public function updated($propertyName)
    {
        // Hitung durasi otomatis saat tanggal berubah
        if ($propertyName == 'tanggal_mulai' || $propertyName == 'tanggal_selesai') {
            $this->calculateDuration();
        }
    }

    private function calculateDuration()
    {
        if ($this->tanggal_mulai && $this->tanggal_selesai) {
            $start = Carbon::parse($this->tanggal_mulai);
            $end = Carbon::parse($this->tanggal_selesai);
            
            if ($end >= $start) {
                // Logic Hari Kerja bisa ditambahkan di sini (skip weekend)
                // Untuk sekarang hitung hari kalender + 1 (inklusif)
                $this->durasi_hari = $start->diffInDays($end) + 1;
            } else {
                $this->durasi_hari = 0;
            }
        }
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
        $this->file_bukti = null;
        $this->cutiId = null;
        $this->catatan_admin = '';
        $this->durasi_hari = 0;
    }

    public function save()
    {
        $this->validate();
        $this->calculateDuration();

        // Validasi Kuota Cuti (Hanya jika Cuti Tahunan)
        if ($this->jenis_cuti == 'Cuti Tahunan') {
            $pegawai = Pegawai::where('user_id', Auth::id())->first();
            if ($pegawai && $this->durasi_hari > $pegawai->sisa_cuti) {
                $this->addError('tanggal_selesai', 'Sisa cuti tidak mencukupi (Sisa: ' . $pegawai->sisa_cuti . ' hari).');
                return;
            }
        }

        $filePath = null;
        if ($this->file_bukti) {
            $filePath = $this->file_bukti->store('bukti-cuti', 'public');
        }

        PengajuanCuti::create([
            'user_id' => Auth::id(),
            'jenis_cuti' => $this->jenis_cuti,
            'tanggal_mulai' => $this->tanggal_mulai,
            'tanggal_selesai' => $this->tanggal_selesai,
            'durasi_hari' => $this->durasi_hari,
            'keterangan' => $this->keterangan,
            'file_bukti' => $filePath,
            'status' => 'Pending',
        ]);

        $this->dispatch('notify', 'success', 'Pengajuan cuti berhasil dikirim.');
        $this->isOpen = false;
        $this->resetInputFields();
    }

    public function approve($id)
    {
        if (!$this->isAdmin) return;
        
        DB::transaction(function () use ($id) {
            $cuti = PengajuanCuti::find($id);
            
            if ($cuti->status != 'Disetujui') {
                $cuti->update(['status' => 'Disetujui', 'catatan_admin' => 'Disetujui oleh Admin']);
                
                // Kurangi Kuota jika Cuti Tahunan
                if ($cuti->jenis_cuti == 'Cuti Tahunan') {
                    $pegawai = Pegawai::where('user_id', $cuti->user_id)->first();
                    if ($pegawai) {
                        $pegawai->decrement('sisa_cuti', $cuti->durasi_hari);
                    }
                }
            }
        });

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
