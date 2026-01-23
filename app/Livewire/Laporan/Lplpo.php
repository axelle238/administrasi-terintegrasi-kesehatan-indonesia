<?php

namespace App\Livewire\Laporan;

use App\Models\Obat;
use App\Models\TransaksiObat;
use Livewire\Component;
use Carbon\Carbon;

class Lplpo extends Component
{
    public $bulan;
    public $tahun;

    public function mount()
    {
        $this->bulan = date('m');
        $this->tahun = date('Y');
    }

    public function render()
    {
        $startDate = Carbon::createFromDate($this->tahun, $this->bulan, 1)->startOfMonth();
        $endDate = $startDate->copy()->endOfMonth();

        // Get all drugs
        $obats = Obat::orderBy('nama_obat')->get();

        $reportData = $obats->map(function ($obat) use ($startDate, $endDate) {
            // Calculate transactions within the selected month
            $penerimaan = TransaksiObat::where('obat_id', $obat->id)
                ->where('jenis_transaksi', 'Masuk')
                ->whereBetween('tanggal_transaksi', [$startDate, $endDate])
                ->sum('jumlah');

            $pemakaian = TransaksiObat::where('obat_id', $obat->id)
                ->where('jenis_transaksi', 'Keluar')
                ->whereBetween('tanggal_transaksi', [$startDate, $endDate])
                ->sum('jumlah');

            // Calculate Stock at the beginning of the month
            // Formula: Current Stock - (Total In from StartDate to Now) + (Total Out from StartDate to Now)
            // But this assumes Current Stock is "Now". If we look at past months, we need to trace back from "Now".
            
            // Better approach:
            // 1. Get Stock at End of Period (Calculated backwards from today) OR
            // 2. Get Stock at Beginning (Calculate forward from initial? No, initial unknown).
            
            // Let's use the Backward calculation from Current Stock (Live)
            // Current Stock is the stock at NOW.
            
            $totalInSinceEndOfPeriod = TransaksiObat::where('obat_id', $obat->id)
                ->where('jenis_transaksi', 'Masuk')
                ->where('tanggal_transaksi', '>', $endDate)
                ->sum('jumlah');

            $totalOutSinceEndOfPeriod = TransaksiObat::where('obat_id', $obat->id)
                ->where('jenis_transaksi', 'Keluar')
                ->where('tanggal_transaksi', '>', $endDate)
                ->sum('jumlah');

            $stokAkhir = $obat->stok - $totalInSinceEndOfPeriod + $totalOutSinceEndOfPeriod;
            $stokAwal = $stokAkhir - $penerimaan + $pemakaian;

            return [
                'kode_obat' => $obat->kode_obat,
                'nama_obat' => $obat->nama_obat,
                'satuan' => $obat->satuan,
                'stok_awal' => $stokAwal,
                'penerimaan' => $penerimaan,
                'persediaan' => $stokAwal + $penerimaan,
                'pemakaian' => $pemakaian,
                'stok_akhir' => $stokAkhir,
                'permintaan' => $pemakaian, // Simple logic: Request = Usage
            ];
        });

        return view('livewire.laporan.lplpo', [
            'reportData' => $reportData
        ])->layout('layouts.app', ['header' => 'Laporan LPLPO']);
    }
}