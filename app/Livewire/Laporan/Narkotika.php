<?php

namespace App\Livewire\Laporan;

use App\Models\Obat;
use App\Models\TransaksiObat;
use Livewire\Component;
use Carbon\Carbon;

class Narkotika extends Component
{
    public $bulan;
    public $tahun;
    public $jenis = 'Narkotika'; // Narkotika atau Psikotropika

    public function mount()
    {
        $this->bulan = date('m');
        $this->tahun = date('Y');
    }

    public function render()
    {
        $startDate = Carbon::createFromDate($this->tahun, $this->bulan, 1)->startOfMonth();
        $endDate = $startDate->copy()->endOfMonth();

        $obats = Obat::where('golongan', $this->jenis)->get();

        $reportData = $obats->map(function ($obat) use ($startDate, $endDate) {
            $penerimaan = TransaksiObat::where('obat_id', $obat->id)
                ->where('jenis_transaksi', 'Masuk')
                ->whereBetween('tanggal_transaksi', [$startDate, $endDate])
                ->sum('jumlah');

            $pemakaian = TransaksiObat::where('obat_id', $obat->id)
                ->where('jenis_transaksi', 'Keluar')
                ->whereBetween('tanggal_transaksi', [$startDate, $endDate])
                ->sum('jumlah');

            // Backward calc
            $totalInSince = TransaksiObat::where('obat_id', $obat->id)
                ->where('jenis_transaksi', 'Masuk')
                ->where('tanggal_transaksi', '>', $endDate)
                ->sum('jumlah');

            $totalOutSince = TransaksiObat::where('obat_id', $obat->id)
                ->where('jenis_transaksi', 'Keluar')
                ->where('tanggal_transaksi', '>', $endDate)
                ->sum('jumlah');

            $stokAkhir = $obat->stok - $totalInSince + $totalOutSince;
            $stokAwal = $stokAkhir - $penerimaan + $pemakaian;

            return [
                'nama_obat' => $obat->nama_obat,
                'satuan' => $obat->satuan,
                'stok_awal' => $stokAwal,
                'penerimaan' => $penerimaan,
                'pemakaian' => $pemakaian,
                'stok_akhir' => $stokAkhir,
            ];
        });

        return view('livewire.laporan.narkotika', [
            'reportData' => $reportData
        ])->layout('layouts.app', ['header' => "Laporan $this->jenis"]);
    }
}
