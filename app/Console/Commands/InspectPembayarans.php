<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Schema;

class InspectPembayarans extends Command
{
    protected $signature = 'inspect:pembayarans';
    protected $description = 'Check columns';

    public function handle()
    {
        $cols = Schema::getColumnListing('pembayarans');
        $this->info(implode(', ', $cols));
    }
}