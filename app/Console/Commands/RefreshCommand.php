<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;

class RefreshCommand extends Command
{
    protected $signature = 'shop:refresh';

    protected $description = 'Refresh database and seeds';

    public function handle()
    {
        if (app()->isProduction()) {
            return Command::FAILURE;
        }

        $this->call('cache:clear');

        Storage::deleteDirectory('images');

        Storage::makeDirectory('images');

        $this->call('migrate:fresh', ['--seed' => true]);
    }
}
