<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;

class InstallCommand extends Command
{
    protected $signature = 'shop:install';

    protected $description = 'Installation';

    public function handle(): int
    {
        Storage::makeDirectory('images');

        $this->call('storage:link');
        $this->call('migrate');

        return self::SUCCESS;
    }
}
