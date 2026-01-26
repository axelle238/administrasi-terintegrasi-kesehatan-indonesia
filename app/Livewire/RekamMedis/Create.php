<?php

namespace App\Livewire\RekamMedis;

use App\Models\Antrean;
use App\Models\Obat;
use App\Models\Pasien;
use App\Models\RekamMedis;
use App\Models\Tindakan;
use App\Models\Icd10;
use App\Models\RekamMedisFile;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class Create extends Component
{
    use WithFileUploads;

    public $antrean_id;
    public $pasien_id;
    public Pasien $pasien;
    
    // Form Fields
    public $keluhan;
    public $diagnosa; // Code - Name
    public $catatan_tambahan;
    
    // ICD-10 Search
    public $icd10Query;
    public $icd10Results = [];

    // Files
    public $uploads = [];
    public $uploadTypes = [];
    public $uploadNotes = [];

    // Vitals
    public $tekanan_darah;
    public $suhu_tubuh;
    public $berat_badan;
    public $tinggi_badan;
    public $nadi;
    public $pernapasan;

    // Tindakan Selection
    public $selectedTindakans = []; 
    public $showTindakanModal = false;
    public $searchTindakan = '';

    // Resep Obat
    public $resep = [];

    // Odontogram
    public $odontogram = [];
    public $isPoliGigi = false;

    public function mount($antrean_id = null)
    {
        if ($antrean_id) {
            $this->antrean_id = $antrean_id;
            $antrean = Antrean::findOrFail($antrean_id);
            
            if ($antrean->status == 'Selesai' || $antrean->status == 'Batal') {
                return redirect()->route('rekam-medis.index');
            }

            $this->pasien = $antrean->pasien;
            $this->pasien_id = $antrean->pasien_id;
            
            if ($antrean->status == 'Menunggu') {
                $antrean->update(['status' => 'Diperiksa']);
            }
        } else {
             return redirect()->route('rekam-medis.index');
        }

        // Cek Poli Gigi (Simplifikasi: Jika role dokter dan user terkait poli gigi atau manual check)
        // Di real app, cek $antrean->poli_tujuan == 'Poli Gigi'
        // Asumsi string 'Poli Gigi'
        if (str_contains(strtolower($antrean->poli_tujuan), 'gigi')) {
            $this->isPoliGigi = true;
            $this->initOdontogram();
        }

        $this->addResepRow();
        $this->addUploadRow();
    }

    public function initOdontogram()
    {
        // Standar FDI Numbering System (Dewasa 11-48, Anak 51-85)
        $teeth = [
            18,17,16,15,14,13,12,11, 21,22,23,24,25,26,27,28,
            48,47,46,45,44,43,42,41, 31,32,33,34,35,36,37,38,
            // Anak
            55,54,53,52,51, 61,62,63,64,65,
            85,84,83,82,81, 71,72,73,74,75
        ];
        
        foreach($teeth as $t) {
            $this->odontogram[$t] = 'N'; // N = Normal
        }
    }

    public function setGigiStatus($number, $status)
    {
        $this->odontogram[$number] = $status;
    }

    public function toggleGigi($number)
    {
        $current = $this->odontogram[$number] ?? 'N';
        $next = match($current) {
            'N' => 'C',
            'C' => 'M',
            'M' => 'F',
            'F' => 'N',
            default => 'N'
        };
        $this->odontogram[$number] = $next;
    }

    public function updatedIcd10Query()
    {
        if (strlen($this->icd10Query) > 1) {
            $this->icd10Results = Icd10::where('code', 'like', $this->icd10Query . '%')
                ->orWhere('name_en', 'like', '%' . $this->icd10Query . '%')
                ->orWhere('name_id', 'like', '%' . $this->icd10Query . '%')
                ->take(10)
                ->get();
        } else {
            $this->icd10Results = [];
        }
    }

    public function selectIcd10($code, $name)
    {
        $this->diagnosa = "$code - $name";
        $this->icd10Query = '';
        $this->icd10Results = [];
    }

    public function addResepRow()
    {
        $this->resep[] = ['obat_id' => '', 'jumlah' => 1, 'aturan_pakai' => ''];
    }

    public function removeResepRow($index)
    {
        unset($this->resep[$index]);
        $this->resep = array_values($this->resep);
    }

    public function addUploadRow()
    {
        $this->uploads[] = null;
        $this->uploadTypes[] = 'Lab';
        $this->uploadNotes[] = '';
    }

    public function removeUploadRow($index)
    {
        unset($this->uploads[$index]);
        unset($this->uploadTypes[$index]);
        unset($this->uploadNotes[$index]);
        $this->uploads = array_values($this->uploads);
        $this->uploadTypes = array_values($this->uploadTypes);
        $this->uploadNotes = array_values($this->uploadNotes);
    }

    public function toggleTindakanModal()
    {
        $this->showTindakanModal = !$this->showTindakanModal;
        if($this->showTindakanModal) {
            $this->searchTindakan = '';
        }
    }

    public function selectTindakan($id)
    {
        if (in_array($id, $this->selectedTindakans)) {
            $this->selectedTindakans = array_diff($this->selectedTindakans, [$id]);
        } else {
            $this->selectedTindakans[] = $id;
        }
    }

    public function save()
    {
        $this->validate([
            'keluhan' => 'required|string',
            'diagnosa' => 'required|string',
            'tekanan_darah' => 'nullable|string',
            'suhu_tubuh' => 'nullable|numeric',
            'berat_badan' => 'nullable|numeric',
            'tinggi_badan' => 'nullable|numeric',
            'uploads.*' => 'nullable|file|max:10240', // 10MB
        ]);

        try {
            DB::beginTransaction();

            // Filter Valid Resep Rows
            $validResep = array_filter($this->resep, fn($r) => !empty($r['obat_id']));
            $hasResep = count($validResep) > 0;

            $rekamMedis = RekamMedis::create([
                'pasien_id' => $this->pasien_id,
                'dokter_id' => Auth::id(),
                'tanggal_periksa' => now(),
                'keluhan' => $this->keluhan,
                'diagnosa' => $this->diagnosa,
                'catatan_tambahan' => $this->catatan_tambahan,
                'tekanan_darah' => $this->tekanan_darah,
                'suhu_tubuh' => $this->suhu_tubuh,
                'berat_badan' => $this->berat_badan,
                'tinggi_badan' => $this->tinggi_badan,
                'nadi' => $this->nadi,
                'pernapasan' => $this->pernapasan,
                'status_resep' => $hasResep ? 'Menunggu Obat' : 'Tidak Ada Resep',
                'status_pemeriksaan' => 'Selesai',
                'odontogram' => $this->isPoliGigi ? $this->odontogram : null,
            ]);

            // Sync Tindakan
            if (!empty($this->selectedTindakans)) {
                $tindakans = Tindakan::whereIn('id', $this->selectedTindakans)->get()->keyBy('id');
                foreach ($this->selectedTindakans as $tindakanId) {
                    if (isset($tindakans[$tindakanId])) {
                        $rekamMedis->tindakans()->attach($tindakanId, ['biaya' => $tindakans[$tindakanId]->harga]);
                    }
                }
            }
            
            // Sync Resep
            if ($hasResep) {
                $obatIds = array_column($validResep, 'obat_id');
                $obats = Obat::whereIn('id', $obatIds)->get()->keyBy('id');

                foreach ($validResep as $item) {
                    if (isset($obats[$item['obat_id']])) {
                        $obat = $obats[$item['obat_id']];
                        
                        if ($obat->stok < $item['jumlah']) {
                            throw new \Exception("Stok obat '{$obat->nama_obat}' tidak mencukupi (Sisa: {$obat->stok}). Harap kurangi jumlah atau pilih obat lain.");
                        }

                        $rekamMedis->obats()->attach($item['obat_id'], [
                            'jumlah' => $item['jumlah'],
                            'aturan_pakai' => $item['aturan_pakai']
                        ]);
                    }
                }
            }

            // Upload Files
            foreach ($this->uploads as $key => $file) {
                if ($file) {
                    $path = $file->store('rekam_medis_files', 'public');
                    RekamMedisFile::create([
                        'rekam_medis_id' => $rekamMedis->id,
                        'file_path' => $path,
                        'file_name' => $file->getClientOriginalName(),
                        'file_type' => $this->uploadTypes[$key] ?? 'Lainnya',
                        'keterangan' => $this->uploadNotes[$key] ?? null,
                    ]);
                }
            }

            // Update Antrean Status Logic
            if ($this->antrean_id) {
                $nextStatus = 'Selesai';
                
                if ($hasResep) {
                    $nextStatus = 'Farmasi';
                } else {
                    // Check if billable (not BPJS or has Billable Actions)
                    // Simplified: All finished visits go to Kasir if not pharmacy first, except free logic handled at cashier.
                    // But to be clean:
                    // If BPJS & No Tindakan Berbayar -> Selesai?
                    // Let's standardise: Poli -> (Farmasi) -> Kasir -> Selesai
                    // If No Farmasi, skip to Kasir.
                    $nextStatus = 'Kasir';
                }
                
                Antrean::where('id', $this->antrean_id)->update(['status' => $nextStatus]);
            }

            DB::commit();

            $this->dispatch('notify', 'success', 'Pemeriksaan selesai & disimpan.');
            return $this->redirect(route('rekam-medis.index'), navigate: true);

        } catch (\Exception $e) {
            DB::rollback();
            $this->dispatch('notify', 'error', 'Gagal menyimpan: ' . $e->getMessage());
        }
    }

    public function render()
    {
        $tindakanQuery = Tindakan::query();
        if(!empty($this->searchTindakan)) {
            $tindakanQuery->where('nama_tindakan', 'like', '%'.$this->searchTindakan.'%');
        }

        return view('livewire.rekam-medis.create', [
            'obats' => Obat::orderBy('nama_obat')->get(),
            'tindakans' => $tindakanQuery->orderBy('nama_tindakan')->get(), 
        ])->layout('layouts.app', ['header' => 'Pemeriksaan Pasien']);
    }
}
