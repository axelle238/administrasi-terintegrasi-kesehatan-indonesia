<?php

namespace App\Livewire\Kepegawaian\Gaji;

use App\Models\Penggajian;
use Livewire\Component;
use Livewire\WithPagination;

class Index extends Component
{
    use WithPagination;

    public $search = '';

    public function delete($id)
    {
        $gaji = Penggajian::find($id);
        if ($gaji) {
            $gaji->delete();
            $this->dispatch('notify', 'success', 'Data gaji berhasil dihapus.');
        }
    }

    public function render()
    {
        $gajis = Penggajian::with('user')
            ->whereHas('user', function($q) {
                $q->where('name', 'like', '%' . $this->search . '%');
            })
            ->latest()
            ->paginate(10);

        return view('livewire.kepegawaian.gaji.index', [
            'gajis' => $gajis
        ])->layout('layouts.app', ['header' => 'Daftar Penggajian Pegawai']);
    }
}
