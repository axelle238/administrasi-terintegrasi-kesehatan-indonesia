<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use Livewire\WithPagination;
use Spatie\Activitylog\Models\Activity;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class ActivityLog extends Component
{
    use WithPagination;

    public $search = '';
    public $causer_id = '';
    public $event = '';
    public $date_start;
    public $date_end;

    public function mount()
    {
        if (Auth::user()->role !== 'admin') {
            abort(403, 'Unauthorized access.');
        }
    }

    public function resetFilters()
    {
        $this->reset(['search', 'causer_id', 'event', 'date_start', 'date_end']);
    }

    public function render()
    {
        $query = Activity::with('causer', 'subject')
            ->latest();

        if ($this->search) {
            $query->where('description', 'like', '%' . $this->search . '%')
                  ->orWhere('properties', 'like', '%' . $this->search . '%');
        }

        if ($this->causer_id) {
            $query->where('causer_id', $this->causer_id);
        }

        if ($this->event) {
            $query->where('event', $this->event);
        }

        if ($this->date_start) {
            $query->whereDate('created_at', '>=', $this->date_start);
        }

        if ($this->date_end) {
            $query->whereDate('created_at', '<=', $this->date_end);
        }

        return view('livewire.admin.activity-log', [
            'activities' => $query->paginate(20),
            'users' => User::orderBy('name')->get(['id', 'name', 'role'])
        ])->layout('layouts.app', ['header' => 'Log Aktivitas Sistem']);
    }
}