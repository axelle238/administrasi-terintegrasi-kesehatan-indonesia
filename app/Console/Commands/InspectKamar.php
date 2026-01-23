<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Schema;

class InspectKamar extends Command
{
    protected $signature = 'inspect:kamar';
    protected $description = 'Check columns';

    public function handle()
    {
        $cols = Schema::getColumnListing('kamars');
        $this->info(implode(', ', $cols));
    }
}