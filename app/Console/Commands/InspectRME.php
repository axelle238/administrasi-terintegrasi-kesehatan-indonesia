<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Schema;

class InspectRME extends Command
{
    protected $signature = 'inspect:rme';
    protected $description = 'Check columns';

    public function handle()
    {
        $cols = Schema::getColumnListing('rekam_medis');
        $this->info(implode(', ', $cols));
    }
}