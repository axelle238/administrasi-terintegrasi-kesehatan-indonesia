<?php

namespace App\Livewire\Pharmacy;

use Livewire\Component;
use App\Models\Obat;
use App\Models\TransaksiObat; // Asumsi ada model Transaksi atau detail resep
use App\Models\RekamMedis;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class Dashboard extends Component
{
    public function render()
    {
        // 1. Stok Overview
        $totalItemObat = Obat::count();
        $totalStok = Obat::sum('stok');
        $stokMenipis = Obat::whereColumn('stok', '<=', 'min_stok')->count();
        $stokHabis = Obat::where('stok', 0)->count();
        $obatExpired = Obat::where('tanggal_kedaluwarsa', '<=', Carbon::now()->addMonths(3))->count();

        // 2. Transaksi Resep Hari Ini
        $resepHariIni = RekamMedis::whereDate('updated_at', Carbon::today())
            ->where('status_resep', 'Selesai')
            ->count();

        // 3. Obat Paling Sering Keluar (Top 5)
        // Menggunakan relasi many-to-many rekam_medis_obat
        $topObat = DB::table('rekam_medis_obat')
            ->select('obat_id', DB::raw('sum(jumlah) as total_keluar'))
            ->groupBy('obat_id')
            ->orderByDesc('total_keluar')
            ->limit(5)
            ->get();
            
        // Map ID to Name manual to avoid complex eloquent in raw query if model relation complex
        $topObatIds = $topObat->pluck('obat_id');
        $obatNames = Obat::whereIn('id', $topObatIds)->pluck('nama_obat', 'id');

        return view('livewire.pharmacy.dashboard', compact(
            'totalItemObat',
            'totalStok',
            'stokMenipis',
            'stokHabis',
            'obatExpired',
            'resepHariIni',
            'topObat',
            'obatNames'
        ))->layout('layouts.app', ['header' => 'Dashboard Farmasi & Logistik']);
    }
}
