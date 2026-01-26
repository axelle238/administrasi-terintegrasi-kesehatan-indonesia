<?php

namespace App\Livewire\Pegawai;

use App\Models\Pegawai;
use App\Models\User;
use App\Services\BpjsBridgingService;
use Livewire\Component;
use Livewire\WithPagination;
use Carbon\Carbon;

class Index extends Component
{
    use WithPagination;

    public $search = '';
    public $filterRole = ''; // all, dokter, perawat, apoteker, staf
    public $filterStatus = ''; // ews_str, ews_sip (filter by expired warning)

    // Modal Detail
    public $detailOpen = false;
    public $selectedPegawai;

    protected $queryString = [
        'search' => ['except' => ''],
        'filterRole' => ['except' => ''],
        'filterStatus' => ['except' => '']
    ];

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function updatingFilterRole()
    {
        $this->resetPage();
    }

    public function syncBpjs(BpjsBridgingService $bpjs)
    {
        // Mock Sync
        $this->dispatch('notify', 'success', 'Sinkronisasi data dokter BPJS berhasil.');
    }

    public function showDetail($id)
    {
        $this->selectedPegawai = Pegawai::with('user', 'poli')->find($id);
        $this->detailOpen = true;
    }

    public function closeDetail()
    {
        $this->detailOpen = false;
        $this->selectedPegawai = null;
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
        $query = Pegawai::with('user');

        // Search
        if ($this->search) {
            $query->where(function($q) {
                $q->whereHas('user', function($u) {
                    $u->where('name', 'like', '%' . $this->search . '%')
                      ->orWhere('email', 'like', '%' . $this->search . '%');
                })
                ->orWhere('nip', 'like', '%' . $this->search . '%');
            });
        }

        // Filter Role
        if ($this->filterRole) {
            $query->whereHas('user', function($u) {
                $u->where('role', $this->filterRole);
            });
        }

        // Filter EWS (Early Warning System)
        if ($this->filterStatus) {
            $threshold = Carbon::now()->addMonths(3);
            
            if ($this->filterStatus == 'ews_str') {
                $query->where('masa_berlaku_str', '<=', $threshold);
            } elseif ($this->filterStatus == 'ews_sip') {
                $query->where('masa_berlaku_sip', '<=', $threshold);
            }
        }

        $pegawais = $query->latest()->paginate(10);

        // Stats Counters
        $totalPegawai = Pegawai::count();
        $totalDokter = User::where('role', 'dokter')->count();
        $totalPerawat = User::where('role', 'perawat')->count();
        $totalApoteker = User::where('role', 'apoteker')->count();
        
        // EWS Counters
        $ewsStr = Pegawai::where('masa_berlaku_str', '<=', Carbon::now()->addMonths(3))->count();
        $ewsSip = Pegawai::where('masa_berlaku_sip', '<=', Carbon::now()->addMonths(3))->count();

        return view('livewire.pegawai.index', [
            'pegawais' => $pegawais,
            'totalPegawai' => $totalPegawai,
            'totalDokter' => $totalDokter,
            'totalPerawat' => $totalPerawat,
            'totalApoteker' => $totalApoteker,
            'ewsStr' => $ewsStr,
            'ewsSip' => $ewsSip
        ])->layout('layouts.app', ['header' => 'Manajemen Pegawai & SDM']);
    }
}
