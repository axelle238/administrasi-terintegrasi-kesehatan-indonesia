<?php

namespace App\Livewire\Pegawai\Tabs;

use Livewire\Component;
use App\Models\Pegawai;
use App\Models\RiwayatJabatan;
use Illuminate\Support\Facades\DB;

class Riwayat extends Component
{
    public $pegawai;
    
    // Form Input
    public $jabatan_baru;
    public $unit_kerja_baru;
    public $jenis_perubahan = 'Mutasi';
    public $tanggal_mulai;
    public $nomor_sk;

    public function mount(Pegawai $pegawai)
    {
        $this->pegawai = $pegawai;
    }

    public function rules()
    {
        return [
            'jabatan_baru' => 'required|string',
            'unit_kerja_baru' => 'required|string',
            'jenis_perubahan' => 'required|in:Promosi,Mutasi,Demosi,Perekrutan',
            'tanggal_mulai' => 'required|date',
            'nomor_sk' => 'nullable|string',
        ];
    }

    public function save()
    {
        $this->validate();

        DB::transaction(function () {
            // 1. Simpan Riwayat
            RiwayatJabatan::create([
                'pegawai_id' => $this->pegawai->id,
                'jabatan_baru' => $this->jabatan_baru,
                'unit_kerja_baru' => $this->unit_kerja_baru,
                'jenis_perubahan' => $this->jenis_perubahan,
                'tanggal_mulai' => $this->tanggal_mulai,
                'nomor_sk' => $this->nomor_sk,
            ]);

            // 2. Update Data Pegawai Utama (Sync)
            $this->pegawai->update([
                'jabatan' => $this->jabatan_baru,
                // Unit kerja (Poli) bisa diupdate manual jika perlu, atau tambah logika di sini
            ]);
        });

        $this->reset(['jabatan_baru', 'unit_kerja_baru', 'nomor_sk', 'tanggal_mulai']);
        session()->flash('message', 'Riwayat jabatan berhasil ditambahkan.');
    }

    public function delete($id)
    {
        RiwayatJabatan::find($id)->delete();
        session()->flash('message', 'Riwayat berhasil dihapus.');
    }

    public function render()
    {
        $riwayat = RiwayatJabatan::where('pegawai_id', $this->pegawai->id)
            ->orderBy('tanggal_mulai', 'desc')
            ->get();

        return view('livewire.pegawai.tabs.riwayat', [
            'riwayat' => $riwayat
        ]);
    }
}