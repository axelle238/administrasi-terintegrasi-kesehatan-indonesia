<?php

namespace App\Livewire\Barang;

use App\Models\Barang;
use App\Models\RiwayatBarang;
use App\Models\Maintenance;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Livewire\WithPagination;

class Show extends Component
{
    use WithPagination;

    public Barang $barang;
    
    // Transaction Form
    public $jenis_transaksi = 'Masuk';
    public $jumlah;
    public $keterangan;
    public $tanggal_transaksi;

    // Maintenance Form
    public $showMaintenanceModal = false;
    public $m_tanggal;
    public $m_kegiatan = 'Pemeliharaan Rutin';
    public $m_teknisi;
    public $m_biaya = 0;
    public $m_keterangan;
    public $m_tanggal_berikutnya;

    protected $rules = [
        'jenis_transaksi' => 'required|in:Masuk,Keluar',
        'jumlah' => 'required|integer|min:1',
        'keterangan' => 'nullable|string',
        'tanggal_transaksi' => 'required|date'
    ];

    public function mount(Barang $barang)
    {
        $this->barang = $barang;
        $this->tanggal_transaksi = now()->format('Y-m-d');
        $this->m_tanggal = now()->format('Y-m-d');
        
        // Calculate Nilai Buku (Depreciation) - Simple Straight Line
        if ($this->barang->is_asset && $this->barang->masa_manfaat > 0) {
            $age = now()->diffInYears($this->barang->tanggal_pengadaan);
            if ($age < $this->barang->masa_manfaat) {
                $depreciationPerYear = ($this->barang->harga_perolehan - $this->barang->nilai_residu) / $this->barang->masa_manfaat;
                $currentValue = $this->barang->harga_perolehan - ($depreciationPerYear * $age);
                $this->barang->nilai_buku = max($currentValue, $this->barang->nilai_residu);
            } else {
                $this->barang->nilai_buku = $this->barang->nilai_residu;
            }
        }
    }

    public function saveTransaksi()
    {
        $this->validate();

        if ($this->jenis_transaksi == 'Keluar' && $this->barang->stok < $this->jumlah) {
            $this->addError('jumlah', 'Stok tidak mencukupi untuk transaksi keluar.');
            return;
        }

        try {
            DB::beginTransaction();

            $stokBaru = $this->jenis_transaksi == 'Masuk' 
                ? $this->barang->stok + $this->jumlah 
                : $this->barang->stok - $this->jumlah;

            $this->barang->update(['stok' => $stokBaru]);

            RiwayatBarang::create([
                'barang_id' => $this->barang->id,
                'user_id' => auth()->id(),
                'jenis_transaksi' => $this->jenis_transaksi,
                'jumlah' => $this->jumlah,
                'stok_terakhir' => $stokBaru,
                'tanggal' => $this->tanggal_transaksi,
                'keterangan' => $this->keterangan
            ]);

            DB::commit();

            $this->reset(['jumlah', 'keterangan']);
            $this->tanggal_transaksi = now()->format('Y-m-d');
            $this->jenis_transaksi = 'Masuk';
            
            $this->dispatch('notify', 'success', 'Transaksi berhasil dicatat.');

        } catch (\Exception $e) {
            DB::rollback();
            $this->dispatch('notify', 'error', 'Gagal mencatat transaksi: ' . $e->getMessage());
        }
    }

    public function openMaintenanceModal()
    {
        $this->reset(['m_teknisi', 'm_biaya', 'm_keterangan', 'm_tanggal_berikutnya']);
        $this->m_tanggal = now()->format('Y-m-d');
        $this->m_kegiatan = 'Pemeliharaan Rutin';
        $this->showMaintenanceModal = true;
    }

    public function saveMaintenance()
    {
        $this->validate([
            'm_tanggal' => 'required|date',
            'm_kegiatan' => 'required|string',
            'm_biaya' => 'numeric|min:0',
        ]);

        Maintenance::create([
            'barang_id' => $this->barang->id,
            'tanggal_maintenance' => $this->m_tanggal,
            'jenis_kegiatan' => $this->m_kegiatan,
            'keterangan' => $this->m_keterangan,
            'teknisi' => $this->m_teknisi,
            'biaya' => $this->m_biaya,
            'tanggal_berikutnya' => $this->m_tanggal_berikutnya
        ]);

        $this->showMaintenanceModal = false;
        $this->dispatch('notify', 'success', 'Data pemeliharaan berhasil ditambahkan.');
    }

    public function render()
    {
        $riwayats = RiwayatBarang::where('barang_id', $this->barang->id)
            ->with('user')
            ->latest()
            ->paginate(5);

        $maintenances = Maintenance::where('barang_id', $this->barang->id)
            ->latest('tanggal_maintenance')
            ->get();

        return view('livewire.barang.show', [
            'riwayats' => $riwayats,
            'maintenances' => $maintenances
        ])->layout('layouts.app', ['header' => 'Detail Aset: ' . $this->barang->nama_barang]);
    }
}