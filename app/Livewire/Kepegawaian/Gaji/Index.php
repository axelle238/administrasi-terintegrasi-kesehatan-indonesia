<?php

namespace App\Livewire\Kepegawaian\Gaji;

use App\Models\Penggajian;
use App\Models\User;
use App\Services\PayrollService;
use Livewire\Component;
use Livewire\WithPagination;
use Carbon\Carbon;

class Index extends Component
{
    use WithPagination;

    public $bulan;
    public $tahun;
    
    public $isOpen = false;
    
    // Form fields
    public $user_id;
    public $gaji_pokok;
    public $tunjangan = 0;
    public $potongan = 0;

    protected $rules = [
        'user_id' => 'required|exists:users,id',
        'bulan' => 'required',
        'tahun' => 'required|numeric',
        'gaji_pokok' => 'required|numeric',
        'tunjangan' => 'nullable|numeric',
        'potongan' => 'nullable|numeric',
    ];

    public function mount()
    {
        $this->bulan = Carbon::now()->translatedFormat('F');
        $this->tahun = date('Y');
    }

    public function create()
    {
        $this->reset(['user_id', 'gaji_pokok', 'tunjangan', 'potongan']);
        $this->isOpen = true;
    }

    public function updatedUserId($value)
    {
        if (!$value) return;

        // 1. Set Default Gaji (Simulation)
        $this->gaji_pokok = 5000000; 

        // 2. Auto Calculate Deductions based on Attendance
        $payrollService = new PayrollService();
        $this->potongan = $payrollService->calculateDeductions($value, $this->bulan, $this->tahun);
    }

    public function save()
    {
        $this->validate();

        $total = $this->gaji_pokok + $this->tunjangan - $this->potongan;

        Penggajian::create([
            'user_id' => $this->user_id,
            'bulan' => $this->bulan,
            'tahun' => $this->tahun,
            'gaji_pokok' => $this->gaji_pokok,
            'tunjangan' => $this->tunjangan ?? 0,
            'potongan' => $this->potongan ?? 0,
            'total_gaji' => $total,
            'status' => 'Paid',
        ]);

        $this->dispatch('notify', 'success', 'Gaji berhasil dicatat.');
        $this->isOpen = false;
    }

    public function delete($id)
    {
        Penggajian::find($id)->delete();
        $this->dispatch('notify', 'success', 'Data gaji dihapus.');
    }

    public function render()
    {
        $gajis = Penggajian::with('user')
            ->latest()
            ->paginate(10);

        $users = User::orderBy('name')->get();

        return view('livewire.kepegawaian.gaji.index', [
            'gajis' => $gajis,
            'users' => $users
        ])->layout('layouts.app', ['header' => 'Penggajian Pegawai']);
    }
}
