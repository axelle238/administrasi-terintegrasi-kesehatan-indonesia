<?php

namespace App\Livewire\Apotek;

use App\Models\Obat;
use App\Models\RekamMedis;
use App\Models\Antrean;
use App\Models\TransaksiObat;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

use App\Services\WhatsAppService;

class Process extends Component
{
    public RekamMedis $rekamMedis;
    public $details = [];

    public function mount(RekamMedis $rekamMedis)
    {
        $this->rekamMedis = $rekamMedis;
        
        // Load prescribed drugs
        // The rekam_medis_obat pivot contains prescribed items
        foreach ($rekamMedis->obats as $obat) {
            $this->details[] = [
                'obat_id' => $obat->id,
                'nama_obat' => $obat->nama_obat,
                'kode_obat' => $obat->kode_obat,
                'satuan' => $obat->satuan,
                'stok_current' => $obat->stok,
                'jumlah_resep' => $obat->pivot->jumlah,
                'aturan_pakai' => $obat->pivot->aturan_pakai,
            ];
        }
    }

    public function process()
    {
        try {
            DB::beginTransaction();

            foreach ($this->details as $item) {
                // ... (existing logic)
                $obat = Obat::lockForUpdate()->find($item['obat_id']);
                
                $qtyNeeded = $item['jumlah_resep'];

                // Check total stock available in batches
                $totalBatchStock = $obat->batches()
                    ->where('stok', '>', 0)
                    ->where('tanggal_kedaluwarsa', '>=', now())
                    ->sum('stok');

                // Fallback: If no batches (legacy data), check master stock
                if ($totalBatchStock == 0 && $obat->stok >= $qtyNeeded) {
                    $obat->decrement('stok', $qtyNeeded);
                } elseif ($totalBatchStock >= $qtyNeeded) {
                    // FEFO Logic
                    $batches = $obat->batches()
                        ->where('stok', '>', 0)
                        ->where('tanggal_kedaluwarsa', '>=', now())
                        ->orderBy('tanggal_kedaluwarsa', 'asc')
                        ->get();

                    foreach ($batches as $batch) {
                        if ($qtyNeeded <= 0) break;

                        if ($batch->stok >= $qtyNeeded) {
                            $batch->decrement('stok', $qtyNeeded);
                            $qtyNeeded = 0;
                        } else {
                            $qtyNeeded -= $batch->stok;
                            $batch->update(['stok' => 0]);
                        }
                    }
                    $obat->refreshStok();
                } else {
                    throw new \Exception("Stok obat {$obat->nama_obat} tidak mencukupi (Batch Available: $totalBatchStock).");
                }

                // 2. Catat Riwayat Transaksi (PENTING untuk Audit & LPLPO)
                TransaksiObat::create([
                    'obat_id' => $item['obat_id'],
                    'rekam_medis_id' => $this->rekamMedis->id, // Link to RME
                    'jenis_transaksi' => 'Keluar',
                    'jumlah' => $item['jumlah_resep'],
                    'tanggal_transaksi' => now(),
                    'keterangan' => "Resep Pasien: " . $this->rekamMedis->pasien->nama_lengkap,
                    'pencatat' => Auth::user()->name ?? 'Apoteker'
                ]);
            }

            // Update Status Rekam Medis
            $this->rekamMedis->update(['status_resep' => 'Selesai']);

            // Update Antrean Status to Selesai (or Kasir if paid?)
            $antrean = Antrean::where('pasien_id', $this->rekamMedis->pasien_id)
                ->whereDate('tanggal_antrean', now())
                ->latest()
                ->first();
            
            if ($antrean) {
                // If Umum, go to Kasir. If BPJS, technically Kasir needs to process for "Free" invoice but Selesai is fine too.
                // Let's standardise: All go to Kasir for final check/billing.
                $antrean->update(['status' => 'Kasir']);
            }

            DB::commit();

            // Kirim Notifikasi WA (Simulasi)
            if ($this->rekamMedis->pasien->no_telepon) {
                $msg = "Halo Bpk/Ibu {$this->rekamMedis->pasien->nama_lengkap}, Obat Anda sudah siap diambil di Farmasi Puskesmas Jagakarsa. Terima kasih.";
                WhatsAppService::send($this->rekamMedis->pasien->no_telepon, $msg);
            }

            $this->dispatch('notify', 'success', 'Resep berhasil diserahkan.');
            return $this->redirect(route('apotek.index'), navigate: true);

        } catch (\Exception $e) {
            DB::rollback();
            $this->dispatch('notify', 'error', 'Gagal memproses: ' . $e->getMessage());
        }
    }

    public function render()
    {
        return view('livewire.apotek.process', [
            'pasien' => $this->rekamMedis->pasien,
            'dokter' => $this->rekamMedis->dokter
        ])->layout('layouts.app', ['header' => 'Proses Penyerahan Obat (Farmasi)']);
    }
}
