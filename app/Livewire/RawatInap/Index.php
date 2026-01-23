<?php

namespace App\Livewire\RawatInap;

use App\Models\RawatInap;
use App\Models\Pasien;
use App\Models\Kamar;
use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Support\Facades\DB;

class Index extends Component
{
    use WithPagination;

    public $search = '';
    public $isOpen = false;
    public $admissionId;

    public $pasien_id;
    public $kamar_id;
    public $waktu_masuk;
    public $diagnosa_awal;
    public $jenis_pembayaran = 'Umum';

    // Checkout Modal
    public $isCheckoutOpen = false;
    public $waktu_keluar;
    public $diagnosa_akhir;
    public $checkoutStatus = 'Pulang';

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

    public function create()
    {
        $this->resetInput();
        $this->waktu_masuk = now()->format('Y-m-d\TH:i');
        $this->isOpen = true;
    }

    public function resetInput()
    {
        $this->reset(['admissionId', 'pasien_id', 'kamar_id', 'diagnosa_awal', 'jenis_pembayaran']);
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
            $this->isOpen = false;

        } catch (\Exception $e) {
            DB::rollBack();
            $this->dispatch('notify', 'error', 'Gagal: ' . $e->getMessage());
        }
    }

    public function openCheckout($id)
    {
        $this->admissionId = $id;
        $this->waktu_keluar = now()->format('Y-m-d\TH:i');
        $this->isCheckoutOpen = true;
    }

    public function checkout()
    {
        $this->validate([
            'waktu_keluar' => 'required',
            'diagnosa_akhir' => 'required',
            'checkoutStatus' => 'required',
        ]);

        try {
            DB::beginTransaction();

            $admission = RawatInap::findOrFail($this->admissionId);
            $admission->update([
                'waktu_keluar' => $this->waktu_keluar,
                'diagnosa_akhir' => $this->diagnosa_akhir,
                'status' => $this->checkoutStatus,
            ]);

            $kamar = Kamar::find($admission->kamar_id);
            $kamar->decrement('bed_terisi');
            $kamar->update(['status' => 'Tersedia']);

            DB::commit();
            $this->dispatch('notify', 'success', 'Pasien berhasil dipulangkan/diproses keluar.');
            $this->isCheckoutOpen = false;

        } catch (\Exception $e) {
            DB::rollBack();
            $this->dispatch('notify', 'error', 'Gagal checkout: ' . $e->getMessage());
        }
    }

    public function render()
    {
        $admissions = RawatInap::with(['pasien', 'kamar'])
            ->whereHas('pasien', function($q) {
                $q->where('nama_lengkap', 'like', '%' . $this->search . '%');
            })
            ->latest('waktu_masuk')
            ->paginate(10);

        $availableKamars = Kamar::where('status', 'Tersedia')->get();
        $pasiens = Pasien::orderBy('nama_lengkap')->limit(50)->get();

        return view('livewire.rawat-inap.index', [
            'admissions' => $admissions,
            'availableKamars' => $availableKamars,
            'pasiens' => $pasiens
        ])->layout('layouts.app', ['header' => 'Layanan Rawat Inap']);
    }
}