<?php

namespace App\Livewire\RawatInap;

use App\Models\RawatInap;
use App\Models\Kamar;
use Livewire\Component;
use Illuminate\Support\Facades\DB;

class Checkout extends Component
{
    public RawatInap $rawatInap;
    
    public $waktu_keluar;
    public $diagnosa_akhir;
    public $checkoutStatus = 'Pulang';

    protected $rules = [
        'waktu_keluar' => 'required',
        'diagnosa_akhir' => 'required|string',
        'checkoutStatus' => 'required',
    ];

    public function mount(RawatInap $rawatInap)
    {
        $this->rawatInap = $rawatInap;
        $this->waktu_keluar = now()->format('Y-m-d\TH:i');
    }

    public function save()
    {
        $this->validate();

        try {
            DB::beginTransaction();

            $this->rawatInap->update([
                'waktu_keluar' => $this->waktu_keluar,
                'diagnosa_akhir' => $this->diagnosa_akhir,
                'status' => $this->checkoutStatus,
            ]);

            $kamar = Kamar::find($this->rawatInap->kamar_id);
            if ($kamar) {
                $kamar->decrement('bed_terisi');
                // Jika sebelumnya penuh dan sekarang berkurang, status jadi tersedia
                if ($kamar->bed_terisi < $kamar->kapasitas_bed) {
                    $kamar->update(['status' => 'Tersedia']);
                }
            }

            DB::commit();
            $this->dispatch('notify', 'success', 'Pasien berhasil dipulangkan.');
            return $this->redirect(route('rawat-inap.index'), navigate: true);

        } catch (\Exception $e) {
            DB::rollBack();
            $this->dispatch('notify', 'error', 'Gagal: ' . $e->getMessage());
        }
    }

    public function render()
    {
        return view('livewire.rawat-inap.checkout')->layout('layouts.app', ['header' => 'Checkout / Pulang Pasien']);
    }
}
