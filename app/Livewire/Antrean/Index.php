<?php

namespace App\Livewire\Antrean;

use App\Models\Antrean;
use App\Models\Pasien;
use App\Models\Poli;
use App\Services\AntreanService;
use App\Services\BpjsBridgingService;
use App\Services\NotifikasiService;
use Carbon\Carbon;
use Livewire\Component;

class Index extends Component
{
    // Form Antrean Baru
    public $pasien_id;
    public $poli_id;
    public $searchPasien = '';

    protected $rules = [
        'pasien_id' => 'required|exists:pasiens,id',
        'poli_id' => 'required|exists:polis,id',
    ];

    public function createAntrean(AntreanService $antreanService, BpjsBridgingService $bpjs)
    {
        $this->validate([
            'pasien_id' => 'required|exists:pasiens,id',
            'poli_id' => 'required|exists:polis,id',
        ], [
            'pasien_id.required' => 'Pasien harus dipilih.',
            'poli_id.required' => 'Poli tujuan harus dipilih.'
        ]);

        // Cek duplikasi hari ini
        $exists = Antrean::where('pasien_id', $this->pasien_id)
            ->whereDate('tanggal_antrean', Carbon::today())
            ->exists();

        if ($exists) {
            $this->dispatch('notify', 'error', 'Pasien ini sudah memiliki antrean hari ini.');
            return;
        }

        // Gunakan Service untuk Logic Antrean
        $antrean = $antreanService->buatAntrean(
            $this->pasien_id,
            $this->poli_id,
            'admisi' // Sumber pendaftaran manual (Admisi)
        );

        $pasien = Pasien::find($this->pasien_id);
        $poli = Poli::find($this->poli_id);

        // --- BPJS BRIDGING (Opsional) ---
        if ($pasien->asuransi == 'BPJS' && !empty($pasien->no_bpjs)) {
            $resp = $bpjs->addPendaftaran([
                'noKartu' => $pasien->no_bpjs,
                'tglDaftar' => date('Y-m-d'),
                'kdPoli' => $poli->kode_poli_bpjs ?? '001', 
                'noUrut' => $antrean->nomor_antrean
            ]);

            if (isset($resp['status']) && $resp['status'] == 'success') {
                $antrean->update([
                    'no_kunjungan_bpjs' => $resp['data']['noKunjungan'],
                    'kode_booking' => uniqid('BK'), // Simulasi
                ]);
                // Kirim TaskID 1 & 2
                // $bpjs->updateTaskId(...)
            } else {
                NotifikasiService::send(auth()->user(), 'Bridging BPJS', 'Gagal bridging antrean: ' . ($resp['message'] ?? 'Unknown'), '#', 'warning');
            }
        }
        
        $this->reset(['pasien_id', 'searchPasien']);
        $this->dispatch('notify', 'success', "Nomor Antrean {$antrean->nomor_antrean} berhasil dibuat.");
    }

    public function updateStatus($id, $status, BpjsBridgingService $bpjs)
    {
        $antrean = Antrean::find($id);
        if ($antrean) {
            $antrean->update(['status' => $status]);
            
            // BPJS Task ID logic di sini jika perlu
            // ...
            
            $this->dispatch('notify', 'success', "Status antrean diubah menjadi $status.");
        }
    }

    public function render()
    {
        $query = Antrean::with(['pasien', 'poli'])->whereDate('tanggal_antrean', Carbon::today());
        
        // Statistik
        $totalAntrean = (clone $query)->count();
        $sisaAntrean = (clone $query)->where('status', 'Menunggu')->count();
        $sedangDiproses = (clone $query)->whereIn('status', ['Diperiksa', 'Farmasi'])->count();
        $selesai = (clone $query)->where('status', 'Selesai')->count();

        // Data Table
        $antreans = $query
            ->orderByRaw("FIELD(status, 'Diperiksa', 'Menunggu', 'Farmasi', 'Selesai', 'Batal')")
            ->orderBy('id', 'asc')
            ->get();

        // Pencarian Pasien Efisien
        $pasiens = [];
        if (strlen($this->searchPasien) >= 2) {
            $pasiens = Pasien::where('nama_lengkap', 'like', '%' . $this->searchPasien . '%')
                ->orWhere('nik', 'like', $this->searchPasien . '%')
                ->orWhere('no_bpjs', 'like', $this->searchPasien . '%')
                ->limit(10) 
                ->get();
        }
            
        $polis = Poli::where('status_aktif', true)->get();

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
