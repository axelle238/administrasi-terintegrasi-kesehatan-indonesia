<?php

namespace App\Livewire\System\Alur;

use Livewire\Component;
use Livewire\WithFileUploads;
use App\Models\AlurPelayanan;
use App\Models\JenisPelayanan;
use App\Models\Role; // Use Role model
use Illuminate\Support\Facades\Storage;

class Manage extends Component
{
    use WithFileUploads;

    public JenisPelayanan $jenisPelayanan;
    
    // State Form Langkah
    public $alurId;
    public $judul, $deskripsi, $urutan, $is_active = true, $is_critical = false;
    public $estimasi_waktu, $waktu_min, $waktu_max; // Time upgrades
    public $estimasi_biaya = 0, $biaya_sarana = 0, $biaya_pelayanan = 0; // Cost upgrades
    public $target_pasien = 'Umum', $penanggung_jawab, $required_role_id, $lokasi, $jam_operasional;
    public $dokumen_syarat, $output_langkah;
    public $video_url, $action_label, $action_url;
    public $tipe_alur = 'Offline';
    public $internal_notes, $tagsInput = '';
    
    // Logic Branching
    public $visibility_target = []; // Array of selected targets (Umum, BPJS, etc)

    public $gambar, $existingGambar;
    public $file_template, $existingFileTemplate;
    public $icon = 'check-circle';
    
    public $faqs = [['q' => '', 'a' => '']];

    public $isFormOpen = false;
    public $activeTabForm = 'general';

    public function mount(JenisPelayanan $jenisPelayanan)
    {
        $this->jenisPelayanan = $jenisPelayanan;
    }

    public function render()
    {
        return view('livewire.system.alur.manage', [
            'alurs' => $this->jenisPelayanan->alurPelayanans()->orderBy('urutan')->get(),
            'roles' => Role::all()
        ])->layout('layouts.app', ['header' => 'Editor Alur: ' . $this->jenisPelayanan->nama_layanan]);
    }

    public function create()
    {
        $this->resetInput();
        $lastAlur = $this->jenisPelayanan->alurPelayanans()->orderByDesc('urutan')->first();
        $this->urutan = ($lastAlur->urutan ?? 0) + 1;
        $this->visibility_target = []; // Default all
        
        $this->isFormOpen = true;
        $this->activeTabForm = 'general';
    }

    public function edit($id)
    {
        $alur = AlurPelayanan::find($id);
        $this->fillForm($alur);
        
        // Load visibility rules
        $rules = $alur->visibility_rules ?? [];
        $this->visibility_target = $rules['target_pasien'] ?? [];

        $this->isFormOpen = true;
        $this->activeTabForm = 'general';
    }
    
    // ... (duplicate function remains same) ...

    public function store()
    {
        $this->validate([
            'judul' => 'required',
            'urutan' => 'required|integer',
        ]);

        $tagsArray = array_filter(array_map('trim', explode(',', $this->tagsInput)));
        
        // Prepare Visibility Rules
        $visibilityRules = null;
        if (!empty($this->visibility_target)) {
            $visibilityRules = ['target_pasien' => $this->visibility_target];
        }

        $data = [
            'jenis_pelayanan_id' => $this->jenisPelayanan->id,
            'judul' => $this->judul,
            'deskripsi' => $this->deskripsi,
            'urutan' => $this->urutan,
            'is_active' => $this->is_active,
            'is_critical' => $this->is_critical,
            // Time
            'estimasi_waktu' => $this->estimasi_waktu,
            'waktu_min' => $this->waktu_min,
            'waktu_max' => $this->waktu_max,
            // Cost
            'estimasi_biaya' => $this->estimasi_biaya,
            'biaya_sarana' => $this->biaya_sarana,
            'biaya_pelayanan' => $this->biaya_pelayanan,
            
            'target_pasien' => $this->target_pasien, // Main label
            'penanggung_jawab' => $this->penanggung_jawab,
            'required_role_id' => $this->required_role_id,
            'lokasi' => $this->lokasi,
            'jam_operasional' => $this->jam_operasional,
            'dokumen_syarat' => $this->dokumen_syarat,
            'output_langkah' => $this->output_langkah,
            'video_url' => $this->video_url,
            'action_label' => $this->action_label,
            'action_url' => $this->action_url,
            'tipe_alur' => $this->tipe_alur,
            'icon' => $this->icon,
            'internal_notes' => $this->internal_notes,
            'tags' => $tagsArray,
            'visibility_rules' => $visibilityRules,
            'faq' => array_values(array_filter($this->faqs, fn($f) => !empty($f['q']))),
        ];

        if ($this->gambar) {
            $data['gambar'] = $this->gambar->store('alur-images', 'public');
        }
        
        if ($this->file_template) {
            $data['file_template'] = $this->file_template->store('alur-docs', 'public');
        }

        AlurPelayanan::updateOrCreate(['id' => $this->alurId], $data);

        $this->dispatch('notify', 'success', 'Langkah alur berhasil disimpan.');
        $this->cancel();
    }

    // ... (rest of functions) ...

    private function resetInput()
    {
        $this->reset([
            'alurId', 'judul', 'deskripsi', 'urutan', 'is_active', 'is_critical',
            'estimasi_waktu', 'waktu_min', 'waktu_max',
            'estimasi_biaya', 'biaya_sarana', 'biaya_pelayanan',
            'target_pasien', 'penanggung_jawab', 'required_role_id',
            'lokasi', 'jam_operasional', 'dokumen_syarat', 'output_langkah',
            'video_url', 'action_label', 'action_url', 'tipe_alur', 'icon',
            'internal_notes', 'tagsInput', 'gambar', 'existingGambar', 
            'file_template', 'existingFileTemplate', 'faqs', 'activeTabForm',
            'visibility_target'
        ]);
        $this->faqs = [['q' => '', 'a' => '']];
    }
}