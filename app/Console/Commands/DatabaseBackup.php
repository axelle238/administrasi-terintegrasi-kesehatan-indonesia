<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class DatabaseBackup extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'database:backup';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Backup database ke format JSON (Portable)';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Memulai proses backup...');

        $tables = DB::connection()->getDoctrineSchemaManager()->listTableNames();
        $backupData = [];

        foreach ($tables as $table) {
            $this->line("Backing up table: $table");
            $data = DB::table($table)->get()->toArray();
            $backupData[$table] = $data;
        }

        $filename = 'backup-' . date('Y-m-d-His') . '.json';
        Storage::put('backups/' . $filename, json_encode($backupData, JSON_PRETTY_PRINT));

        $this->info("Backup berhasil disimpan: storage/app/backups/$filename");
    }
}