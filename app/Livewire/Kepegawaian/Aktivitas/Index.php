<?php

namespace App\Livewire\Kepegawaian\Aktivitas;

use App\Models\LaporanKinerjaHarian;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\WithFileUploads;
use Carbon\Carbon;

class Index extends Component
{
    use WithFileUploads;

    public $tanggal_filter;
    
    // Form Inputs
    public $jam_mulai;
    public $jam_selesai;
    public $aktivitas;
    public $deskripsi;
    public $output;
    public $file_bukti;

    public function mount()
    {
        $this->tanggal_filter = date('Y-m-d');
        $this->jam_mulai = now()->format('H:i');
        $this->jam_selesai = now()->addHour()->format('H:i');
    }

    public function save()
    {
        $this->validate([
            'jam_mulai' => 'required',
            'jam_selesai' => 'required|after:jam_mulai',
            'aktivitas' => 'required|string|max:255',
            'output' => 'nullable|string|max:100',
            'file_bukti' => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:2048',
        ]);

        $path = null;
        if ($this->file_bukti) {
            $path = $this->file_bukti->store('bukti-aktivitas', 'public');
        }

        LaporanKinerjaHarian::create([
            'user_id' => Auth::id(),
            'tanggal' => $this->tanggal_filter, // Input untuk tanggal yang dipilih
            'jam_mulai' => $this->jam_mulai,
            'jam_selesai' => $this->jam_selesai,
            'aktivitas' => $this->aktivitas,
            'deskripsi' => $this->deskripsi,
            'output' => $this->output,
            'file_bukti' => $path,
            'status' => 'Draft' // Default draft, nanti bisa ada tombol "Ajukan Harian"
        ]);

        $this->dispatch('notify', 'success', 'Aktivitas berhasil dicatat.');
        $this->reset(['aktivitas', 'deskripsi', 'output', 'file_bukti']);
    }

    public function delete($id)
    {
        $log = LaporanKinerjaHarian::where('user_id', Auth::id())->find($id);
        if ($log && $log->status == 'Draft') {
            $log->delete();
            $this->dispatch('notify', 'success', 'Aktivitas dihapus.');
        }
    }

    public function render()
    {
        $logs = LaporanKinerjaHarian::where('user_id', Auth::id())
            ->whereDate('tanggal', $this->tanggal_filter)
            ->orderBy('jam_mulai')
            ->get();

        // Hitung total durasi
        $totalMenit = 0;
        foreach ($logs as $log) {
            $start = Carbon::parse($log->jam_mulai);
            $end = Carbon::parse($log->jam_selesai);
            $totalMenit += $end->diffInMinutes($start);
        }
        
        $totalJam = floor($totalMenit / 60);
        $sisaMenit = $totalMenit % 60;
        $totalDurasi = sprintf('%02d Jam %02d Menit', $totalJam, $sisaMenit);
        
        // Progress Bar (Target 450 menit / 7.5 Jam)
        $progress = min(100, ($totalMenit / 450) * 100);

        return view('livewire.kepegawaian.aktivitas.index', [
            'logs' => $logs,
            'totalDurasi' => $totalDurasi,
            'progress' => $progress
        ])->layout('layouts.app', ['header' => 'Laporan Kinerja Harian (LKH)']);
    }
}
