<?php

namespace App\Livewire\Barang;

use App\Models\Barang;
use App\Models\KategoriBarang;
use App\Models\Maintenance;
use App\Models\PengadaanBarang;
use App\Models\RiwayatBarang;
use Livewire\Component;
use Carbon\Carbon;

class Dashboard extends Component
{
    public function render()
    {
        // 1. Statistik Aset
        $totalAset = Barang::count();
        $nilaiAset = Barang::sum('nilai_buku');
        $kondisiBaik = Barang::where('kondisi', 'Baik')->count();
        $kondisiRusak = Barang::whereIn('kondisi', ['Rusak Ringan', 'Rusak Berat'])->count();
        $chartKondisi = [$kondisiBaik, $kondisiRusak];

        // 2. Kebutuhan Maintenance
        $maintenanceDue = Maintenance::whereDate('tanggal_berikutnya', '<=', now()->addDays(7))
            ->whereDate('tanggal_berikutnya', '>=', now())
            ->count();

        // 3. Pengadaan Pending
        $pengadaanPending = PengadaanBarang::where('status', 'Pending')->count();

        // 4. Aktivitas Terkini (Mutasi & Log)
        $recentActivities = RiwayatBarang::with(['barang', 'user'])
            ->latest()
            ->take(5)
            ->get();

        // 5. Stok Menipis (Barang Habis Pakai / Non-Aset)
        $lowStockItems = Barang::where('is_asset', false)
            ->where('stok', '<=', 5)
            ->orderBy('stok')
            ->take(5)
            ->get();

        // 6. Distribusi Kategori
        $distribusiKategori = KategoriBarang::withCount('barangs')
            ->orderByDesc('barangs_count')
            ->take(5)
            ->get();

        return view('livewire.barang.dashboard', compact(
            'totalAset',
            'nilaiAset',
            'kondisiBaik',
            'kondisiRusak',
            'chartKondisi',
            'maintenanceDue',
            'pengadaanPending',
            'recentActivities',
            'lowStockItems',
            'distribusiKategori'
        ))->layout('layouts.app', ['header' => 'Dashboard Inventaris & Aset']);
    }
}
