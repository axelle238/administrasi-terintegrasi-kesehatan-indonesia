<?php

namespace App\Livewire\Survey;

use App\Models\Poli;
use App\Models\Survey;
use Livewire\Component;

class Create extends Component
{
    public $poli_id;
    public $step = 1;
    
    // Profil Responden
    public $umur;
    public $jenis_kelamin;
    public $pendidikan;
    public $pekerjaan;

    // 9 Unsur (Nilai 1-4)
    public $u1_persyaratan;
    public $u2_prosedur;
    public $u3_waktu;
    public $u4_biaya;
    public $u5_produk;
    public $u6_kompetensi;
    public $u7_perilaku;
    public $u8_maklumat;
    public $u9_penanganan;

    public $kritik_saran;
    public $isSubmitted = false;

    public function updated($propertyName)
    {
        $this->validateOnly($propertyName, $this->rules());
    }

    protected function rules()
    {
        return [
            // Step 1
            'poli_id' => 'required|exists:polis,id',
            'umur' => 'required|numeric|min:15|max:100',
            'jenis_kelamin' => 'required|in:Laki-laki,Perempuan',
            'pendidikan' => 'required|string',
            'pekerjaan' => 'required|string',
            
            // Step 2 (Validation applied on submit)
            'u1_persyaratan' => 'required|integer|min:1|max:4',
            'u2_prosedur' => 'required|integer|min:1|max:4',
            'u3_waktu' => 'required|integer|min:1|max:4',
            'u4_biaya' => 'required|integer|min:1|max:4',
            'u5_produk' => 'required|integer|min:1|max:4',
            'u6_kompetensi' => 'required|integer|min:1|max:4',
            'u7_perilaku' => 'required|integer|min:1|max:4',
            'u8_maklumat' => 'required|integer|min:1|max:4',
            'u9_penanganan' => 'required|integer|min:1|max:4',
            
            'kritik_saran' => 'nullable|string|max:1000',
        ];
    }

    public function nextStep()
    {
        $this->validate([
            'poli_id' => 'required',
            'umur' => 'required',
            'jenis_kelamin' => 'required',
            'pendidikan' => 'required',
            'pekerjaan' => 'required',
        ]);
        
        $this->step = 2;
    }

    public function prevStep()
    {
        $this->step = 1;
    }

    public function save()
    {
        $this->validate();

        // Calculate Average for legacy 'nilai' column (scale 1-4 to 1-5 approx or just keep 1-4)
        // Let's normalize 1-4 to 1-5 for compatibility if needed, or just store average raw.
        // Formula SKM: Sum / 9 * 25 (Scale 100). For 1-5 scale: avg * 1.25
        $avg = ($this->u1_persyaratan + $this->u2_prosedur + $this->u3_waktu + $this->u4_biaya + $this->u5_produk + $this->u6_kompetensi + $this->u7_perilaku + $this->u8_maklumat + $this->u9_penanganan) / 9;
        
        // Simpan
        Survey::create([
            'poli_id' => $this->poli_id,
            'nilai' => round($avg), // Rounded for legacy column
            'kritik_saran' => $this->kritik_saran,
            'ip_address' => request()->ip(),
            
            'u1_persyaratan' => $this->u1_persyaratan,
            'u2_prosedur' => $this->u2_prosedur,
            'u3_waktu' => $this->u3_waktu,
            'u4_biaya' => $this->u4_biaya,
            'u5_produk' => $this->u5_produk,
            'u6_kompetensi' => $this->u6_kompetensi,
            'u7_perilaku' => $this->u7_perilaku,
            'u8_maklumat' => $this->u8_maklumat,
            'u9_penanganan' => $this->u9_penanganan,

            'umur' => $this->umur,
            'jenis_kelamin' => $this->jenis_kelamin,
            'pendidikan' => $this->pendidikan,
            'pekerjaan' => $this->pekerjaan,
        ]);

        $this->isSubmitted = true;
    }

    public function render()
    {
        return view('livewire.survey.create', [
            'polis' => Poli::all()
        ])->layout('layouts.guest');
    }
}