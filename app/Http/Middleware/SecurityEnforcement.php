<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Models\Setting;
use Illuminate\Support\Facades\App;

class SecurityEnforcement
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // 1. Force HTTPS
        // Cek setting 'force_https' dan pastikan bukan di environment local (kecuali dipaksa)
        if (Setting::ambil('force_https') == '1' && !$request->secure() && !App::environment('local')) {
            return redirect()->secure($request->getRequestUri());
        }

        // 2. IP Whitelist untuk Area Admin
        // Hanya cek jika user sedang mengakses rute admin/* atau login
        if ($request->is('admin*') || $request->is('login')) {
            $whitelist = Setting::ambil('ip_whitelist');
            
            if (!empty($whitelist)) {
                $allowedIps = array_map('trim', explode(',', $whitelist));
                $userIp = $request->ip();

                if (!in_array($userIp, $allowedIps)) {
                    // Log percobaan akses ilegal bisa ditambahkan di sini
                    abort(403, 'Akses ditolak. Alamat IP Anda (' . $userIp . ') tidak diizinkan mengakses area ini.');
                }
            }
        }

        return $next($request);
    }
}
