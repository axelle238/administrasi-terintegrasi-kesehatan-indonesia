<?php

namespace App\Livewire\RawatInap;

use App\Models\RawatInap;
use App\Models\Pasien;
use App\Models\Kamar;
use Livewire\Component;
use Illuminate\Support\Facades\DB;

class Create extends Component
{
    public $pasien_id;
    public $kamar_id;
    public $waktu_masuk;
    public $diagnosa_awal;
    public $jenis_pembayaran = 'Umum';

    protected $rules = [
        'pasien_id' => 'required|exists:pasiens,id',
        'kamar_id' => 'required|exists:kamars,id',
        'waktu_masuk' => 'required',
        'diagnosa_awal' => 'required|string',
    ];

    public function mount()
    {
        $this->waktu_masuk = now()->format('Y-m-d\TH:i');
    }

    public function save()
    {
        $this->validate();

        try {
            DB::beginTransaction();

            $kamar = Kamar::findOrFail($this->kamar_id);
            if ($kamar->bed_terisi >= $kamar->kapasitas_bed) {
                throw new \Exception("Kamar ini sudah penuh.");
            }

            RawatInap::create([
                'pasien_id' => $this->pasien_id,
                'kamar_id' => $this->kamar_id,
                'waktu_masuk' => $this->waktu_masuk,
                'diagnosa_awal' => $this->diagnosa_awal,
                'jenis_pembayaran' => $this->jenis_pembayaran,
                'status' => 'Aktif',
            ]);

            $kamar->increment('bed_terisi');
            if ($kamar->bed_terisi >= $kamar->kapasitas_bed) {
                $kamar->update(['status' => 'Penuh']);
            }

            DB::commit();
            $this->dispatch('notify', 'success', 'Pasien berhasil dirawat inap.');
            return $this->redirect(route('rawat-inap.index'), navigate: true);

        } catch (\Exception $e) {
            DB::rollBack();
            $this->dispatch('notify', 'error', 'Gagal: ' . $e->getMessage());
        }
    }

    public $searchPasien = '';

    public function render()
    {
        $availableKamars = Kamar::where('status', 'Tersedia')->get();
        $pasiens = Pasien::where('nama_lengkap', 'like', '%' . $this->searchPasien . '%')
            ->orWhere('nik', 'like', '%' . $this->searchPasien . '%')
            ->orderBy('nama_lengkap')
            ->limit(20)
            ->get();

        return view('livewire.rawat-inap.create', [
            'availableKamars' => $availableKamars,
            'pasiens' => $pasiens
        ])->layout('layouts.app', ['header' => 'Pendaftaran Rawat Inap']);
    }
}
