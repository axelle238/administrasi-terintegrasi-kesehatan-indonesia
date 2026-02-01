<?php

namespace App\Livewire\System\Cms;

use Livewire\Component;
use Livewire\WithFileUploads;
use App\Models\LandingComponent;
use Illuminate\Support\Facades\Storage;

class Manage extends Component
{
    use WithFileUploads;

    public $sections;
    public $activeSectionId = null;
    
    // Form Inputs
    public $title;
    public $subtitle;
    public $content;
    public $image;
    public $existingImage;
    public $metadata = []; // Dynamic Key-Value pairs

    public function mount()
    {
        $this->loadSections();
    }

    public function loadSections()
    {
        $this->sections = LandingComponent::orderBy('order')->get();
    }

    public function editSection($id)
    {
        $this->activeSectionId = $id;
        $section = LandingComponent::find($id);
        
        $this->title = $section->title;
        $this->subtitle = $section->subtitle;
        $this->content = $section->content;
        $this->existingImage = $section->image;
        $this->metadata = $section->metadata ?? [];
        $this->image = null; // Reset upload
    }

    public function updateSection()
    {
        $this->validate([
            'title' => 'required|string',
            'image' => 'nullable|image|max:2048', // 2MB Max
        ]);

        $section = LandingComponent::find($this->activeSectionId);
        
        $data = [
            'title' => $this->title,
            'subtitle' => $this->subtitle,
            'content' => $this->content,
            'metadata' => $this->metadata,
        ];

        if ($this->image) {
            // Delete old image if exists
            if ($section->image) {
                Storage::disk('public')->delete($section->image);
            }
            $data['image'] = $this->image->store('cms', 'public');
        }

        $section->update($data);
        
        $this->dispatch('notify', message: 'Bagian halaman berhasil diperbarui!');
        $this->loadSections(); // Refresh list to update previews
    }

    public function toggleActive($id)
    {
        $section = LandingComponent::find($id);
        $section->update(['is_active' => !$section->is_active]);
        $this->loadSections();
    }

    public function moveUp($id)
    {
        $section = LandingComponent::find($id);
        $prev = LandingComponent::where('order', '<', $section->order)->orderBy('order', 'desc')->first();
        
        if ($prev) {
            $temp = $section->order;
            $section->update(['order' => $prev->order]);
            $prev->update(['order' => $temp]);
            $this->loadSections();
        }
    }

    public function moveDown($id)
    {
        $section = LandingComponent::find($id);
        $next = LandingComponent::where('order', '>', $section->order)->orderBy('order')->first();
        
        if ($next) {
            $temp = $section->order;
            $section->update(['order' => $next->order]);
            $next->update(['order' => $temp]);
            $this->loadSections();
        }
    }

    public function render()
    {
        return view('livewire.system.cms.manage')
            ->layout('layouts.app', ['title' => 'Manajemen Halaman Depan']);
    }
}
