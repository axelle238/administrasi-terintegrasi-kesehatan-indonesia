<?php

namespace App\Livewire\RawatInap;

use App\Models\Kamar;
use Livewire\Component;
use Livewire\WithPagination;

class KamarIndex extends Component
{
    use WithPagination;

    public $search = '';
    public $isOpen = false;
    public $kamarId;

    public $nomor_kamar;
    public $nama_bangsal;
    public $kapasitas_bed = 4;
    public $harga_per_malam;
    public $is_kris_compliant = true;
    public $status = 'Tersedia';

    protected $rules = [
        'nomor_kamar' => 'required|string|unique:kamars,nomor_kamar',
        'nama_bangsal' => 'required|string',
        'kapasitas_bed' => 'required|numeric|max:4', // Perpres 59/2024 KRIS limit
        'harga_per_malam' => 'required|numeric',
    ];

    public function create()
    {
        $this->resetInput();
        $this->isOpen = true;
    }

    public function resetInput()
    {
        $this->reset(['kamarId', 'nomor_kamar', 'nama_bangsal', 'kapasitas_bed', 'harga_per_malam', 'is_kris_compliant', 'status']);
    }

    public function edit($id)
    {
        $kamar = Kamar::findOrFail($id);
        $this->kamarId = $id;
        $this->nomor_kamar = $kamar->nomor_kamar;
        $this->nama_bangsal = $kamar->nama_bangsal;
        $this->kapasitas_bed = $kamar->kapasitas_bed;
        $this->harga_per_malam = $kamar->harga_per_malam;
        $this->is_kris_compliant = $kamar->is_kris_compliant;
        $this->status = $kamar->status;
        $this->isOpen = true;
    }

    public function save()
    {
        if ($this->kamarId) {
            $this->validate([
                'nomor_kamar' => 'required|string|unique:kamars,nomor_kamar,' . $this->kamarId,
                'nama_bangsal' => 'required|string',
                'kapasitas_bed' => 'required|numeric|max:4',
                'harga_per_malam' => 'required|numeric',
            ]);

            Kamar::find($this->kamarId)->update([
                'nomor_kamar' => $this->nomor_kamar,
                'nama_bangsal' => $this->nama_bangsal,
                'kapasitas_bed' => $this->kapasitas_bed,
                'harga_per_malam' => $this->harga_per_malam,
                'is_kris_compliant' => $this->is_kris_compliant,
                'status' => $this->status,
            ]);
            $this->dispatch('notify', 'success', 'Data kamar diperbarui.');
        } else {
            $this->validate();
            Kamar::create([
                'nomor_kamar' => $this->nomor_kamar,
                'nama_bangsal' => $this->nama_bangsal,
                'kapasitas_bed' => $this->kapasitas_bed,
                'harga_per_malam' => $this->harga_per_malam,
                'is_kris_compliant' => $this->is_kris_compliant,
                'status' => $this->status,
            ]);
            $this->dispatch('notify', 'success', 'Kamar baru ditambahkan.');
        }

        $this->isOpen = false;
    }

    public function render()
    {
        $kamars = Kamar::where('nomor_kamar', 'like', '%' . $this->search . '%')
            ->orWhere('nama_bangsal', 'like', '%' . $this->search . '%')
            ->paginate(10);

        return view('livewire.rawat-inap.kamar-index', [
            'kamars' => $kamars
        ])->layout('layouts.app', ['header' => 'Manajemen Kamar (KRIS Standard)']);
    }
}