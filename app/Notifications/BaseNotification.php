<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

abstract class BaseNotification extends Notification
{
    use Queueable;

    protected $judul;
    protected $pesan;
    protected $url;
    protected $kategori; // info, success, warning, danger, urgent
    protected $ikon;

    /**
     * Create a new notification instance.
     */
    public function __construct($judul, $pesan, $url = '#', $kategori = 'info', $ikon = null)
    {
        $this->judul = $judul;
        $this->pesan = $pesan;
        $this->url = $url;
        $this->kategori = $kategori;
        $this->ikon = $ikon ?? $this->getDefaultIcon($kategori);
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['database'];
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            'judul' => $this->judul,
            'pesan' => $this->pesan,
            'url' => $this->url,
            'kategori' => $this->kategori,
            'ikon' => $this->ikon,
            'warna' => $this->getColor($this->kategori),
            'waktu' => now()->toISOString(),
        ];
    }

    protected function getDefaultIcon($kategori)
    {
        return match ($kategori) {
            'success' => 'check-circle',
            'warning' => 'exclamation-triangle',
            'danger' => 'x-circle',
            'urgent' => 'bell-alert',
            default => 'information-circle',
        };
    }

    protected function getColor($kategori)
    {
        return match ($kategori) {
            'success' => 'emerald',
            'warning' => 'amber',
            'danger' => 'rose',
            'urgent' => 'violet',
            default => 'blue',
        };
    }
}
