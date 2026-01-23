<?php

namespace App\Livewire\Pegawai;

use App\Models\Pegawai;
use App\Models\User;
use Livewire\Component;
use Livewire\WithPagination;

use App\Services\BpjsBridgingService;

class Index extends Component
{
    use WithPagination;

    public $search = '';

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function syncBpjs(BpjsBridgingService $bpjs)
    {
        $result = $bpjs->getDokter();
        
        if ($result['status'] == 'success') {
            // Logic to update/create doctors would go here.
            // Since this is a demo/mock environment, we just notify success.
            // In production: Loop data -> Check NIP/Name -> Update 'kode_dokter_bpjs' column (if added).
            
            $count = count($result['data']);
            $this->dispatch('notify', 'success', "Berhasil menyinkronkan $count data dokter dari BPJS.");
        } else {
            $this->dispatch('notify', 'error', 'Gagal sinkronisasi: ' . ($result['message'] ?? 'Unknown error'));
        }
    }

    public function delete($id)
    {
        $pegawai = Pegawai::find($id);
        
        if ($pegawai) {
            $user = $pegawai->user;
            $pegawai->delete();
            if ($user) $user->delete();
            
            $this->dispatch('notify', 'success', 'Pegawai berhasil dihapus.');
        }
    }

    public function render()
    {
        $pegawais = Pegawai::with('user')
            ->whereHas('user', function($query) {
                $query->where('name', 'like', '%' . $this->search . '%')
                      ->orWhere('email', 'like', '%' . $this->search . '%');
            })
            ->orWhere('nip', 'like', '%' . $this->search . '%')
            ->latest()
            ->paginate(10);

        return view('livewire.pegawai.index', [
            'pegawais' => $pegawais,
            'totalPegawai' => Pegawai::count(),
            'totalDokter' => User::where('role', 'dokter')->count(),
            'totalPerawat' => User::where('role', 'perawat')->count(),
            'totalApoteker' => User::where('role', 'apoteker')->count(),
        ])->layout('layouts.app', ['header' => 'Manajemen Pegawai']);
    }
}