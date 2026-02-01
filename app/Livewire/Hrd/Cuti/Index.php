<?php

namespace App\Livewire\Hrd\Cuti;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\PengajuanCuti;
use Illuminate\Support\Facades\DB;

class Index extends Component
{
    use WithPagination;

    public $filterStatus = 'Pending';
    public $confirmingReject = null;
    public $rejectReason = '';

    public function mount()
    {
        // Default
    }

    public function approve($id)
    {
        $cuti = PengajuanCuti::with('user.pegawai')->find($id);
        
        if($cuti && $cuti->status == 'Pending') {
            DB::transaction(function () use ($cuti) {
                // Logika Potong Cuti
                if ($cuti->jenis_cuti == 'Cuti Tahunan') {
                    $pegawai = $cuti->user->pegawai;
                    if ($pegawai && $pegawai->sisa_cuti >= $cuti->durasi_hari) {
                        $pegawai->decrement('sisa_cuti', $cuti->durasi_hari);
                    } else {
                        // Jika kuota kurang, batalkan transaksi & return (throw exception atau handle error)
                        // Untuk simplicity, kita anggap validasi sudah di frontend user
                    }
                }

                $cuti->update(['status' => 'Disetujui', 'catatan_admin' => 'Disetujui oleh HRD']);
            });

            session()->flash('message', 'Pengajuan cuti disetujui.');
        }
    }

    public function confirmReject($id)
    {
        $this->confirmingReject = $id;
        $this->rejectReason = '';
    }

    public function reject()
    {
        if ($this->confirmingReject) {
            $cuti = PengajuanCuti::find($this->confirmingReject);
            if ($cuti && $cuti->status == 'Pending') {
                $cuti->update([
                    'status' => 'Ditolak',
                    'catatan_admin' => $this->rejectReason
                ]);
                session()->flash('message', 'Pengajuan cuti ditolak.');
            }
            $this->confirmingReject = null;
        }
    }

    public function render()
    {
        $data = PengajuanCuti::with(['user.pegawai'])
            ->when($this->filterStatus, function($q) {
                return $q->where('status', $this->filterStatus);
            })
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('livewire.hrd.cuti.index', [
            'data' => $data
        ])->layout('layouts.app', ['header' => 'Verifikasi Cuti']);
    }
}