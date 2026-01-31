<?php

namespace App\Livewire\Kepegawaian\Aktivitas;

use Livewire\Component;
use Livewire\WithPagination;
use Livewire\WithFileUploads;
use App\Models\LaporanKinerjaHarian;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class Index extends Component
{
    use WithPagination, WithFileUploads;

    public $tanggal;
    public $jam_mulai;
    public $jam_selesai;
    public $aktivitas;
    public $deskripsi;
    public $persentase_selesai = 0;
    public $kendala_teknis;
    public $file_bukti_kerja;
    public $prioritas = 'Normal';
    
    public $isOpen = false;
    public $activityId;

    protected $rules = [
        'tanggal' => 'required|date',
        'jam_mulai' => 'required',
        'jam_selesai' => 'required|after:jam_mulai',
        'aktivitas' => 'required|string|max:255',
        'deskripsi' => 'required|string',
        'persentase_selesai' => 'required|integer|min:0|max:100',
        'kendala_teknis' => 'nullable|string',
        'file_bukti_kerja' => 'nullable|file|mimes:pdf,jpg,png,doc,docx|max:5120',
        'prioritas' => 'required|in:Low,Normal,High,Urgent',
    ];

    public function mount()
    {
        $this->tanggal = Carbon::today()->format('Y-m-d');
        $this->jam_mulai = Carbon::now()->format('H:i');
        $this->jam_selesai = Carbon::now()->addHour()->format('H:i');
    }

    public function create()
    {
        $this->resetInputFields();
        $this->isOpen = true;
    }

    private function resetInputFields()
    {
        $this->tanggal = Carbon::today()->format('Y-m-d');
        $this->jam_mulai = Carbon::now()->format('H:i');
        $this->jam_selesai = Carbon::now()->addHour()->format('H:i');
        $this->aktivitas = '';
        $this->deskripsi = '';
        $this->persentase_selesai = 0;
        $this->kendala_teknis = '';
        $this->file_bukti_kerja = null;
        $this->prioritas = 'Normal';
        $this->activityId = null;
    }

    public function edit($id)
    {
        $lkh = LaporanKinerjaHarian::where('user_id', Auth::id())->findOrFail($id);
        
        $this->activityId = $id;
        $this->tanggal = $lkh->tanggal;
        $this->jam_mulai = Carbon::parse($lkh->jam_mulai)->format('H:i');
        $this->jam_selesai = Carbon::parse($lkh->jam_selesai)->format('H:i');
        $this->aktivitas = $lkh->aktivitas;
        $this->deskripsi = $lkh->deskripsi;
        $this->persentase_selesai = $lkh->persentase_selesai;
        $this->kendala_teknis = $lkh->kendala_teknis;
        $this->prioritas = $lkh->prioritas;
        $this->isOpen = true;
    }

    public function save()
    {
        $this->validate();

        $path = null;
        if ($this->file_bukti_kerja) {
            $path = $this->file_bukti_kerja->store('bukti-kerja', 'public');
        }

        $data = [
            'user_id' => Auth::id(),
            'tanggal' => $this->tanggal,
            'jam_mulai' => $this->jam_mulai,
            'jam_selesai' => $this->jam_selesai,
            'aktivitas' => $this->aktivitas,
            'deskripsi' => $this->deskripsi,
            'persentase_selesai' => $this->persentase_selesai,
            'kendala_teknis' => $this->kendala_teknis,
            'prioritas' => $this->prioritas,
            'status' => 'Pending', // Reset status if edited
        ];

        if ($path) {
            $data['file_bukti_kerja'] = $path;
        }

        LaporanKinerjaHarian::updateOrCreate(['id' => $this->activityId], $data);

        $this->dispatch('notify', 'success', $this->activityId ? 'Laporan diperbarui.' : 'Laporan kinerja berhasil disimpan.');
        $this->isOpen = false;
        $this->resetInputFields();
    }

    public function delete($id)
    {
        LaporanKinerjaHarian::where('user_id', Auth::id())->find($id)->delete();
        $this->dispatch('notify', 'success', 'Laporan dihapus.');
    }

    public function render()
    {
        $laporans = LaporanKinerjaHarian::where('user_id', Auth::id())
            ->orderByDesc('tanggal')
            ->orderByDesc('jam_mulai')
            ->paginate(10);

        return view('livewire.kepegawaian.aktivitas.index', [
            'laporans' => $laporans
        ])->layout('layouts.app', ['header' => 'Laporan Kinerja Harian (LKH)']);
    }
}