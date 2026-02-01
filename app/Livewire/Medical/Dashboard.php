<?php

namespace App\Livewire\Medical;

use Livewire\Component;
use App\Models\Pasien;
use App\Models\RekamMedis;
use App\Models\Antrean;
use App\Models\Kamar;
use App\Models\Poli;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class Dashboard extends Component
{
    // Manajemen Status
    public $tabAktif = 'ringkasan'; // ringkasan, demografi, klinis, rawat_inap

    public function aturTab($tab)
    {
        $this->tabAktif = $tab;
    }

    public function render()
    {
        // === METRIK GLOBAL (Selalu Dimuat) ===
        $totalKunjunganHariIni = Antrean::whereDate('tanggal_antrean', Carbon::today())->count();
        $totalKunjunganBulanIni = Antrean::whereMonth('tanggal_antrean', Carbon::now()->month)->count();
        
        // Kalkulasi BOR (Bed Occupancy Rate)
        $bedTerisi = Kamar::sum('bed_terisi');
        $totalBed = Kamar::sum('kapasitas_bed');
        $bor = $totalBed > 0 ? ($bedTerisi / $totalBed) * 100 : 0;

        // Rata-rata Waktu Layanan (Simulasi/Kalkulasi)
        $avgWaktuLayanan = Antrean::whereDate('tanggal_antrean', Carbon::today())
            ->where('status', 'Selesai')
            ->get()
            ->avg(function($item) {
                return $item->updated_at->diffInMinutes($item->created_at);
            }) ?? 0;

        // === INDIKATOR MUTU NASIONAL (INM) - NEW ===
        $inm = [
            'identifikasi_pasien' => 100, // %
            'kebersihan_tangan' => 94.5, // %
            'kepuasan_pasien' => 88.2, // %
            'waktu_tunggu_rawat_jalan' => 45, // Menit
        ];

        // === DATA TAB ===
        $dataTab = [];

        if ($this->tabAktif == 'ringkasan') {
            $dataTab['trenKunjungan'] = $this->getTrenKunjungan();
            $dataTab['poliActivity'] = Antrean::with('poli')
                ->whereDate('tanggal_antrean', Carbon::today())
                ->select('poli_id', DB::raw('count(*) as total'))
                ->groupBy('poli_id')
                ->get();
            
            // Tambahan: Statistik Rujukan (NEW)
            $dataTab['statistikRujukan'] = RekamMedis::whereMonth('created_at', Carbon::now()->month)
                ->where('status_pulang', 'Rujuk')
                ->count();

            // Tambahan: Jadwal Dokter Hari Ini
            $dataTab['jadwalDokter'] = \App\Models\JadwalJaga::with(['pegawai', 'shift', 'poli'])
                ->whereDate('tanggal', Carbon::today())
                ->get();

            $dataTab['pasienBaru'] = Pasien::whereMonth('created_at', Carbon::now()->month)->count();
            $dataTab['pasienLama'] = max(0, $totalKunjunganBulanIni - $dataTab['pasienBaru']);

            // Tambahan: Antrean Live Monitoring
            $dataTab['antreanLive'] = Poli::whereHas('antreans', function($q) {
                    $q->whereDate('tanggal_antrean', Carbon::today());
                })
                ->withCount(['antreans as menunggu' => function($q) {
                    $q->whereDate('tanggal_antrean', Carbon::today())->where('status', 'Menunggu');
                }])
                ->get()
                ->map(function($poli) {
                    $sedangDilayani = Antrean::with('pasien')
                        ->where('poli_id', $poli->id)
                        ->whereDate('tanggal_antrean', Carbon::today())
                        ->whereIn('status', ['Dipanggil', 'Sedang Diperiksa'])
                        ->latest('updated_at')
                        ->first();
                    
                    return [
                        'nama_poli' => $poli->nama_poli,
                        'menunggu' => $poli->menunggu,
                        'sedang_dilayani_nama' => $sedangDilayani ? $sedangDilayani->pasien->nama : '-',
                        'sedang_dilayani_nomor' => $sedangDilayani ? $sedangDilayani->nomor_antrean : '-',
                        'status_poli' => $poli->menunggu > 0 || $sedangDilayani ? 'Aktif' : 'Istirahat'
                    ];
                });
        }

        if ($this->tabAktif == 'demografi') {
            // Statistik Gender
            $dataTab['genderStats'] = Pasien::select('jenis_kelamin', DB::raw('count(*) as total'))
                ->groupBy('jenis_kelamin')
                ->get();
            
            // Distribusi Pembayaran
            $dataTab['distribusiPembayaran'] = Antrean::join('pasiens', 'antreans.pasien_id', '=', 'pasiens.id')
                ->whereMonth('antreans.tanggal_antrean', Carbon::now()->month)
                ->select('pasiens.asuransi', DB::raw('count(*) as total'))
                ->groupBy('pasiens.asuransi')
                ->get();
        }

        if ($this->tabAktif == 'klinis') {
            $dataTab['topDiagnosa'] = RekamMedis::select('diagnosa', DB::raw('count(*) as total'))
                ->whereMonth('created_at', Carbon::now()->month)
                ->whereNotNull('diagnosa')
                ->groupBy('diagnosa')
                ->orderByDesc('total')
                ->limit(10)
                ->get();
            
            // Tambahan: Kasus Penyakit Menular Terkini (NEW)
            $penyakitMenular = ['B01', 'A09', 'A01', 'A15', 'B05']; // Contoh kode ICD-10
            $dataTab['kasusMenular'] = RekamMedis::whereIn(DB::raw('SUBSTRING(diagnosa, 1, 3)'), $penyakitMenular)
                ->whereMonth('created_at', Carbon::now()->month)
                ->count();
        }

        if ($this->tabAktif == 'rawat_inap') {
            // Group by Kelas
            $dataTab['kamars'] = Kamar::orderBy('kelas')->get();
            
            // Statistik Bangsal
            $dataTab['borPerBangsal'] = Kamar::select('nama_bangsal', DB::raw('sum(bed_terisi) as terisi'), DB::raw('sum(kapasitas_bed) as kapasitas'))
                ->groupBy('nama_bangsal')
                ->get()
                ->map(function($bangsal) {
                    $bangsal->persentase = $bangsal->kapasitas > 0 ? ($bangsal->terisi / $bangsal->kapasitas) * 100 : 0;
                    return $bangsal;
                });
        }

        return view('livewire.medical.dashboard', compact(
            'totalKunjunganHariIni',
            'totalKunjunganBulanIni',
            'bedTerisi',
            'totalBed',
            'bor',
            'avgWaktuLayanan',
            'inm',
            'dataTab'
        ))->layout('layouts.app', ['header' => 'Pusat Analitik Layanan Medis']);
    }

    private function getTrenKunjungan()
    {
        $data = [];
        $labels = [];
        for ($i = 6; $i >= 0; $i--) {
            $date = Carbon::now()->subDays($i);
            $labels[] = $date->format('d M');
            $data[] = Antrean::whereDate('tanggal_antrean', $date)->count();
        }
        return ['labels' => $labels, 'data' => $data];
    }
}