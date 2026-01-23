<?php

namespace App\Livewire\Components;

use Livewire\Component;
use Livewire\Attributes\On;

class ToastNotification extends Component
{
    public $notifications = [];

    #[On('notify')]
    public function addNotification($type, $message)
    {
        $id = uniqid();
        $this->notifications[] = [
            'id' => $id,
            'type' => $type, // 'success', 'error', 'info', 'warning'
            'message' => $message,
        ];
        
        // Dispatch browser event to auto-remove after 3 seconds if you want JS handling, 
        // but here we can just let Alpine handle the timeout visibility.
    }

    public function removeNotification($id)
    {
        $this->notifications = array_filter($this->notifications, function($n) use ($id) {
            return $n['id'] !== $id;
        });
    }

    public function render()
    {
        return view('livewire.components.toast-notification');
    }
}