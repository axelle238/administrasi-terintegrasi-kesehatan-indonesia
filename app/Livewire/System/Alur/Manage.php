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
            'roles' => Role::all() // Pass roles for dropdown
        ])->layout('layouts.app', ['header' => 'Editor Alur: ' . $this->jenisPelayanan->nama_layanan]);
    }

    public function create()
    {
        $this->resetInput();
        $lastAlur = $this->jenisPelayanan->alurPelayanans()->orderByDesc('urutan')->first();
        $this->urutan = ($lastAlur->urutan ?? 0) + 1;
        
        $this->isFormOpen = true;
        $this->activeTabForm = 'general';
    }

    public function edit($id)
    {
        $alur = AlurPelayanan::find($id);
        $this->fillForm($alur);
        $this->isFormOpen = true;
        $this->activeTabForm = 'general';
    }

    public function duplicate($id)
    {
        $source = AlurPelayanan::find($id);
        $newAlur = $source->replicate();
        $newAlur->judul = $newAlur->judul . ' (Copy)';
        $newAlur->urutan = $this->jenisPelayanan->alurPelayanans()->max('urutan') + 1;
        $newAlur->created_at = now();
        $newAlur->updated_at = now();
        $newAlur->save();

        $this->dispatch('notify', 'success', 'Langkah berhasil diduplikasi.');
    }

    private function fillForm($alur)
    {
        $this->alurId = $alur->id;
        $this->judul = $alur->judul;
        $this->deskripsi = $alur->deskripsi;
        $this->urutan = $alur->urutan;
        $this->is_active = $alur->is_active;
        $this->is_critical = $alur->is_critical;
        
        $this->estimasi_waktu = $alur->estimasi_waktu;
        $this->waktu_min = $alur->waktu_min;
        $this->waktu_max = $alur->waktu_max;
        
        $this->estimasi_biaya = $alur->estimasi_biaya;
        $this->biaya_sarana = $alur->biaya_sarana;
        $this->biaya_pelayanan = $alur->biaya_pelayanan;
        
        $this->target_pasien = $alur->target_pasien;
        $this->penanggung_jawab = $alur->penanggung_jawab;
        $this->required_role_id = $alur->required_role_id;
        $this->lokasi = $alur->lokasi;
        $this->jam_operasional = $alur->jam_operasional;
        
        $this->dokumen_syarat = $alur->dokumen_syarat;
        $this->output_langkah = $alur->output_langkah;
        
        $this->video_url = $alur->video_url;
        $this->action_label = $alur->action_label;
        $this->action_url = $alur->action_url;
        $this->tipe_alur = $alur->tipe_alur;
        $this->icon = $alur->icon;
        
        $this->internal_notes = $alur->internal_notes;
        $this->tagsInput = implode(', ', $alur->tags ?? []);
        
        $this->existingGambar = $alur->gambar;
        $this->existingFileTemplate = $alur->file_template;
        
        $this->faqs = $alur->faq ?? [['q' => '', 'a' => '']];
        if(empty($this->faqs)) $this->faqs = [['q' => '', 'a' => '']];
    }

    public function store()
    {
        $this->validate([
            'judul' => 'required',
            'urutan' => 'required|integer',
        ]);

        $tagsArray = array_filter(array_map('trim', explode(',', $this->tagsInput)));

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
            
            'target_pasien' => $this->target_pasien,
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

    public function delete($id)
    {
        $alur = AlurPelayanan::find($id);
        if ($alur->gambar) Storage::disk('public')->delete($alur->gambar);
        if ($alur->file_template) Storage::disk('public')->delete($alur->file_template);
        $alur->delete();
        $this->dispatch('notify', 'success', 'Langkah dihapus.');
    }

    public function setTabForm($tab)
    {
        $this->activeTabForm = $tab;
    }

    public function addFaq()
    {
        $this->faqs[] = ['q' => '', 'a' => ''];
    }

    public function removeFaq($index)
    {
        unset($this->faqs[$index]);
        $this->faqs = array_values($this->faqs);
    }

    public function cancel()
    {
        $this->isFormOpen = false;
        $this->resetInput();
    }

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
            'file_template', 'existingFileTemplate', 'faqs', 'activeTabForm'
        ]);
        $this->faqs = [['q' => '', 'a' => '']];
    }
}