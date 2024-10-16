<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class SetupDev extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'setup:dev';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Configure dev environment';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Configuring cache for filament icons...');
        $this->call('icons:cache');

        $this->info('Running migrations...');
        $this->call('migrate:fresh');

        $this->info('Running seeders...');
        $this->call('db:seed');
    }
}
