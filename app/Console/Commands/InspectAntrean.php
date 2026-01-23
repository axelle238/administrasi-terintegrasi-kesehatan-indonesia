<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Schema;

class InspectAntrean extends Command
{
    protected $signature = 'inspect:antrean';
    protected $description = 'Check columns';

    public function handle()
    {
        $cols = Schema::getColumnListing('antreans');
        $this->info(implode(', ', $cols));
    }
}