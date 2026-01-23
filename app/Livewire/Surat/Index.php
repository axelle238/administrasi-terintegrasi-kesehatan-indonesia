<?php

namespace App\Livewire\Surat;

use App\Models\Surat;
use Livewire\Component;
use Livewire\WithPagination;

class Index extends Component
{
    use WithPagination;

    public $search = '';
    public $jenisFilter = '';

    public function delete($id)
    {
        $surat = Surat::find($id);
        if ($surat) {
            $surat->delete();
            $this->dispatch('notify', 'success', 'Surat berhasil dihapus.');
        }
    }

    public function render()
    {
        $surats = Surat::where(function($q) {
                $q->where('nomor_surat', 'like', '%' . $this->search . '%')
                  ->orWhere('perihal', 'like', '%' . $this->search . '%')
                  ->orWhere('pengirim', 'like', '%' . $this->search . '%');
            })
            ->when($this->jenisFilter, function($q) {
                $q->where('jenis_surat', $this->jenisFilter);
            })
            ->latest('tanggal_surat')
            ->paginate(10);

        return view('livewire.surat.index', [
            'surats' => $surats
        ])->layout('layouts.app', ['header' => 'Arsip Surat Menyurat']);
    }
}