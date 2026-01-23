<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Gate;
use App\Models\User;
use App\Models\Setting;
use Illuminate\Pagination\Paginator;
use Carbon\Carbon;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Cache;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Set Locale & Timezone
        config(['app.locale' => 'id']);
        Carbon::setLocale('id');
        date_default_timezone_set('Asia/Jakarta');

        Paginator::useTailwind();

        // Load Settings dengan Cache untuk Optimasi Performa
        // Cache akan disimpan selama 24 jam (1440 menit)
        if (Schema::hasTable('settings')) {
            $settings = Cache::remember('app_settings', 60 * 24, function () {
                return Setting::all()->pluck('value', 'key')->toArray();
            });
            
            // Bagikan variabel global ke semua views
            View::share('app_settings', $settings);
            
            // Override config dinamis
            if (isset($settings['app_name'])) {
                config(['app.name' => $settings['app_name']]);
            }
        }

        // Definisi Gates (Akses Kontrol)
        // 1. Gate Administrator
        Gate::define('admin', function (User $user) {
            return $user->role === 'admin';
        });

        // 2. Gate Medis (Dokter & Perawat)
        Gate::define('medis', function (User $user) {
            return in_array($user->role, ['dokter', 'perawat', 'admin']);
        });

        // 3. Gate Farmasi (Apoteker)
        Gate::define('farmasi', function (User $user) {
            return in_array($user->role, ['apoteker', 'admin']);
        });

        // 4. Gate Tata Usaha (Staf & Perawat)
        Gate::define('tata_usaha', function (User $user) {
            return in_array($user->role, ['staf', 'admin', 'perawat']);
        });
    }
}