<?php

namespace App\Services;

use App\Models\User;
use App\Notifications\SystemNotification;
use Illuminate\Support\Facades\Notification;

class NotifikasiService
{
    /**
     * Kirim notifikasi ke user tertentu.
     *
     * @param User|int $user User object atau User ID
     * @param string $judul Judul notifikasi
     * @param string $pesan Pesan detail
     * @param string $url URL redirect saat diklik
     * @param string $kategori info, success, warning, danger, urgent
     */
    public static function send($user, $judul, $pesan, $url = '#', $kategori = 'info')
    {
        if (is_numeric($user)) {
            $user = User::find($user);
        }

        if ($user) {
            $user->notify(new SystemNotification($judul, $pesan, $url, $kategori));
        }
    }

    /**
     * Kirim notifikasi ke semua user dengan role tertentu.
     */
    public static function sendToRole($role, $judul, $pesan, $url = '#', $kategori = 'info')
    {
        $users = User::where('role', $role)->get();
        Notification::send($users, new SystemNotification($judul, $pesan, $url, $kategori));
    }

    /**
     * Kirim notifikasi sistem ke Admin.
     */
    public static function sendToAdmin($judul, $pesan, $url = '#', $kategori = 'danger')
    {
        self::sendToRole('admin', $judul, $pesan, $url, $kategori);
    }
}
