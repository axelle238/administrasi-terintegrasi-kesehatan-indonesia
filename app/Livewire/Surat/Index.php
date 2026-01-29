<?php

namespace App\Livewire\Surat;

use App\Models\Surat;
use App\Models\DisposisiSurat;
use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class Index extends Component
{
    use WithPagination;

    public $search = '';
    public $jenisFilter = '';

    public function delete($id)
    {
        $surat = Surat::find($id);
        if ($surat) {
            $surat->delete();
            $this->dispatch('notify', 'success', 'Surat berhasil dihapus.');
        }
    }

    public function render()
    {
        // 1. Statistik Utama
        $totalSuratMasuk = Surat::where('jenis_surat', 'Masuk')->count();
        $totalSuratKeluar = Surat::where('jenis_surat', 'Keluar')->count();
        
        $suratMasukBulanIni = Surat::where('jenis_surat', 'Masuk')
            ->whereMonth('tanggal_surat', Carbon::now()->month)
            ->whereYear('tanggal_surat', Carbon::now()->year)
            ->count();
            
        $suratKeluarBulanIni = Surat::where('jenis_surat', 'Keluar')
            ->whereMonth('tanggal_surat', Carbon::now()->month)
            ->whereYear('tanggal_surat', Carbon::now()->year)
            ->count();

        // 2. Disposisi Pending (Belum ditindaklanjuti)
        // Logika sederhana: Surat Masuk yang belum punya disposisi
        // Ini mungkin query berat kalau data banyak, tapi untuk dashboard ok.
        $suratBelumDisposisi = Surat::where('jenis_surat', 'Masuk')
            ->doesntHave('disposisi')
            ->count();

        // 3. Grafik Volume Surat (6 Bulan)
        $grafikSurat = $this->getGrafikSurat();

        // 4. Data Table
        $surats = Surat::where(function($q) {
                $q->where('nomor_surat', 'like', '%' . $this->search . '%')
                  ->orWhere('perihal', 'like', '%' . $this->search . '%')
                  ->orWhere('pengirim', 'like', '%' . $this->search . '%');
            })
            ->when($this->jenisFilter, function($q) {
                $q->where('jenis_surat', $this->jenisFilter);
            })
            ->latest('tanggal_surat')
            ->paginate(10);

        return view('livewire.surat.index', compact(
            'surats',
            'totalSuratMasuk',
            'totalSuratKeluar',
            'suratMasukBulanIni',
            'suratKeluarBulanIni',
            'suratBelumDisposisi',
            'grafikSurat'
        ))->layout('layouts.app', ['header' => 'Dashboard Administrasi & Arsip']);
    }

    private function getGrafikSurat()
    {
        $labels = [];
        $dataMasuk = [];
        $dataKeluar = [];
        
        for ($i = 5; $i >= 0; $i--) {
            $date = Carbon::now()->subMonths($i);
            $labels[] = $date->format('M Y');
            
            $dataMasuk[] = Surat::where('jenis_surat', 'Masuk')
                ->whereMonth('tanggal_surat', $date->month)
                ->whereYear('tanggal_surat', $date->year)
                ->count();
                
            $dataKeluar[] = Surat::where('jenis_surat', 'Keluar')
                ->whereMonth('tanggal_surat', $date->month)
                ->whereYear('tanggal_surat', $date->year)
                ->count();
        }

        return ['labels' => $labels, 'dataMasuk' => $dataMasuk, 'dataKeluar' => $dataKeluar];
    }
}