<?php

namespace App\Livewire\Kepegawaian\Presensi;

use Livewire\Component;
use App\Models\Presensi;
use App\Services\PresensiService;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class Index extends Component
{
    public $currentTime;
    public $todayPresensi;
    public $lokasi = null; // Placeholder untuk koordinat
    
    public function mount()
    {
        $this->currentTime = Carbon::now()->translatedFormat('l, d F Y H:i');
        $this->todayPresensi = Presensi::where('user_id', Auth::id())
            ->whereDate('tanggal', Carbon::today())
            ->first();
    }

    public function absenMasuk(PresensiService $service)
    {
        // Simulasi Data (Idealnya dari JS navigator.geolocation)
        $data = [
            'koordinat' => '-6.2088,106.8456', 
            'alamat' => 'Kantor Pusat',
            'foto' => 'path/to/dummy_photo.jpg'
        ];

        try {
            $service->absenMasuk(Auth::id(), $data);
            
            // Redirect ke History/Dashboard agar user melihat 'Integrasi'
            session()->flash('message', 'Presensi Masuk Berhasil! Draft Laporan Aktivitas telah dibuat.');
            return redirect()->route('kepegawaian.presensi.history');
            
        } catch (\Exception $e) {
            session()->flash('error', $e->getMessage());
        }
    }

    public function absenKeluar(PresensiService $service)
    {
        $data = ['koordinat' => '-6.2088,106.8456', 'alamat' => 'Kantor Pusat'];
        
        try {
            $service->absenKeluar(Auth::id(), $data);
            
            session()->flash('message', 'Presensi Pulang Berhasil. Terima kasih atas kerja keras Anda!');
            return redirect()->route('kepegawaian.presensi.history');
            
        } catch (\Exception $e) {
            session()->flash('error', $e->getMessage());
        }
    }

    public function render()
    {
        return view('livewire.kepegawaian.presensi.index')
            ->layout('layouts.app', ['header' => 'Presensi Digital']);
    }
}