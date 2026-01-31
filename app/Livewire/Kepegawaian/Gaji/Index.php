<?php

namespace App\Livewire\Kepegawaian\Gaji;

use App\Models\Penggajian;
use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Support\Facades\Auth;

class Index extends Component
{
    use WithPagination;

    public $search = '';

    public function delete($id)
    {
        if (Auth::user()->role !== 'admin') {
            $this->dispatch('notify', 'error', 'Akses ditolak.');
            return;
        }
        $gaji = Penggajian::find($id);
        if ($gaji) {
            $gaji->delete();
            $this->dispatch('notify', 'success', 'Data gaji berhasil dihapus.');
        }
    }

    public function downloadSlip($id)
    {
        $gaji = Penggajian::find($id);
        
        // Security Check
        if (Auth::user()->role !== 'admin' && $gaji->user_id !== Auth::id()) {
            $this->dispatch('notify', 'error', 'Anda tidak berhak mengakses slip gaji ini.');
            return;
        }

        // Redirect to print route (Create a simple print route/controller later or simulate here)
        // For simplicity in Livewire without extra controller, we can use a browser event to open a new tab
        $this->dispatch('open-slip', url: route('kepegawaian.gaji.print', $id));
    }

    public function render()
    {
        $query = Penggajian::with('user');

        // Filter Access
        if (Auth::user()->role !== 'admin' && !Auth::user()->can('hrd')) {
            $query->where('user_id', Auth::id());
        }

        $gajis = $query->whereHas('user', function($q) {
                $q->where('name', 'like', '%' . $this->search . '%');
            })
            ->latest()
            ->paginate(10);

        return view('livewire.kepegawaian.gaji.index', [
            'gajis' => $gajis
        ])->layout('layouts.app', ['header' => 'Daftar Penggajian & Slip Gaji']);
    }
}
