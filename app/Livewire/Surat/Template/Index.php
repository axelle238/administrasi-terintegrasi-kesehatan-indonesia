<?php

namespace App\Livewire\Surat\Template;

use App\Models\SuratTemplate;
use Livewire\Component;
use Livewire\WithPagination;

class Index extends Component
{
    use WithPagination;

    public $kode_template;
    public $nama_template;
    public $konten;
    public $templateId;
    public $isOpen = false;

    protected $rules = [
        'kode_template' => 'required|string|unique:surat_templates,kode_template',
        'nama_template' => 'required|string',
        'konten' => 'required|string',
    ];

    public function create()
    {
        $this->reset(['kode_template', 'nama_template', 'konten', 'templateId']);
        $this->isOpen = true;
    }

    public function edit($id)
    {
        $template = SuratTemplate::findOrFail($id);
        $this->templateId = $id;
        $this->kode_template = $template->kode_template;
        $this->nama_template = $template->nama_template;
        $this->konten = $template->konten;
        $this->isOpen = true;
    }

    public function save()
    {
        if ($this->templateId) {
            $this->validate([
                'kode_template' => 'required|string|unique:surat_templates,kode_template,' . $this->templateId,
                'nama_template' => 'required|string',
                'konten' => 'required|string',
            ]);
            
            SuratTemplate::find($this->templateId)->update([
                'kode_template' => $this->kode_template,
                'nama_template' => $this->nama_template,
                'konten' => $this->konten,
            ]);
        } else {
            $this->validate();
            SuratTemplate::create([
                'kode_template' => $this->kode_template,
                'nama_template' => $this->nama_template,
                'konten' => $this->konten,
            ]);
        }

        $this->dispatch('notify', 'success', 'Template surat berhasil disimpan.');
        $this->isOpen = false;
    }

    public function delete($id)
    {
        SuratTemplate::find($id)->delete();
        $this->dispatch('notify', 'success', 'Template dihapus.');
    }

    public function render()
    {
        return view('livewire.surat.template.index', [
            'templates' => SuratTemplate::paginate(10)
        ])->layout('layouts.app', ['header' => 'Manajemen Template Surat']);
    }
}
