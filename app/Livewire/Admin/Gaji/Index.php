<?php

namespace App\Livewire\Admin\Gaji;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Penggajian;
use App\Models\Pegawai;
use App\Services\PayrollService;
use Carbon\Carbon;

class Index extends Component
{
    use WithPagination;

    public $bulanFilter;
    public $tahunFilter;

    public function mount()
    {
        $this->bulanFilter = Carbon::now()->month;
        $this->tahunFilter = Carbon::now()->year;
    }

    public function generatePayroll()
    {
        $service = new PayrollService();
        $pegawais = Pegawai::whereNull('deleted_at')->get();
        
        $count = 0;
        foreach ($pegawais as $p) {
            // Cek sudah ada belum
            $exists = Penggajian::where('user_id', $p->user_id)
                ->where('bulan', $this->bulanFilter)
                ->where('tahun', $this->tahunFilter)
                ->exists();
                
            if (!$exists) {
                $service->generateSlip($p, $this->bulanFilter, $this->tahunFilter);
                $count++;
            }
        }

        session()->flash('message', "$count Slip Gaji berhasil digenerate.");
    }

    public function render()
    {
        $gajis = Penggajian::with(['user.pegawai'])
            ->where('bulan', $this->bulanFilter)
            ->where('tahun', $this->tahunFilter)
            ->paginate(10);

        return view('livewire.admin.gaji.index', [
            'gajis' => $gajis
        ])->layout('layouts.app', ['header' => 'Manajemen Penggajian']);
    }
}