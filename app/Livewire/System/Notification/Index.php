<?php

namespace App\Livewire\System\Notification;

use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Support\Facades\Auth;

class Index extends Component
{
    use WithPagination;

    public $filter = 'all'; // all, unread
    public $kategoriFilter = ''; // '', info, warning, danger, etc.

    public function setFilter($filter)
    {
        $this->filter = $filter;
        $this->resetPage();
    }

    public function setKategori($kategori)
    {
        $this->kategoriFilter = $kategori;
        $this->resetPage();
    }

    public function markAsRead($id)
    {
        $notification = Auth::user()->notifications()->where('id', $id)->first();
        if ($notification) {
            $notification->markAsRead();
            
            if (isset($notification->data['url']) && $notification->data['url'] !== '#') {
                return redirect($notification->data['url']);
            }
        }
    }

    public function delete($id)
    {
        $notification = Auth::user()->notifications()->where('id', $id)->first();
        if ($notification) {
            $notification->delete();
        }
    }

    public function markAllRead()
    {
        Auth::user()->unreadNotifications->markAsRead();
        $this->dispatch('notifications-cleared'); // Update navbar badge
    }

    public function render()
    {
        $query = Auth::user()->notifications();

        if ($this->filter === 'unread') {
            $query->whereNull('read_at');
        }

        if ($this->kategoriFilter) {
            $query->where('data->kategori', $this->kategoriFilter);
        }

        $notifications = $query->latest()->paginate(10);

        return view('livewire.system.notification.index', compact('notifications'))
            ->layout('layouts.app', ['header' => 'Pusat Notifikasi']);
    }
}
