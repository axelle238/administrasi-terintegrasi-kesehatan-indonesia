<?php

namespace App\Livewire\Pasien;

use App\Models\Pasien;
use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class Index extends Component
{
    use WithPagination;

    public $search = '';

    // Menghapus data pasien
    public function delete($id)
    {
        $pasien = Pasien::find($id);
        if ($pasien) {
            if ($pasien->rekamMedis()->exists()) {
                 $this->dispatch('notify', 'error', 'Tidak dapat menghapus: Pasien memiliki riwayat rekam medis.');
                 return;
            }
            
            $pasien->delete();
            $this->dispatch('notify', 'success', 'Data pasien berhasil dihapus.');
        }
    }

    public function render()
    {
        // === STATISTIK MINI-DASHBOARD ===
        $totalPasien = Pasien::count();
        $pasienBaruHariIni = Pasien::whereDate('created_at', Carbon::today())->count();
        
        // Asuransi
        $statsAsuransi = Pasien::select('asuransi', DB::raw('count(*) as total'))
            ->groupBy('asuransi')
            ->pluck('total', 'asuransi')
            ->toArray();
        $bpjsCount = $statsAsuransi['BPJS'] ?? 0;
        $umumCount = $totalPasien - $bpjsCount; // Asumsi null/lainnya adalah umum

        // Gender
        $statsGender = Pasien::select('jenis_kelamin', DB::raw('count(*) as total'))
            ->groupBy('jenis_kelamin')
            ->pluck('total', 'jenis_kelamin')
            ->toArray();
        $priaCount = $statsGender['L'] ?? 0;
        $wanitaCount = $statsGender['P'] ?? 0;

        // === QUERY DATA UTAMA ===
        $pasiens = Pasien::query()
            ->when($this->search, function($q) {
                $q->where('nama_lengkap', 'like', '%' . $this->search . '%')
                  ->orWhere('nik', 'like', '%' . $this->search . '%')
                  ->orWhere('no_rm', 'like', '%' . $this->search . '%') // Tambahkan pencarian No RM
                  ->orWhere('no_bpjs', 'like', '%' . $this->search . '%');
            })
            ->latest()
            ->paginate(10);

        return view('livewire.pasien.index', compact(
            'pasiens', 
            'totalPasien', 
            'pasienBaruHariIni', 
            'bpjsCount', 
            'umumCount', 
            'priaCount', 
            'wanitaCount'
        ))->layout('layouts.app', ['header' => 'Database Pasien']);
    }
}
