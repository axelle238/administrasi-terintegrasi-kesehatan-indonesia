<?php

namespace App\Livewire\System\Cms;

use Livewire\Component;
use Livewire\WithFileUploads;
use App\Models\Setting;
use App\Models\LandingComponent;
use Illuminate\Support\Facades\Storage;

class Index extends Component
{
    use WithFileUploads;

    public $activeTab = 'general';

    // General Settings
    public $app_name, $app_tagline, $app_description, $app_phone, $app_email, $app_address, $footer_text;
    public $primary_color = '#10b981'; // Emerald Default

    // Section Editor State
    public $editingSectionId = null;
    public $section_title, $section_subtitle, $section_content;
    public $section_image; // Uploaded file
    public $current_section_image; // Existing path
    public $section_metadata = [];

    public function mount()
    {
        // Load Settings
        $settings = Setting::all()->pluck('value', 'key');
        $this->app_name = $settings['app_name'] ?? 'SATRIA';
        $this->app_tagline = $settings['app_tagline'] ?? 'Health System';
        $this->app_description = $settings['app_description'] ?? '';
        $this->app_phone = $settings['app_phone'] ?? '';
        $this->app_email = $settings['app_email'] ?? '';
        $this->app_address = $settings['app_address'] ?? '';
        $this->footer_text = $settings['footer_text'] ?? '';
        $this->primary_color = $settings['primary_color'] ?? '#10b981';
    }

    public function setTab($tab)
    {
        $this->activeTab = $tab;
        $this->resetSectionEditor();
    }

    // === General Settings Logic ===
    public function saveGeneral()
    {
        $data = [
            'app_name' => $this->app_name,
            'app_tagline' => $this->app_tagline,
            'app_description' => $this->app_description,
            'app_phone' => $this->app_phone,
            'app_email' => $this->app_email,
            'app_address' => $this->app_address,
            'footer_text' => $this->footer_text,
            'primary_color' => $this->primary_color,
        ];

        foreach ($data as $key => $value) {
            Setting::updateOrCreate(['key' => $key], ['value' => $value]);
        }

        $this->dispatch('notify', 'success', 'Pengaturan umum berhasil disimpan.');
    }

    // === Section Editor Logic ===
    public function editSection($id)
    {
        $section = LandingComponent::find($id);
        $this->editingSectionId = $id;
        $this->section_title = $section->title;
        $this->section_subtitle = $section->subtitle;
        $this->section_content = $section->content;
        $this->current_section_image = $section->image;
        $this->section_metadata = $section->metadata ?? [];
        // Flatten metadata for binding if needed, or keep as array
    }

    public function updateSection()
    {
        $section = LandingComponent::find($this->editingSectionId);
        
        $data = [
            'title' => $this->section_title,
            'subtitle' => $this->section_subtitle,
            'content' => $this->section_content,
            'metadata' => $this->section_metadata // Save metadata array directly
        ];

        if ($this->section_image) {
            $path = $this->section_image->store('cms', 'public');
            $data['image'] = $path;
        }

        $section->update($data);
        
        $this->resetSectionEditor();
        $this->dispatch('notify', 'success', 'Bagian halaman berhasil diperbarui.');
    }

    public function toggleSection($id)
    {
        $section = LandingComponent::find($id);
        $section->update(['is_active' => !$section->is_active]);
    }

    public function moveUp($id)
    {
        $section = LandingComponent::find($id);
        $previous = LandingComponent::where('order', '<', $section->order)->orderBy('order', 'desc')->first();
        
        if ($previous) {
            $tempOrder = $section->order;
            $section->update(['order' => $previous->order]);
            $previous->update(['order' => $tempOrder]);
        }
    }

    public function moveDown($id)
    {
        $section = LandingComponent::find($id);
        $next = LandingComponent::where('order', '>', $section->order)->orderBy('order', 'asc')->first();
        
        if ($next) {
            $tempOrder = $section->order;
            $section->update(['order' => $next->order]);
            $next->update(['order' => $tempOrder]);
        }
    }

    public function resetSectionEditor()
    {
        $this->reset(['editingSectionId', 'section_title', 'section_subtitle', 'section_content', 'section_image', 'current_section_image', 'section_metadata']);
    }

    public function render()
    {
        return view('livewire.system.cms.index', [
            'sections' => LandingComponent::orderBy('order')->get()
        ])->layout('layouts.app', ['header' => 'CMS - Manajemen Halaman Depan']);
    }
}
