<?php

namespace App\Livewire\Pasien;

use App\Models\Pasien;
use Livewire\Component;
use Livewire\WithPagination;

class Index extends Component
{
    use WithPagination;

    public $search = '';

    public function delete($id)
    {
        $pasien = Pasien::find($id);
        if ($pasien) {
            // Check relations
            if ($pasien->rekamMedis()->exists()) {
                 $this->dispatch('notify', 'error', 'Tidak dapat menghapus: Pasien memiliki riwayat rekam medis.');
                 return;
            }
            
            $pasien->delete();
            $this->dispatch('notify', 'success', 'Data pasien berhasil dihapus.');
        }
    }

    public function render()
    {
        $pasiens = Pasien::where('nama_lengkap', 'like', '%' . $this->search . '%')
            ->orWhere('nik', 'like', '%' . $this->search . '%')
            ->orWhere('no_bpjs', 'like', '%' . $this->search . '%')
            ->latest()
            ->paginate(10);

        return view('livewire.pasien.index', [
            'pasiens' => $pasiens
        ])->layout('layouts.app', ['header' => 'Manajemen Data Pasien']);
    }
}