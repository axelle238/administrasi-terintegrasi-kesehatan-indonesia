<?php

namespace App\Livewire\System\Poli;

use App\Models\Poli;
use Livewire\Component;
use Livewire\WithPagination;

class Index extends Component
{
    use WithPagination;

    public $search = '';

    public function delete($id)
    {
        Poli::find($id)->delete();
        $this->dispatch('notify', 'success', 'Poli dihapus.');
    }

    public function render()
    {
        $polis = Poli::where('nama_poli', 'like', '%' . $this->search . '%')
            ->withCount('pegawais')
            ->latest()
            ->paginate(10);

        // Statistik Dashboard Poli
        $totalPoli = Poli::count();
        $totalDokter = \App\Models\Pegawai::whereNotNull('poli_id')->count();
        $kunjunganHariIni = \App\Models\Antrean::whereDate('tanggal_antrean', \Carbon\Carbon::today())->count();

        return view('livewire.system.poli.index', [
            'polis' => $polis,
            'totalPoli' => $totalPoli,
            'totalDokter' => $totalDokter,
            'kunjunganHariIni' => $kunjunganHariIni
        ])->layout('layouts.app', ['header' => 'Dashboard & Master Poli']);
    }
}