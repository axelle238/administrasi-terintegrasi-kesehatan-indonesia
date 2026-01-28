<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use Spatie\Activitylog\Models\Activity;
use Illuminate\Support\Facades\Auth;

class ActivityLogShow extends Component
{
    public $activity;

    public function mount($id)
    {
        if (Auth::user()->role !== 'admin') {
            abort(403);
        }
        $this->activity = Activity::with('causer', 'subject')->findOrFail($id);
    }

    public function render()
    {
        return view('livewire.admin.activity-log-show')->layout('layouts.app', ['header' => 'Detail Log Aktivitas']);
    }
}
