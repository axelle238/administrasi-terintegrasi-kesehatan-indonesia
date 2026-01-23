<?php

namespace Database\Seeders;

use App\Models\Setting;
use Illuminate\Database\Seeder;

class SettingSeeder extends Seeder
{
    public function run(): void
    {
        $settings = [
            [
                'key' => 'app_name',
                'value' => 'Puskesmas Jagakarsa',
                'description' => 'Nama Instansi / Aplikasi'
            ],
            [
                'key' => 'app_address',
                'value' => 'Jl. Jagakarsa Raya No. 1, Jakarta Selatan',
                'description' => 'Alamat Lengkap Instansi'
            ],
            [
                'key' => 'app_phone',
                'value' => '(021) 7890123',
                'description' => 'Nomor Telepon Resmi'
            ],
            [
                'key' => 'app_email',
                'value' => 'info@puskesmasjagakarsa.go.id',
                'description' => 'Email Resmi'
            ],
            [
                'key' => 'bpjs_integration',
                'value' => '0',
                'description' => 'Integrasi P-Care BPJS (1=Aktif, 0=Nonaktif)'
            ],
            [
                'key' => 'ews_threshold_month',
                'value' => '3',
                'description' => 'Batas Peringatan EWS (Bulan) untuk Expired & STR'
            ],
            [
                'key' => 'admin_fee',
                'value' => '10000',
                'description' => 'Biaya Administrasi Umum (Rp)'
            ]
        ];

        foreach ($settings as $setting) {
            Setting::updateOrCreate(['key' => $setting['key']], $setting);
        }
    }
}