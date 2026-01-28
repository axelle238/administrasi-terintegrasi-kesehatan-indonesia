<?php

namespace App\Livewire\Barang\Maintenance;

use App\Models\Barang;
use App\Models\Maintenance;
use Livewire\Component;

class Create extends Component
{
    public Barang $barang;
    
    public $m_tanggal;
    public $m_kegiatan = 'Pemeliharaan Rutin';
    public $m_teknisi;
    public $m_biaya = 0;
    public $m_keterangan;
    public $m_tanggal_berikutnya;

    protected $rules = [
        'm_tanggal' => 'required|date',
        'm_kegiatan' => 'required|string',
        'm_biaya' => 'numeric|min:0',
        'm_teknisi' => 'nullable|string',
        'm_keterangan' => 'nullable|string',
        'm_tanggal_berikutnya' => 'nullable|date',
    ];

    public function mount(Barang $barang)
    {
        $this->barang = $barang;
        $this->m_tanggal = now()->format('Y-m-d');
    }

    public function save()
    {
        $this->validate();

        Maintenance::create([
            'barang_id' => $this->barang->id,
            'tanggal_maintenance' => $this->m_tanggal,
            'jenis_kegiatan' => $this->m_kegiatan,
            'keterangan' => $this->m_keterangan,
            'teknisi' => $this->m_teknisi,
            'biaya' => $this->m_biaya,
            'tanggal_berikutnya' => $this->m_tanggal_berikutnya
        ]);

        $this->dispatch('notify', 'success', 'Data pemeliharaan berhasil ditambahkan.');
        return $this->redirect(route('barang.show', $this->barang->id), navigate: true);
    }

    public function render()
    {
        return view('livewire.barang.maintenance.create')->layout('layouts.app', ['header' => 'Catat Pemeliharaan Aset']);
    }
}
