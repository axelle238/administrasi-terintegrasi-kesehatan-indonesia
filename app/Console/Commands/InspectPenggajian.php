<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Schema;

class InspectPenggajian extends Command
{
    protected $signature = 'inspect:penggajian';
    protected $description = 'Check columns';

    public function handle()
    {
        $cols = Schema::getColumnListing('penggajians');
        $this->info(implode(', ', $cols));
    }
}