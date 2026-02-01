<?php

namespace App\Livewire\Kepegawaian\Kredensial;

use Livewire\Component;
use Livewire\WithPagination;
use Livewire\WithFileUploads;
use App\Models\Kredensial;
use App\Models\Pegawai;
use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;

class Index extends Component
{
    use WithPagination;
    use WithFileUploads;

    public $filterStatus = 'all'; // all, expired, warning, active
    public $search = '';
    
    // Form States
    public $isCreating = false;
    public $isEditing = false;
    public $selectedId;

    // Form Fields
    public $pegawai_id;
    public $jenis_dokumen;
    public $nomor_dokumen;
    public $tanggal_terbit;
    public $tanggal_berakhir;
    public $penerbit;
    public $file_dokumen;

    public function render()
    {
        $query = Kredensial::with('pegawai.user')
            ->when($this->search, function($q) {
                $q->where('nomor_dokumen', 'like', '%'.$this->search.'%')
                  ->orWhereHas('pegawai.user', function($sq) {
                      $sq->where('name', 'like', '%'.$this->search.'%');
                  });
            });

        if ($this->filterStatus === 'expired') {
            $query->whereDate('tanggal_berakhir', '<', Carbon::today());
        } elseif ($this->filterStatus === 'warning') {
            $query->whereDate('tanggal_berakhir', '>=', Carbon::today())
                  ->whereDate('tanggal_berakhir', '<=', Carbon::today()->addMonths(3));
        } elseif ($this->filterStatus === 'active') {
            $query->whereDate('tanggal_berakhir', '>', Carbon::today()->addMonths(3));
        }

        return view('livewire.kepegawaian.kredensial.index', [
            'kredensials' => $query->orderBy('tanggal_berakhir', 'asc')->paginate(10),
            'pegawais' => Pegawai::with('user')->get(),
            'countExpired' => Kredensial::whereDate('tanggal_berakhir', '<', Carbon::today())->count(),
            'countWarning' => Kredensial::whereDate('tanggal_berakhir', '>=', Carbon::today())
                                ->whereDate('tanggal_berakhir', '<=', Carbon::today()->addMonths(3))->count(),
        ])->layout('layouts.app', ['header' => 'Monitoring Kredensial (STR/SIP)']);
    }

    public function create()
    {
        $this->resetForm();
        $this->isCreating = true;
        $this->isEditing = false;
    }

    public function edit($id)
    {
        $k = Kredensial::findOrFail($id);
        $this->selectedId = $id;
        $this->pegawai_id = $k->pegawai_id;
        $this->jenis_dokumen = $k->jenis_dokumen;
        $this->nomor_dokumen = $k->nomor_dokumen;
        $this->tanggal_terbit = $k->tanggal_terbit->format('Y-m-d');
        $this->tanggal_berakhir = $k->tanggal_berakhir->format('Y-m-d');
        $this->penerbit = $k->penerbit;
        
        $this->isCreating = false;
        $this->isEditing = true;
    }

    public function save()
    {
        $this->validate([
            'pegawai_id' => 'required',
            'jenis_dokumen' => 'required',
            'nomor_dokumen' => 'required',
            'tanggal_terbit' => 'required|date',
            'tanggal_berakhir' => 'required|date|after:tanggal_terbit',
            'file_dokumen' => 'nullable|file|max:2048|mimes:pdf,jpg,jpeg,png'
        ]);

        $data = [
            'pegawai_id' => $this->pegawai_id,
            'jenis_dokumen' => $this->jenis_dokumen,
            'nomor_dokumen' => $this->nomor_dokumen,
            'tanggal_terbit' => $this->tanggal_terbit,
            'tanggal_berakhir' => $this->tanggal_berakhir,
            'penerbit' => $this->penerbit,
        ];

        if ($this->file_dokumen) {
            $data['file_dokumen'] = $this->file_dokumen->store('kredensials', 'public');
        }

        if ($this->isEditing) {
            $k = Kredensial::findOrFail($this->selectedId);
            $k->update($data);
            $this->dispatch('notify', 'success', 'Dokumen berhasil diperbarui.');
        } else {
            Kredensial::create($data);
            $this->dispatch('notify', 'success', 'Dokumen baru berhasil ditambahkan.');
        }

        $this->cancel();
    }

    public function delete($id)
    {
        $k = Kredensial::findOrFail($id);
        if ($k->file_dokumen) {
            Storage::disk('public')->delete($k->file_dokumen);
        }
        $k->delete();
        $this->dispatch('notify', 'success', 'Dokumen dihapus.');
    }

    public function cancel()
    {
        $this->isCreating = false;
        $this->isEditing = false;
        $this->resetForm();
    }

    private function resetForm()
    {
        $this->reset(['pegawai_id', 'jenis_dokumen', 'nomor_dokumen', 'tanggal_terbit', 'tanggal_berakhir', 'penerbit', 'file_dokumen']);
    }
}