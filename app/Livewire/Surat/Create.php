<?php

namespace App\Livewire\Surat;

use App\Models\Surat;
use Livewire\Component;
use Livewire\WithFileUploads;

class Create extends Component
{
    use WithFileUploads;

    public $nomor_surat;
    public $tanggal_surat;
    public $tanggal_diterima;
    public $pengirim;
    public $penerima;
    public $perihal;
    public $jenis_surat = 'Masuk';
    public $file_surat;
    
    // Disposisi
    public $disposisi;
    public $tujuan_disposisi;
    public $status_disposisi = 'Pending';

    protected $rules = [
        'nomor_surat' => 'required|string|max:255',
        'tanggal_surat' => 'required|date',
        'perihal' => 'required|string',
        'jenis_surat' => 'required|in:Masuk,Keluar',
        'file_surat' => 'nullable|file|max:10240', // 10MB
    ];

    public function mount()
    {
        $this->generateNumber();
        $this->tanggal_surat = date('Y-m-d');
        if ($this->jenis_surat == 'Masuk') {
            $this->tanggal_diterima = date('Y-m-d');
        }
    }

    public function updatedJenisSurat()
    {
        $this->generateNumber();
        if ($this->jenis_surat == 'Masuk') {
            $this->penerima = 'Kepala Puskesmas';
        } else {
            $this->pengirim = 'Kepala Puskesmas';
        }
    }

    public function generateNumber()
    {
        $year = date('Y');
        $month = date('n');
        $romawi = $this->toRoman($month);
        
        $count = Surat::whereYear('created_at', $year)
            ->where('jenis_surat', $this->jenis_surat)
            ->count() + 1;
            
        $code = $this->jenis_surat == 'Keluar' ? 'PKM-JGK' : 'IN';
        
        $this->nomor_surat = sprintf("%03d/%s/%s/%s", $count, $code, $romawi, $year);
    }

    private function toRoman($number) {
        $map = array('M' => 1000, 'CM' => 900, 'D' => 500, 'CD' => 400, 'C' => 100, 'XC' => 90, 'L' => 50, 'XL' => 40, 'X' => 10, 'IX' => 9, 'V' => 5, 'IV' => 4, 'I' => 1);
        $returnValue = '';
        while ($number > 0) {
            foreach ($map as $roman => $int) {
                if ($number >= $int) {
                    $number -= $int;
                    $returnValue .= $roman;
                    break;
                }
            }
        }
        return $returnValue;
    }

    public function save()
    {
        $this->validate();

        $path = null;
        if ($this->file_surat) {
            $path = $this->file_surat->store('surat', 'public');
        }

        Surat::create([
            'nomor_surat' => $this->nomor_surat,
            'tanggal_surat' => $this->tanggal_surat,
            'tanggal_diterima' => $this->jenis_surat == 'Masuk' ? ($this->tanggal_diterima ?? now()) : null,
            'pengirim' => $this->pengirim,
            'penerima' => $this->penerima,
            'perihal' => $this->perihal,
            'jenis_surat' => $this->jenis_surat,
            'file_path' => $path,
            'disposisi' => $this->disposisi,
            'tujuan_disposisi' => $this->tujuan_disposisi,
            'status_disposisi' => $this->status_disposisi,
        ]);

        $this->dispatch('notify', 'success', 'Surat berhasil diarsipkan.');
        return $this->redirect(route('surat.index'), navigate: true);
    }

    public function render()
    {
        return view('livewire.surat.create')->layout('layouts.app', ['header' => 'Arsip Surat Baru']);
    }
}