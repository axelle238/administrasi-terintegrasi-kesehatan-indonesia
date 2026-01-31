<?php

namespace App\Livewire\Kepegawaian\Gaji;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Penggajian;
use Illuminate\Support\Facades\Auth;

class Index extends Component
{
    use WithPagination;

    public $selectedGaji = null;
    public $showDetail = false;

    public function show($id)
    {
        $this->selectedGaji = Penggajian::where('user_id', Auth::id())
            ->with(['details', 'user.pegawai'])
            ->findOrFail($id);
            
        $this->showDetail = true;
    }

    public function closeDetail()
    {
        $this->showDetail = false;
        $this->selectedGaji = null;
    }

    public function render()
    {
        $riwayatGaji = Penggajian::where('user_id', Auth::id())
            ->where('status', 'Dibayar')
            ->orderByDesc('tahun')
            ->orderByDesc('bulan_angka') // Asumsi ada kolom ini atau mapping bulan
            ->paginate(12);

        return view('livewire.kepegawaian.gaji.index', [
            'riwayatGaji' => $riwayatGaji
        ])->layout('layouts.app', ['header' => 'Slip Gaji Digital']);
    }
}