<?php

namespace App\Livewire\Hrd\Cuti;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\PengajuanCuti;
use App\Models\Pegawai;
use Illuminate\Support\Facades\DB;

class Index extends Component
{
    use WithPagination;

    public $filterStatus = 'Pending';
    
    public function approve($id)
    {
        DB::transaction(function () use ($id) {
            $cuti = PengajuanCuti::findOrFail($id);
            
            if ($cuti->status != 'Disetujui') {
                $cuti->update(['status' => 'Disetujui', 'catatan_admin' => 'Disetujui oleh HRD']);
                
                if ($cuti->jenis_cuti == 'Cuti Tahunan') {
                    $pegawai = Pegawai::where('user_id', $cuti->user_id)->first();
                    if ($pegawai) {
                        $pegawai->decrement('sisa_cuti', $cuti->durasi_hari);
                    }
                }
            }
        });

        $this->dispatch('notify', 'success', 'Pengajuan cuti disetujui.');
    }

    public function reject($id)
    {
        $cuti = PengajuanCuti::findOrFail($id);
        $cuti->update(['status' => 'Ditolak', 'catatan_admin' => 'Ditolak oleh HRD']);
        $this->dispatch('notify', 'success', 'Pengajuan cuti ditolak.');
    }

    public function render()
    {
        $cutis = PengajuanCuti::with(['user.pegawai'])
            ->when($this->filterStatus, function($q) {
                $q->where('status', $this->filterStatus);
            })
            ->latest()
            ->paginate(10);

        return view('livewire.hrd.cuti.index', [
            'cutis' => $cutis
        ])->layout('layouts.app', ['header' => 'Verifikasi Cuti Pegawai']);
    }
}
