<?php

namespace App\Services;

use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Http;

class WhatsAppService
{
    /**
     * Kirim Pesan WA (Simulasi)
     */
    public static function send($phone, $message)
    {
        // Format nomor (08 -> 628)
        $phone = preg_replace('/^0/', '62', $phone);
        
        // Log untuk simulasi
        Log::info("WA_OUT -> {$phone}: {$message}");

        // Real implementation example (Fonnte):
        /*
        try {
            Http::withHeaders([
                'Authorization' => env('WA_TOKEN'),
            ])->post('https://api.fonnte.com/send', [
                'target' => $phone,
                'message' => $message,
            ]);
        } catch (\Exception $e) {
            Log::error("WA_FAIL: " . $e->getMessage());
        }
        */
        
        return true;
    }
}
