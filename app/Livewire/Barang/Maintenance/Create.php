<?php

namespace App\Livewire\Barang\Maintenance;

use Livewire\Component;
use Livewire\WithFileUploads;
use App\Models\Maintenance as MaintenanceModel;
use App\Models\Barang;

class Create extends Component
{
    use WithFileUploads;

    public $barang_id;
    public $tanggal_maintenance;
    public $jenis_kegiatan = 'Pemeliharaan Rutin';
    public $keterangan;
    public $teknisi;
    public $biaya = 0;
    public $tanggal_berikutnya;
    public $file_sertifikat;

    public function mount()
    {
        $this->tanggal_maintenance = date('Y-m-d');
    }

    public function save()
    {
        $this->validate([
            'barang_id' => 'required|exists:barangs,id',
            'tanggal_maintenance' => 'required|date',
            'jenis_kegiatan' => 'required|string',
            'biaya' => 'numeric|min:0',
            'file_sertifikat' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:5120',
        ]);

        $path = null;
        if ($this->file_sertifikat) {
            $path = $this->file_sertifikat->store('sertifikat-maintenance', 'public');
        }

        MaintenanceModel::create([
            'barang_id' => $this->barang_id,
            'tanggal_maintenance' => $this->tanggal_maintenance,
            'jenis_kegiatan' => $this->jenis_kegiatan,
            'keterangan' => $this->keterangan,
            'teknisi' => $this->teknisi,
            'biaya' => $this->biaya,
            'tanggal_berikutnya' => $this->tanggal_berikutnya,
            'file_sertifikat' => $path,
        ]);

        if ($this->jenis_kegiatan == 'Perbaikan') {
            $barang = Barang::find($this->barang_id);
            if ($barang->kondisi == 'Rusak' || $barang->kondisi == 'Rusak Berat') {
                $barang->update(['kondisi' => 'Baik']);
            }
        }

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
        return $this->redirect(route('barang.maintenance'), navigate: true);
    }

    public function render()
    {
        return view('livewire.barang.maintenance.create', [
            'barangs' => Barang::orderBy('nama_barang')->get(),
        ])->layout('layouts.app', ['header' => 'Input Jadwal Maintenance']);
    }
}