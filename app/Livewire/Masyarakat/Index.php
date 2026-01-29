<?php

namespace App\Livewire\Masyarakat;

use Livewire\Component;
use App\Models\KegiatanUkm;
use App\Models\Survey;
use App\Models\Pengaduan;
use Livewire\WithPagination;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class Index extends Component
{
    use WithPagination;

    public $activeTab = 'ikhtisar'; // ikhtisar, ukm, survey
    public $search = '';

    public function setTab($tab)
    {
        $this->activeTab = $tab;
    }

    public function render()
    {
        // === GLOBAL STATS ===
        $totalResponden = Survey::count();
        $avgRating = Survey::avg('rating_layanan') ?? 0;
        $ikmScore = ($avgRating / 5) * 100;
        
        $tabData = [];

        // === TAB 1: IKHTISAR ===
        if ($this->activeTab == 'ikhtisar') {
            $tabData['pengaduanPending'] = Pengaduan::where('status', 'Menunggu')->count();
            $tabData['totalKegiatan'] = KegiatanUkm::count();
            
            // Tren Kepuasan 6 Bulan
            $tabData['trenKepuasan'] = $this->getTrenKepuasan();
            
            // Pengaduan Terbaru
            $tabData['pengaduanTerbaru'] = Pengaduan::latest()->take(5)->get();
        }

        // === TAB 2: KEGIATAN UKM ===
        if ($this->activeTab == 'ukm') {
            $tabData['kegiatans'] = KegiatanUkm::where('nama_kegiatan', 'like', '%' . $this->search . '%')
                ->orWhere('lokasi', 'like', '%' . $this->search . '%')
                ->latest('tanggal_kegiatan')
                ->paginate(9); // Grid layout 3x3
        }

        // === TAB 3: SURVEY KEPUASAN ===
        if ($this->activeTab == 'survey') {
            $tabData['surveys'] = Survey::latest()->paginate(10);
            
            // Analisis per Bintang
            $tabData['distribusiBintang'] = Survey::select('rating_layanan', DB::raw('count(*) as total'))
                ->groupBy('rating_layanan')
                ->orderBy('rating_layanan', 'desc')
                ->get();
                
            $tabData['komentarTerbaru'] = Survey::whereNotNull('kritik_saran')
                ->latest()
                ->take(5)
                ->get();
        }

        return view('livewire.masyarakat.index', compact(
            'totalResponden',
            'ikmScore',
            'tabData'
        ))->layout('layouts.app', ['header' => 'Pusat Layanan Masyarakat & UKM']);
    }

    private function getTrenKepuasan()
    {
        $labels = [];
        $data = [];
        
        for ($i = 5; $i >= 0; $i--) {
            $date = Carbon::now()->subMonths($i);
            $labels[] = $date->translatedFormat('M Y');
            
            $avg = Survey::whereMonth('created_at', $date->month)
                ->whereYear('created_at', $date->year)
                ->avg('rating_layanan');
                
            $data[] = round($avg ?? 0, 1);
        }

        return ['labels' => $labels, 'data' => $data];
    }
}