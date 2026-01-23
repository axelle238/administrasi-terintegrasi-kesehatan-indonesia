<?php

namespace App\Livewire\System\Setting;

use App\Models\Setting;
use Livewire\Component;
use Illuminate\Support\Facades\Cache;

class Index extends Component
{
    public $settings_data = [];

    public function mount()
    {
        // Load all settings into an array keyed by 'key'
        $this->settings_data = Setting::all()->pluck('value', 'key')->toArray();
    }

    public function save()
    {
        foreach ($this->settings_data as $key => $value) {
            Setting::where('key', $key)->update(['value' => $value]);
        }
        
        Cache::forget('app_settings');
        
        $this->dispatch('notify', 'success', 'Pengaturan berhasil disimpan.');
    }

    public function render()
    {
        // Group settings for UI
        $groups = Setting::all()->groupBy('group');
        
        return view('livewire.system.setting.index', [
            'groups' => $groups
        ])->layout('layouts.app', ['header' => 'Pengaturan Sistem']);
    }
}