<?php

namespace App\Livewire\Pharmacy;

use Livewire\Component;
use App\Models\Obat;
use App\Models\RekamMedis;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class Dashboard extends Component
{
    public function render()
    {
        // 1. Stok Overview & Valuasi
        $totalItemObat = Obat::count();
        $totalStok = Obat::sum('stok');
        // Asumsi ada kolom harga_beli di tabel obat untuk valuasi
        $valuasiAset = Obat::sum(DB::raw('stok * harga_beli')); 
        
        $stokMenipis = Obat::whereColumn('stok', '<=', 'min_stok')->count();
        $stokHabis = Obat::where('stok', 0)->count();
        $obatExpired = Obat::where('tanggal_kedaluwarsa', '<=', Carbon::now()->addMonths(3))->count();

        // 2. Transaksi Resep Hari Ini
        $resepHariIni = RekamMedis::whereDate('updated_at', Carbon::today())
            ->where('status_resep', 'Selesai')
            ->count();

        // 3. Obat Paling Sering Keluar (Top 5)
        $topObat = DB::table('rekam_medis_obat')
            ->select('obat_id', DB::raw('sum(jumlah) as total_keluar'))
            ->groupBy('obat_id')
            ->orderByDesc('total_keluar')
            ->limit(5)
            ->get();
            
        $topObatIds = $topObat->pluck('obat_id');
        $obatNames = Obat::whereIn('id', $topObatIds)->pluck('nama_obat', 'id');

        // 4. Daftar Obat Segera Expired (Top 5)
        $listExpired = Obat::where('tanggal_kedaluwarsa', '<=', Carbon::now()->addMonths(6))
            ->orderBy('tanggal_kedaluwarsa', 'asc')
            ->limit(5)
            ->get();

        // 5. Tren Penggunaan Obat (7 Hari Terakhir)
        $trenObat = $this->getTrenObat();

        return view('livewire.pharmacy.dashboard', compact(
            'totalItemObat',
            'totalStok',
            'valuasiAset',
            'stokMenipis',
            'stokHabis',
            'obatExpired',
            'resepHariIni',
            'topObat',
            'obatNames',
            'listExpired',
            'trenObat'
        ))->layout('layouts.app', ['header' => 'Dashboard Farmasi & Logistik']);
    }

    private function getTrenObat()
    {
        $data = [];
        $labels = [];
        for ($i = 6; $i >= 0; $i--) {
            $date = Carbon::now()->subDays($i);
            $labels[] = $date->format('d M');
            
            // Hitung total item obat keluar pada tanggal tersebut
            $total = DB::table('rekam_medis_obat')
                ->whereDate('created_at', $date)
                ->sum('jumlah');
                
            $data[] = $total;
        }
        return ['labels' => $labels, 'data' => $data];
    }
}