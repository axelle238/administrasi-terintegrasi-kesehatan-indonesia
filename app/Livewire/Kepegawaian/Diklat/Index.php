<?php

namespace App\Livewire\Kepegawaian\Diklat;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Diklat;
use App\Models\DiklatPeserta;
use App\Models\Pegawai;
use Carbon\Carbon;

class Index extends Component
{
    use WithPagination;

    public $search = '';
    public $filterStatus = 'all';

    // Form State
    public $isFormOpen = false;
    public $isEditing = false;
    public $diklatId;

    // Form Fields
    public $nama_kegiatan, $jenis_diklat, $penyelenggara, $lokasi;
    public $tanggal_mulai, $tanggal_selesai, $total_jam_pelajaran, $biaya;
    public $status = 'Rencana';
    public $keterangan;
    
    // Peserta Management (Multi-select simulation)
    public $selectedPegawais = []; 

    public function render()
    {
        $query = Diklat::query()
            ->when($this->search, function($q) {
                $q->where('nama_kegiatan', 'like', '%'.$this->search.'%');
            });

        if ($this->filterStatus !== 'all') {
            $query->where('status', $this->filterStatus);
        }

        return view('livewire.kepegawaian.diklat.index', [
            'diklats' => $query->latest('tanggal_mulai')->paginate(10),
            'pegawais' => Pegawai::with('user')->get(), // Untuk selector peserta
        ])->layout('layouts.app', ['header' => 'Manajemen Diklat & Pelatihan']);
    }

    public function create()
    {
        $this->resetForm();
        $this->isFormOpen = true;
        $this->isEditing = false;
    }

    public function edit($id)
    {
        $d = Diklat::with('pesertas')->findOrFail($id);
        $this->diklatId = $id;
        $this->nama_kegiatan = $d->nama_kegiatan;
        $this->jenis_diklat = $d->jenis_diklat;
        $this->penyelenggara = $d->penyelenggara;
        $this->lokasi = $d->lokasi;
        $this->tanggal_mulai = $d->tanggal_mulai->format('Y-m-d');
        $this->tanggal_selesai = $d->tanggal_selesai->format('Y-m-d');
        $this->total_jam_pelajaran = $d->total_jam_pelajaran;
        $this->biaya = $d->biaya;
        $this->status = $d->status;
        $this->keterangan = $d->keterangan;
        
        $this->selectedPegawais = $d->pesertas->pluck('pegawai_id')->toArray();

        $this->isFormOpen = true;
        $this->isEditing = true;
    }

    public function save()
    {
        $this->validate([
            'nama_kegiatan' => 'required',
            'jenis_diklat' => 'required',
            'tanggal_mulai' => 'required|date',
            'tanggal_selesai' => 'required|date|after_or_equal:tanggal_mulai',
        ]);

        $data = [
            'nama_kegiatan' => $this->nama_kegiatan,
            'jenis_diklat' => $this->jenis_diklat,
            'penyelenggara' => $this->penyelenggara,
            'lokasi' => $this->lokasi,
            'tanggal_mulai' => $this->tanggal_mulai,
            'tanggal_selesai' => $this->tanggal_selesai,
            'total_jam_pelajaran' => $this->total_jam_pelajaran ?? 0,
            'biaya' => $this->biaya ?? 0,
            'status' => $this->status,
            'keterangan' => $this->keterangan
        ];

        if ($this->isEditing) {
            $diklat = Diklat::findOrFail($this->diklatId);
            $diklat->update($data);
        } else {
            $diklat = Diklat::create($data);
        }

        // Sync Peserta (Basic implementation: delete all & re-insert)
        // In production, optimize this to avoid id churn
        DiklatPeserta::where('diklat_id', $diklat->id)->delete();
        foreach ($this->selectedPegawais as $pegawaiId) {
            DiklatPeserta::create([
                'diklat_id' => $diklat->id,
                'pegawai_id' => $pegawaiId,
                'status_kelulusan' => 'Peserta'
            ]);
        }

        $this->dispatch('notify', 'success', 'Data diklat berhasil disimpan.');
        $this->cancel();
    }

    public function cancel()
    {
        $this->isFormOpen = false;
        $this->resetForm();
    }

    public function delete($id)
    {
        Diklat::findOrFail($id)->delete();
        $this->dispatch('notify', 'success', 'Diklat dihapus.');
    }

    private function resetForm()
    {
        $this->reset(['nama_kegiatan', 'jenis_diklat', 'penyelenggara', 'lokasi', 'tanggal_mulai', 'tanggal_selesai', 'total_jam_pelajaran', 'biaya', 'status', 'keterangan', 'selectedPegawais']);
    }
}