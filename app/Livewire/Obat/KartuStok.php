<?php

namespace App\Livewire\Obat;

use App\Models\Obat;
use App\Models\TransaksiObat;
use Livewire\Component;
use Livewire\WithPagination;

class KartuStok extends Component
{
    use WithPagination;

    public Obat $obat;
    public $bulan;
    public $tahun;

    public function mount(Obat $obat)
    {
        $this->obat = $obat;
        $this->bulan = date('m');
        $this->tahun = date('Y');
    }

    public function render()
    {
        // Ambil transaksi bulan ini
        $transaksi = TransaksiObat::where('obat_id', $this->obat->id)
            ->whereYear('tanggal_transaksi', $this->tahun)
            ->whereMonth('tanggal_transaksi', $this->bulan)
            ->orderBy('tanggal_transaksi', 'asc')
            ->orderBy('id', 'asc')
            ->get();

        // Hitung Saldo Awal (Stok sebelum bulan ini)
        // Logika: Total Masuk - Total Keluar sebelum tanggal 1 bulan ini
        // Namun, ini kompleks jika tidak ada snapshot.
        // Simplified approach: Kita hitung running balance dari awal database jika data tidak terlalu besar, 
        // atau kita asumsikan stok saat ini adalah stok akhir, lalu kita reverse calculate (lebih aman).
        
        // Pendekatan Reverse Calculation:
        // Stok Sekarang = 100.
        // Transaksi kemarin: Keluar 5. Maka stok kemarin = 105.
        // Tapi untuk Kartu Stok biasanya Forward Calculation.
        
        // Mari gunakan Forward Calculation dari Saldo Awal Bulan.
        // Saldo Awal = Sum(Masuk < Tgl 1) - Sum(Keluar < Tgl 1)
        
        $startOfMonth = "{$this->tahun}-{$this->bulan}-01";
        
        $totalMasukLalu = TransaksiObat::where('obat_id', $this->obat->id)
            ->where('tanggal_transaksi', '<', $startOfMonth)
            ->where('jenis_transaksi', 'Masuk')
            ->sum('jumlah');

        $totalKeluarLalu = TransaksiObat::where('obat_id', $this->obat->id)
            ->where('tanggal_transaksi', '<', $startOfMonth)
            ->where('jenis_transaksi', 'Keluar')
            ->sum('jumlah');
            
        $saldoAwal = $totalMasukLalu - $totalKeluarLalu;

        return view('livewire.obat.kartu-stok', [
            'transaksi' => $transaksi,
            'saldoAwal' => $saldoAwal
        ])->layout('layouts.app', ['header' => 'Kartu Stok Obat']);
    }
}
