<?php

namespace App\Livewire\Kepegawaian\Gaji;

use App\Models\Penggajian;
use App\Models\User;
use App\Services\PayrollService;
use Livewire\Component;
use Carbon\Carbon;

class Create extends Component
{
    public $bulan;
    public $tahun;
    
    // Form fields
    public $user_id;
    public $gaji_pokok = 0;
    
    // Detail Tunjangan
    public $tunjangan_jabatan = 0;
    public $tunjangan_fungsional = 0;
    public $tunjangan_umum = 0;
    public $tunjangan_makan = 0;
    public $tunjangan_transport = 0;
    
    // Detail Potongan
    public $potongan_bpjs_kesehatan = 0;
    public $potongan_bpjs_tk = 0;
    public $potongan_pph21 = 0;
    public $potongan_absen = 0;

    public $catatan;

    // Totals
    public $total_tunjangan = 0;
    public $total_potongan = 0;
    public $take_home_pay = 0;

    protected $rules = [
        'user_id' => 'required|exists:users,id',
        'bulan' => 'required',
        'tahun' => 'required|numeric',
        'gaji_pokok' => 'required|numeric|min:0',
    ];

    public function mount()
    {
        $this->bulan = Carbon::now()->translatedFormat('F');
        $this->tahun = date('Y');
    }

    public function updatedUserId($value)
    {
        if (!$value) return;

        $user = User::find($value);
        if ($user) {
            $payrollService = new PayrollService();
            $calculation = $payrollService->calculatePayroll($user, $this->bulan, $this->tahun);

            $this->gaji_pokok = $calculation['gaji_pokok'];
            
            $this->tunjangan_jabatan = $calculation['tunjangan']['jabatan'];
            $this->tunjangan_fungsional = $calculation['tunjangan']['fungsional'];
            $this->tunjangan_umum = $calculation['tunjangan']['umum'];
            $this->tunjangan_makan = $calculation['tunjangan']['makan'];
            $this->tunjangan_transport = $calculation['tunjangan']['transport'];

            $this->potongan_bpjs_kesehatan = $calculation['potongan']['bpjs_kesehatan'];
            $this->potongan_bpjs_tk = $calculation['potongan']['bpjs_tk'];
            $this->potongan_pph21 = $calculation['potongan']['pph21'];
            $this->potongan_absen = $calculation['potongan']['absen'];

            $this->calculateTotals();
        }
    }

    public function updated($propertyName)
    {
        if (in_array($propertyName, [
            'gaji_pokok', 
            'tunjangan_jabatan', 'tunjangan_fungsional', 'tunjangan_umum', 'tunjangan_makan', 'tunjangan_transport',
            'potongan_bpjs_kesehatan', 'potongan_bpjs_tk', 'potongan_pph21', 'potongan_absen'
        ])) {
            $this->calculateTotals();
        }
    }

    public function calculateTotals()
    {
        $this->total_tunjangan = (int)$this->tunjangan_jabatan + (int)$this->tunjangan_fungsional + (int)$this->tunjangan_umum + (int)$this->tunjangan_makan + (int)$this->tunjangan_transport;
        
        $this->total_potongan = (int)$this->potongan_bpjs_kesehatan + (int)$this->potongan_bpjs_tk + (int)$this->potongan_pph21 + (int)$this->potongan_absen;

        $this->take_home_pay = (int)$this->gaji_pokok + $this->total_tunjangan - $this->total_potongan;
    }

    public function save()
    {
        $this->validate();
        $this->calculateTotals();

        Penggajian::create([
            'user_id' => $this->user_id,
            'bulan' => $this->bulan,
            'tahun' => $this->tahun,
            'gaji_pokok' => $this->gaji_pokok,
            
            'tunjangan_jabatan' => $this->tunjangan_jabatan,
            'tunjangan_fungsional' => $this->tunjangan_fungsional,
            'tunjangan_umum' => $this->tunjangan_umum,
            'tunjangan_makan' => $this->tunjangan_makan,
            'tunjangan_transport' => $this->tunjangan_transport,
            'tunjangan' => $this->total_tunjangan,

            'potongan_bpjs_kesehatan' => $this->potongan_bpjs_kesehatan,
            'potongan_bpjs_tk' => $this->potongan_bpjs_tk,
            'potongan_pph21' => $this->potongan_pph21,
            'potongan_absen' => $this->potongan_absen,
            'potongan' => $this->total_potongan,

            'total_gaji' => $this->take_home_pay,
            'status' => 'Paid',
            'catatan' => $this->catatan,
        ]);

        $this->dispatch('notify', 'success', 'Proses penggajian berhasil disimpan.');
        return $this->redirect(route('kepegawaian.gaji.index'), navigate: true);
    }

    public function render()
    {
        $users = User::orderBy('name')->get();
        return view('livewire.kepegawaian.gaji.create', [
            'users' => $users
        ])->layout('layouts.app', ['header' => 'Input Gaji Pegawai']);
    }
}
