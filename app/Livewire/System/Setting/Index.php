<?php

namespace App\Livewire\System\Setting;

use App\Models\Setting;
use Livewire\Component;
use Illuminate\Support\Facades\Cache;

class Index extends Component
{
    public $activeTab = 'umum';
    public $form = [];

    // Definisi Schema Pengaturan Sistem Lengkap
    protected function schema()
    {
        return [
            'umum' => [
                'label' => 'Identitas Instansi',
                'icon' => 'office-building',
                'fields' => [
                    'app_name' => ['label' => 'Nama Instansi/Aplikasi', 'type' => 'text', 'default' => 'SATRIA Health'],
                    'app_tagline' => ['label' => 'Slogan (Tagline)', 'type' => 'text', 'default' => 'Melayani dengan Hati'],
                    'app_description' => ['label' => 'Deskripsi Singkat', 'type' => 'textarea', 'default' => 'Sistem Informasi Manajemen Puskesmas Terintegrasi.'],
                    'app_address' => ['label' => 'Alamat Lengkap', 'type' => 'textarea', 'default' => 'Jl. Kesehatan No. 1, Jakarta'],
                    'app_phone' => ['label' => 'Nomor Telepon', 'type' => 'text', 'default' => '021-12345678'],
                    'app_email' => ['label' => 'Email Resmi', 'type' => 'email', 'default' => 'info@puskesmas.go.id'],
                ]
            ],
            'tampilan' => [
                'label' => 'Halaman Depan (Landing)',
                'icon' => 'desktop-computer',
                'fields' => [
                    'hero_title' => ['label' => 'Judul Hero Section', 'type' => 'text', 'default' => 'Layanan Kesehatan Terpadu'],
                    'hero_subtitle' => ['label' => 'Sub-Judul Hero', 'type' => 'text', 'default' => 'Kesehatan Anda adalah Prioritas Kami'],
                    // Fitur Landing Page bisa JSON, tapi kita simplifikasi text dulu atau handle khusus nanti
                ]
            ],
            'operasional' => [
                'label' => 'Operasional & EWS',
                'icon' => 'clock',
                'fields' => [
                    'jam_buka' => ['label' => 'Jam Buka Pendaftaran', 'type' => 'time', 'default' => '07:00'],
                    'jam_tutup' => ['label' => 'Jam Tutup Pendaftaran', 'type' => 'time', 'default' => '14:00'],
                    'ews_threshold_month' => ['label' => 'Ambang Batas Peringatan (Bulan)', 'type' => 'number', 'default' => '3', 'help' => 'Berapa bulan sebelum expired peringatan muncul (STR/SIP/Obat).'],
                    'antrean_max_daily' => ['label' => 'Maksimal Antrean Harian', 'type' => 'number', 'default' => '200'],
                ]
            ],
            'integrasi' => [
                'label' => 'Integrasi Eksternal (API)',
                'icon' => 'share',
                'fields' => [
                    'bpjs_cons_id' => ['label' => 'BPJS Cons ID', 'type' => 'text', 'default' => ''],
                    'bpjs_secret_key' => ['label' => 'BPJS Secret Key', 'type' => 'password', 'default' => ''],
                    'bpjs_user_key' => ['label' => 'BPJS User Key (P-Care)', 'type' => 'password', 'default' => ''],
                    'satusehat_client_id' => ['label' => 'SatuSehat Client ID', 'type' => 'text', 'default' => ''],
                    'satusehat_client_secret' => ['label' => 'SatuSehat Client Secret', 'type' => 'password', 'default' => ''],
                ]
            ],
            'keuangan' => [
                'label' => 'Keuangan & Billing',
                'icon' => 'currency-dollar',
                'fields' => [
                    'currency_symbol' => ['label' => 'Simbol Mata Uang', 'type' => 'text', 'default' => 'Rp'],
                    'biaya_pendaftaran_umum' => ['label' => 'Biaya Daftar Pasien Umum', 'type' => 'number', 'default' => '10000'],
                    'pajak_obat_persen' => ['label' => 'Pajak Obat (%)', 'type' => 'number', 'default' => '0'],
                    'margin_obat_persen' => ['label' => 'Margin Keuntungan Obat (%)', 'type' => 'number', 'default' => '20'],
                ]
            ],
            'surat' => [
                'label' => 'Format Persuratan',
                'icon' => 'document-text',
                'fields' => [
                    'kota_surat' => ['label' => 'Kota Penandatangan', 'type' => 'text', 'default' => 'Jakarta'],
                    'kepala_instansi' => ['label' => 'Nama Kepala Instansi', 'type' => 'text', 'default' => 'dr. Kepala Puskesmas'],
                    'nip_kepala_instansi' => ['label' => 'NIP Kepala Instansi', 'type' => 'text', 'default' => '-'],
                ]
            ]
        ];
    }

    public function mount()
    {
        // Load settings from DB, merge with defaults
        $dbSettings = Setting::all()->pluck('value', 'key')->toArray();
        
        $this->form = [];
        
        foreach ($this->schema() as $tab => $group) {
            foreach ($group['fields'] as $key => $config) {
                // Prioritize DB value, then Config Default
                $this->form[$key] = $dbSettings[$key] ?? $config['default'];
            }
        }
    }

    public function save()
    {
        // Validasi bisa ditambahkan di sini jika perlu
        
        foreach ($this->form as $key => $value) {
            Setting::simpan($key, $value);
        }
        
        Cache::forget('app_settings');
        
        $this->dispatch('notify', 'success', 'Pengaturan sistem berhasil diperbarui secara menyeluruh.');
    }

    public function render()
    {
        return view('livewire.system.setting.index', [
            'schema' => $this->schema()
        ])->layout('layouts.app', ['header' => 'Pengaturan Sistem Terintegrasi']);
    }
}