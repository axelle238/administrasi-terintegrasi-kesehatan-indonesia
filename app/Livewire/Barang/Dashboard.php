<?php

namespace App\Livewire\Barang;

use App\Models\Barang;
use App\Models\Maintenance;
use App\Models\PengadaanBarang;
use App\Models\RiwayatBarang;
use Livewire\Component;
use Carbon\Carbon;

class Dashboard extends Component
{
    public function render()
    {
        // 1. Asset Statistics
        $totalAset = Barang::count();
        $nilaiAset = Barang::sum('nilai_buku');
        $kondisiBaik = Barang::where('kondisi', 'Baik')->count();
        $kondisiRusak = Barang::whereIn('kondisi', ['Rusak Ringan', 'Rusak Berat'])->count();

        // 2. Maintenance Needs
        $maintenanceDue = Maintenance::whereDate('tanggal_berikutnya', '<=', now()->addDays(7))
            ->whereDate('tanggal_berikutnya', '>=', now())
            ->count();

        // 3. Procurement Pending
        $pengadaanPending = PengadaanBarang::where('status', 'Pending')->count();

        // 4. Recent Activities (Mutasi & Log)
        $recentActivities = RiwayatBarang::with(['barang', 'user'])
            ->latest()
            ->take(5)
            ->get();

        // 5. Low Stock Consumables (Non-Asset)
        $lowStockItems = Barang::where('is_asset', false)
            ->where('stok', '<=', 5)
            ->orderBy('stok')
            ->take(5)
            ->get();

        return view('livewire.barang.dashboard', compact(
            'totalAset',
            'nilaiAset',
            'kondisiBaik',
            'kondisiRusak',
            'maintenanceDue',
            'pengadaanPending',
            'recentActivities',
            'lowStockItems'
        ))->layout('layouts.app', ['header' => 'Dashboard Inventaris']);
    }
}
