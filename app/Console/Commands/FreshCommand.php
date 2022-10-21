<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;

class FreshCommand extends Command
{
    protected $signature = 'shop:fresh';

    protected $description = 'Fresh database and seeds';

    public function handle()
    {
        if (app()->isProduction()) {
            return Command::FAILURE;
        }

        Storage::deleteDirectory('products');
        Storage::deleteDirectory('brands');

        $this->call('migrate:fresh', ['--seed' => true]);
    }
}
