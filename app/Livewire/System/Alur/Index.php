<?php

namespace App\Livewire\System\Alur;

use Livewire\Component;
use Livewire\WithFileUploads;
use App\Models\AlurPelayanan;
use App\Models\JenisPelayanan;
use Illuminate\Support\Facades\Storage;

class Index extends Component
{
    use WithFileUploads;

    public $alurId;
    // Core Fields
    public $judul, $deskripsi, $icon = 'check-circle', $urutan, $is_active = true;
    public $jenis_pelayanan_id;
    
    // Detailed Fields
    public $target_pasien = 'Umum', $estimasi_waktu, $dokumen_syarat;
    public $penanggung_jawab, $lokasi, $is_critical = false;
    public $video_url, $action_label, $action_url;
    public $tipe_alur = 'Offline'; 
    public $jam_operasional, $internal_notes;
    public $tagsInput = ''; // String input for tags
    
    // Media & Files
    public $gambar; 
    public $existingGambar;
    public $file_template; 
    public $existingFileTemplate; 
    
    // FAQ Repeater
    public $faqs = []; 

    public $isFormOpen = false;
    public $activeTabForm = 'general'; // general, media, advanced

    protected $rules = [
        'judul' => 'required',
        'urutan' => 'required|integer',
        'target_pasien' => 'required',
        'jenis_pelayanan_id' => 'nullable',
        'gambar' => 'nullable|image|max:2048', 
        'file_template' => 'nullable|file|mimes:pdf,doc,docx,xls,xlsx|max:5120',
        'faqs.*.q' => 'required_with:faqs.*.a',
        'faqs.*.a' => 'required_with:faqs.*.q',
    ];

    public function setTabForm($tab)
    {
        $this->activeTabForm = $tab;
    }

    public function render()
    {
        return view('livewire.system.alur.index', [
            'alurs' => AlurPelayanan::with('jenisPelayanan')->orderBy('jenis_pelayanan_id')->orderBy('urutan')->get(),
            'jenisPelayanans' => JenisPelayanan::all()
        ])->layout('layouts.app', ['header' => 'Manajemen Alur Pelayanan']);
    }

    public function create()
    {
        $this->resetInput();
        $this->isFormOpen = true;
        $this->activeTabForm = 'general';
        $this->faqs = [['q' => '', 'a' => '']];
    }

    public function edit($id)
    {
        $alur = AlurPelayanan::find($id);
        $this->alurId = $id;
        $this->judul = $alur->judul;
        $this->deskripsi = $alur->deskripsi;
        $this->icon = $alur->icon;
        $this->urutan = $alur->urutan;
        $this->is_active = $alur->is_active;
        $this->jenis_pelayanan_id = $alur->jenis_pelayanan_id;
        
        $this->target_pasien = $alur->target_pasien;
        $this->estimasi_waktu = $alur->estimasi_waktu;
        $this->dokumen_syarat = $alur->dokumen_syarat;
        
        $this->penanggung_jawab = $alur->penanggung_jawab;
        $this->lokasi = $alur->lokasi;
        $this->is_critical = $alur->is_critical;
        $this->video_url = $alur->video_url;
        $this->action_label = $alur->action_label;
        $this->action_url = $alur->action_url;
        $this->tipe_alur = $alur->tipe_alur;
        
        // Advanced
        $this->jam_operasional = $alur->jam_operasional;
        $this->internal_notes = $alur->internal_notes;
        $this->tagsInput = implode(', ', $alur->tags ?? []); // Array to String
        
        $this->existingGambar = $alur->gambar;
        $this->existingFileTemplate = $alur->file_template;
        
        $this->faqs = $alur->faq ?? [['q' => '', 'a' => '']];
        if (empty($this->faqs)) $this->faqs = [['q' => '', 'a' => '']];
        
        $this->isFormOpen = true;
        $this->activeTabForm = 'general';
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

    public function store()
    {
        $this->validate();

        // Convert Tags
        $tagsArray = array_map('trim', explode(',', $this->tagsInput));
        $tagsArray = array_filter($tagsArray); // Remove empty

        $data = [
            'judul' => $this->judul,
            'deskripsi' => $this->deskripsi,
            'icon' => $this->icon,
            'urutan' => $this->urutan,
            'is_active' => $this->is_active,
            'target_pasien' => $this->target_pasien,
            'estimasi_waktu' => $this->estimasi_waktu,
            'dokumen_syarat' => $this->dokumen_syarat,
            'jenis_pelayanan_id' => $this->jenis_pelayanan_id,
            'penanggung_jawab' => $this->penanggung_jawab,
            'lokasi' => $this->lokasi,
            'is_critical' => $this->is_critical,
            'video_url' => $this->video_url,
            'action_label' => $this->action_label,
            'action_url' => $this->action_url,
            'tipe_alur' => $this->tipe_alur,
            'jam_operasional' => $this->jam_operasional,
            'internal_notes' => $this->internal_notes,
            'tags' => $tagsArray,
            'faq' => array_filter($this->faqs, fn($f) => !empty($f['q'])),
        ];

        if ($this->gambar) {
            $data['gambar'] = $this->gambar->store('alur-images', 'public');
        }
        
        if ($this->file_template) {
            $data['file_template'] = $this->file_template->store('alur-docs', 'public');
        }

        AlurPelayanan::updateOrCreate(['id' => $this->alurId], $data);

        $this->cancel();
        $this->dispatch('notify', 'success', 'Data alur berhasil disimpan.');
    }

    public function delete($id)
    {
        $alur = AlurPelayanan::find($id);
        if ($alur->gambar) Storage::disk('public')->delete($alur->gambar);
        if ($alur->file_template) Storage::disk('public')->delete($alur->file_template);
        
        $alur->delete();
        $this->dispatch('notify', 'success', 'Alur dihapus.');
    }

    public function cancel()
    {
        $this->isFormOpen = false;
        $this->resetInput();
    }

    private function resetInput()
    {
        $this->reset([
            'alurId', 'judul', 'deskripsi', 'icon', 'urutan', 'is_active', 
            'target_pasien', 'estimasi_waktu', 'dokumen_syarat', 'jenis_pelayanan_id',
            'penanggung_jawab', 'lokasi', 'is_critical', 'gambar', 'existingGambar', 
            'file_template', 'existingFileTemplate', 'faqs',
            'video_url', 'action_label', 'action_url', 'tipe_alur',
            'jam_operasional', 'internal_notes', 'tagsInput', 'activeTabForm'
        ]);
    }
}