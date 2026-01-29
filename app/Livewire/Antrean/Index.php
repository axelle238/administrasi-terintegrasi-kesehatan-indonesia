<?php

namespace App\Livewire\Antrean;

use App\Models\Antrean;
use App\Models\Pasien;
use App\Models\Poli;
use Carbon\Carbon;
use Livewire\Component;
use App\Services\BpjsBridgingService;

class Index extends Component
{
    // Form for new queue
    public $pasien_id;
    public $poli_id;

    protected $rules = [
        'pasien_id' => 'required|exists:pasiens,id',
        'poli_id' => 'required|exists:polis,id',
    ];

    public function createAntrean(BpjsBridgingService $bpjs)
    {
        $this->validate();

        // Check if patient already has queue today
        $exists = Antrean::where('pasien_id', $this->pasien_id)
            ->whereDate('tanggal_antrean', Carbon::today())
            ->exists();

        if ($exists) {
            $this->dispatch('notify', 'error', 'Pasien ini sudah memiliki antrean hari ini.');
            return;
        }

        $poli = Poli::find($this->poli_id);

        // Generate Nomor Antrean
        $prefix = 'A';
        if (str_contains(strtolower($poli->nama_poli), 'gigi')) $prefix = 'B';
        if (str_contains(strtolower($poli->nama_poli), 'kia')) $prefix = 'C';
        
        $count = Antrean::whereDate('tanggal_antrean', Carbon::today())
                 ->where('poli_id', $this->poli_id)
                 ->count();
        
        $nomor = $prefix . '-' . str_pad($count + 1, 3, '0', STR_PAD_LEFT);
        
        // --- BPJS BRIDGING: Create Visit ---
        $pasien = Pasien::find($this->pasien_id);
        $noKunjunganBPJS = null;
        $kodeBooking = uniqid('BK'); 

        if ($pasien->asuransi == 'BPJS' && !empty($pasien->no_bpjs)) {
            $resp = $bpjs->addPendaftaran([
                'noKartu' => $pasien->no_bpjs,
                'tglDaftar' => date('Y-m-d'),
                'kdPoli' => $poli->kode_poli ?? '001', 
                'noUrut' => $nomor
            ]);

            if ($resp['status'] == 'success') {
                $noKunjunganBPJS = $resp['data']['noKunjungan'];
                $bpjs->updateTaskId($kodeBooking, 1, time() * 1000); 
                $bpjs->updateTaskId($kodeBooking, 2, (time() + 60) * 1000); 
            } else {
                $this->dispatch('notify', 'warning', 'Bridging BPJS Gagal: ' . ($resp['message'] ?? 'Unknown error'));
            }
        }
        // -----------------------------------

        Antrean::create([
            'pasien_id' => $this->pasien_id,
            'poli_id' => $this->poli_id,
            'nomor_antrean' => $nomor,
            'tanggal_antrean' => Carbon::today(),
            'status' => 'Menunggu',
            'no_kunjungan_bpjs' => $noKunjunganBPJS,
            'kode_booking' => $kodeBooking,
            'task_id_last' => 2
        ]);

        $this->reset('pasien_id');
        $this->dispatch('notify', 'success', "Nomor Antrean $nomor berhasil dibuat.");
    }

    public function updateStatus($id, $status, BpjsBridgingService $bpjs)
    {
        $antrean = Antrean::find($id);
        if ($antrean) {
            $antrean->update(['status' => $status]);
            
            // --- BPJS BRIDGING: Update Task ID ---
            if ($antrean->kode_booking) {
                $taskId = 0;
                // Mapping Status
                if ($status == 'Diperiksa') $taskId = 3; 
                if ($status == 'Farmasi') $taskId = 5; 
                if ($status == 'Selesai') $taskId = 7; 

                if ($taskId > $antrean->task_id_last) {
                    $bpjs->updateTaskId($antrean->kode_booking, $taskId, time() * 1000);
                    $antrean->update(['task_id_last' => $taskId]);
                }
            }
            
            if ($status == 'Diperiksa') {
                $this->dispatch('play-audio', 'calling.mp3'); 
            }
            
            $this->dispatch('notify', 'success', "Status antrean $antrean->nomor_antrean diubah menjadi $status.");
        }
    }

    public function delete($id)
    {
        $antrean = Antrean::find($id);
        if ($antrean) {
            $antrean->delete();
            $this->dispatch('notify', 'success', 'Antrean dihapus.');
        }
    }

    public $searchPasien = '';

    public function render()
    {
        $query = Antrean::with(['pasien', 'poli'])->whereDate('tanggal_antrean', Carbon::today());
        
        // Statistik Realtime
        $totalAntrean = (clone $query)->count();
        $sisaAntrean = (clone $query)->where('status', 'Menunggu')->count();
        $sedangDiproses = (clone $query)->whereIn('status', ['Diperiksa', 'Farmasi'])->count();
        $selesai = (clone $query)->where('status', 'Selesai')->count();

        // Data Utama
        $antreans = $query
            ->orderByRaw("FIELD(status, 'Diperiksa', 'Menunggu', 'Farmasi', 'Selesai', 'Batal')")
            ->orderBy('id', 'asc')
            ->get();

        $pasiens = Pasien::where('nama_lengkap', 'like', '%' . $this->searchPasien . '%')
            ->orWhere('nik', 'like', '%' . $this->searchPasien . '%')
            ->orderBy('nama_lengkap')
            ->limit(20) 
            ->get();
            
        $polis = Poli::all();

        return view('livewire.antrean.index', compact(
            'antreans', 
            'pasiens', 
            'polis',
            'totalAntrean',
            'sisaAntrean',
            'sedangDiproses',
            'selesai'
        ))->layout('layouts.app', ['header' => 'Manajemen Antrean Harian']);
    }
}