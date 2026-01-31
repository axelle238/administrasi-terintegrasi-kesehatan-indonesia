<?php

namespace App\Livewire\Partials;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;

class NavbarNotification extends Component
{
    // Polling interval (opsional, bisa diatur di view juga)
    // protected $listeners = ['notificationReceived' => '$refresh']; 

    public function getUnreadCountProperty()
    {
        return Auth::user()->unreadNotifications()->count();
    }

    public function getNotificationsProperty()
    {
        // Ambil 5 notifikasi terbaru saja untuk dropdown agar ringan
        return Auth::user()->notifications()->latest()->take(5)->get();
    }

    public function markAsRead($notificationId)
    {
        $notification = Auth::user()->notifications()->where('id', $notificationId)->first();
        if ($notification) {
            $notification->markAsRead();
            
            // Redirect jika ada URL
            if (isset($notification->data['url']) && $notification->data['url'] !== '#') {
                return redirect($notification->data['url']);
            }
        }
    }

    public function markAllRead()
    {
        Auth::user()->unreadNotifications->markAsRead();
        $this->dispatch('notifications-cleared');
    }

    public function render()
    {
        return view('livewire.partials.navbar-notification');
    }
}
