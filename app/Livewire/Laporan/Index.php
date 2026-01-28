<?php

namespace App\Livewire\Laporan;

use App\Models\RekamMedis;
use App\Models\Pembayaran;
use App\Models\Obat;
use App\Models\Pegawai;
use App\Models\KinerjaPegawai;
use App\Models\Barang;
use App\Models\Antrean;
use Carbon\Carbon;
use Livewire\Component;
use Illuminate\Support\Facades\DB;

class Index extends Component
{
    public $tab = 'kunjungan'; // kunjungan, keuangan, obat, penyakit, sdm, aset, layanan
    
    // Filter
    public $startDate;
    public $endDate;

    public function mount()
    {
        $this->startDate = Carbon::now()->startOfMonth()->format('Y-m-d');
        $this->endDate = Carbon::now()->endOfMonth()->format('Y-m-d');
    }

    public function render()
    {
        $data = [];
        $summary = [];

        // --- LAPORAN KUNJUNGAN PASIEN ---
        if ($this->tab == 'kunjungan') {
            $query = RekamMedis::with(['pasien', 'dokter', 'poli']) 
                ->whereBetween('tanggal_periksa', [$this->startDate, $this->endDate . ' 23:59:59']);
            
            $data = $query->latest('tanggal_periksa')->get();
            
            $summary = [
                'total_kunjungan' => $data->count(),
                'rata_rata_harian' => $data->count() / max(1, Carbon::parse($this->endDate)->diffInDays(Carbon::parse($this->startDate)) + 1),
                'pasien_baru' => $data->unique('pasien_id')->count(), // Simplifikasi
            ];
        } 
        // --- LAPORAN KEUANGAN & PENDAPATAN ---
        elseif ($this->tab == 'keuangan') {
            $query = Pembayaran::with(['rekamMedis.pasien', 'kasir'])
                ->whereBetween('created_at', [$this->startDate, $this->endDate . ' 23:59:59'])
                ->where('status', 'Lunas');
            
            $data = $query->latest()->get();

            $summary = [
                'total_pendapatan' => $data->sum('jumlah_bayar'),
                'total_transaksi' => $data->count(),
                'rata_rata_transaksi' => $data->avg('jumlah_bayar'),
                'metode_tunai' => $data->where('metode_pembayaran', 'Tunai')->sum('jumlah_bayar'),
                'metode_bpjs' => $data->where('metode_pembayaran', 'BPJS')->count() . ' Klaim',
            ];
        }
        // --- LAPORAN FARMASI & OBAT ---
        elseif ($this->tab == 'obat') {
            // Laporan Gabungan: Stok Menipis & Expired
            $data['stok'] = Obat::orderBy('stok', 'asc')->get();
            $data['expired'] = Obat::where('tanggal_kedaluwarsa', '<=', Carbon::now()->addMonths(6))
                ->orderBy('tanggal_kedaluwarsa', 'asc')
                ->get();
            
            $summary = [
                'total_item' => Obat::count(),
                'total_nilai_aset' => Obat::sum(DB::raw('stok * harga_beli')), // Asumsi kolom harga_beli ada
                'item_expired' => $data['expired']->count(),
                'item_kritis' => Obat::whereColumn('stok', '<=', 'min_stok')->count(),
            ];
        }
        // --- LAPORAN EPIDEMIOLOGI (PENYAKIT) ---
        elseif ($this->tab == 'penyakit') {
            $data = RekamMedis::select('diagnosa', DB::raw('count(*) as total'))
                ->whereBetween('tanggal_periksa', [$this->startDate, $this->endDate . ' 23:59:59'])
                ->whereNotNull('diagnosa')
                ->groupBy('diagnosa')
                ->orderByDesc('total')
                ->take(20)
                ->get();
            
            $summary = [
                'total_kasus_terdiagnosa' => RekamMedis::whereBetween('tanggal_periksa', [$this->startDate, $this->endDate . ' 23:59:59'])->whereNotNull('diagnosa')->count(),
                'penyakit_terbanyak' => $data->first()->diagnosa ?? '-',
            ];
        }
        // --- LAPORAN SDM & KINERJA ---
        elseif ($this->tab == 'sdm') {
            $data = KinerjaPegawai::with('pegawai.user')
                ->whereBetween('created_at', [$this->startDate, $this->endDate . ' 23:59:59'])
                ->get()
                ->sortByDesc(function($item) {
                    return $item->orientasi_pelayanan + $item->integritas + $item->komitmen + $item->disiplin + $item->kerjasama;
                });

            $summary = [
                'total_penilaian' => $data->count(),
                'rata_rata_skor' => $data->avg(function($item) {
                    return $item->orientasi_pelayanan + $item->integritas + $item->komitmen + $item->disiplin + $item->kerjasama;
                }),
            ];
        }
        // --- LAPORAN ASET & INVENTARIS ---
        elseif ($this->tab == 'aset') {
            $data = Barang::with(['kategori', 'ruangan'])->orderBy('nama_barang')->get();
            
            $summary = [
                'total_aset' => $data->where('is_asset', true)->count(),
                'total_nilai_buku' => $data->sum('nilai_buku'),
                'aset_rusak' => $data->whereIn('kondisi', ['Rusak Ringan', 'Rusak Berat'])->count(),
            ];
        }
        // --- LAPORAN LAYANAN & WAKTU TUNGGU ---
        elseif ($this->tab == 'layanan') {
            // Analisa Waktu Tunggu (Mock logic if timestamps not detailed enough)
            $data = Antrean::whereBetween('tanggal_antrean', [$this->startDate, $this->endDate])
                ->where('status', 'Selesai')
                ->with('poli')
                ->get()
                ->map(function($antrean) {
                    $antrean->durasi_layanan = $antrean->updated_at->diffInMinutes($antrean->created_at);
                    return $antrean;
                });

            $summary = [
                'total_pasien_selesai' => $data->count(),
                'rata_rata_waktu_layanan' => round($data->avg('durasi_layanan'), 0) . ' Menit',
                'poli_tersibuk' => $data->groupBy('poli_id')->sortByDesc(fn($g) => $g->count())->first()->first()->poli->nama_poli ?? '-',
            ];
        }

        return view('livewire.laporan.index', [
            'data' => $data,
            'summary' => $summary
        ])->layout('layouts.app', ['header' => 'Pusat Laporan Terintegrasi']);
    }
}