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
        // 1. Ringkasan Stok & Valuasi Aset Farmasi
        $totalItemObat = Obat::count();
        $totalStokUnit = Obat::sum('stok');
        
        // Valuasi berdasarkan harga beli (asumsi kolom harga_beli ada)
        $valuasiStok = Obat::select(DB::raw('SUM(stok * harga_beli) as total'))->first()->total ?? 0;
        
        // Peringatan Stok (Early Warning System)
        $stokKritis = Obat::whereColumn('stok', '<=', 'min_stok')->where('stok', '>', 0)->count();
        $stokKosong = Obat::where('stok', '<=', 0)->count();
        $obatHampirKedaluwarsa = Obat::where('tanggal_kedaluwarsa', '<=', Carbon::now()->addMonths(3))->count();

        // 2. Aktivitas Resep & Pelayanan
        $jumlahResepMasuk = RekamMedis::whereDate('created_at', Carbon::today())
            ->whereNotNull('resep')
            ->count();
            
        $jumlahResepSelesai = RekamMedis::whereDate('updated_at', Carbon::today())
            ->where('status_resep', 'Selesai')
            ->count();

        // 3. Distribusi Obat Berdasarkan Kategori
        $statistikKategori = Obat::select('kategori', DB::raw('count(*) as total'))
            ->groupBy('kategori')
            ->orderByDesc('total')
            ->get();

        // 4. Obat Terlaris / Paling Sering Digunakan (Bulan Ini)
        // Note: Menggunakan tabel pivot rekam_medis_obat jika ada, atau parsing data resep
        // Di sini saya asumsikan ada tabel pivot rekam_medis_obat
        $obatPopuler = DB::table('rekam_medis_obat')
            ->join('obats', 'rekam_medis_obat.obat_id', '=', 'obats.id')
            ->select('obats.nama_obat', 'obats.satuan', DB::raw('SUM(rekam_medis_obat.jumlah) as total_keluar'))
            ->whereMonth('rekam_medis_obat.created_at', Carbon::now()->month)
            ->groupBy('obats.id', 'obats.nama_obat', 'obats.satuan')
            ->orderByDesc('total_keluar')
            ->take(5)
            ->get();

        // 5. Daftar Hitam Kedaluwarsa (Monitoring Ketat)
        $obatKedaluwarsaSegera = Obat::where('tanggal_kedaluwarsa', '<=', Carbon::now()->addMonths(6))
            ->orderBy('tanggal_kedaluwarsa', 'asc')
            ->take(5)
            ->get();

        // 6. Data Tren (7 Hari)
        $dataTren = $this->ambilDataTrenPenggunaan();

        return view('livewire.pharmacy.dashboard', [
            'totalItemObat' => $totalItemObat,
            'totalStokUnit' => $totalStokUnit,
            'valuasiStok' => $valuasiStok,
            'stokKritis' => $stokKritis,
            'stokKosong' => $stokKosong,
            'obatHampirKedaluwarsa' => $obatHampirKedaluwarsa,
            'jumlahResepMasuk' => $jumlahResepMasuk,
            'jumlahResepSelesai' => $jumlahResepSelesai,
            'statistikKategori' => $statistikKategori,
            'obatPopuler' => $obatPopuler,
            'obatKedaluwarsaSegera' => $obatKedaluwarsaSegera,
            'dataTren' => $dataTren
        ])->layout('layouts.app', ['header' => 'Pusat Kendali Farmasi & Perbekalan']);
    }

    private function ambilDataTrenPenggunaan()
    {
        $labels = [];
        $values = [];
        
        for ($i = 6; $i >= 0; $i--) {
            $hari = Carbon::now()->subDays($i);
            $labels[] = $hari->translatedFormat('d M');
            
            $total = DB::table('rekam_medis_obat')
                ->whereDate('created_at', $hari)
                ->sum('jumlah');
                
            $values[] = (int) $total;
        }
        
        return [
            'labels' => $labels,
            'values' => $values
        ];
    }
}