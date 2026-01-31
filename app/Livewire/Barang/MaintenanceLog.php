<?php

namespace App\Livewire\Barang;

use App\Models\Maintenance as MaintenanceModel;
use App\Models\Barang;
use Livewire\Component;
use Livewire\WithPagination;

class MaintenanceLog extends Component
{
    use WithPagination;

    public $search = '';
    public $isOpen = false;
    
    // Form
    public $barang_id;
    public $tanggal_maintenance;
    public $jenis_kegiatan = 'Pemeliharaan Rutin';
    public $keterangan;
    public $teknisi;
    public $biaya = 0;
    public $tanggal_berikutnya;

    protected $rules = [
        'barang_id' => 'required|exists:barangs,id',
        'tanggal_maintenance' => 'required|date',
        'jenis_kegiatan' => 'required|string',
        'biaya' => 'numeric|min:0',
    ];

    public function create()
    {
        $this->resetInput();
        $this->tanggal_maintenance = date('Y-m-d');
        $this->isOpen = true;
    }

    public function resetInput()
    {
        $this->reset(['barang_id', 'jenis_kegiatan', 'keterangan', 'teknisi', 'biaya', 'tanggal_berikutnya']);
    }

    public function save()
    {
        $this->validate();

        MaintenanceModel::create([
            'barang_id' => $this->barang_id,
            'tanggal_maintenance' => $this->tanggal_maintenance,
            'jenis_kegiatan' => $this->jenis_kegiatan,
            'keterangan' => $this->keterangan,
            'teknisi' => $this->teknisi,
            'biaya' => $this->biaya,
            'tanggal_berikutnya' => $this->tanggal_berikutnya,
        ]);

        // Optional: Update asset condition if it was repair
        if ($this->jenis_kegiatan == 'Perbaikan') {
            $barang = Barang::find($this->barang_id);
            if ($barang->kondisi == 'Rusak' || $barang->kondisi == 'Rusak Berat') {
                $barang->update(['kondisi' => 'Baik']);
            }
        }

        // Auto-update Calibration Data for Medical Assets
        if ($this->jenis_kegiatan == 'Kalibrasi') {
            $barang = Barang::with('detailMedis')->find($this->barang_id);
            if ($barang && $barang->detailMedis) {
                $barang->detailMedis->update([
                    'kalibrasi_terakhir' => $this->tanggal_maintenance,
                    'kalibrasi_selanjutnya' => $this->tanggal_berikutnya,
                ]);
            }
        }

        $this->dispatch('notify', 'success', 'Catatan pemeliharaan disimpan.');
        $this->isOpen = false;
    }

    public function render()
    {
        $maintenances = MaintenanceModel::with('barang')
            ->whereHas('barang', function($q) {
                $q->where('nama_barang', 'like', '%' . $this->search . '%');
            })
            ->latest('tanggal_maintenance')
            ->paginate(10);

        $barangs = Barang::orderBy('nama_barang')->get();

        return view('livewire.barang.maintenance', [
            'maintenances' => $maintenances,
            'barangs' => $barangs
        ])->layout('layouts.app', ['header' => 'Log Pemeliharaan & Kalibrasi Aset']);
    }
}