<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Schema;

class InspectSettings extends Command
{
    protected $signature = 'inspect:settings';
    protected $description = 'Check columns';

    public function handle()
    {
        $cols = Schema::getColumnListing('settings');
        $this->info(implode(', ', $cols));
    }
}