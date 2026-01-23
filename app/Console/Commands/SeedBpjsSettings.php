<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class SeedBpjsSettings extends Command
{
    protected $signature = 'bpjs:seed-settings';
    protected $description = 'Seed BPJS Configuration Settings';

    public function handle()
    {
        $settings = [
            ['key' => 'bpjs_cons_id', 'value' => '12345', 'label' => 'Cons ID', 'group' => 'bpjs', 'type' => 'text'],
            ['key' => 'bpjs_secret_key', 'value' => 'secret', 'label' => 'Secret Key', 'group' => 'bpjs', 'type' => 'password'],
            ['key' => 'bpjs_user_key', 'value' => 'userkey', 'label' => 'User Key (P-Care)', 'group' => 'bpjs', 'type' => 'password'],
            ['key' => 'bpjs_api_url', 'value' => 'https://apijkn-dev.bpjs-kesehatan.go.id/pcare-rest-dev', 'label' => 'API Base URL', 'group' => 'bpjs', 'type' => 'text'],
            ['key' => 'bpjs_service_name', 'value' => 'pcare-rest-dev', 'label' => 'Service Name', 'group' => 'bpjs', 'type' => 'text'],
            ['key' => 'bpjs_mode', 'value' => 'dev', 'label' => 'Mode (dev/prod)', 'group' => 'bpjs', 'type' => 'text'], // dev = mock data, prod = real api
        ];

        foreach ($settings as $s) {
            if (!DB::table('settings')->where('key', $s['key'])->exists()) {
                DB::table('settings')->insert(array_merge($s, ['created_at' => now(), 'updated_at' => now()]));
                $this->info("Inserted: {$s['key']}");
            } else {
                $this->info("Skipped: {$s['key']} (Exists)");
            }
        }
    }
}