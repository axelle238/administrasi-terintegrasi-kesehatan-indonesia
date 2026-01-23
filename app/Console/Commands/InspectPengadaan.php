<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Schema;

class InspectPengadaan extends Command
{
    protected $signature = 'inspect:pengadaan';
    protected $description = 'Check columns';

    public function handle()
    {
        if (Schema::hasTable('pengadaan_barangs')) {
            $cols = Schema::getColumnListing('pengadaan_barangs');
            $this->info(implode(', ', $cols));
        } else {
            $this->error('Table pengadaan_barangs not found');
        }
    }
}