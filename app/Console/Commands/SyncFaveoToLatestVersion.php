<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class SyncFaveoToLatestVersion extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'database:sync';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Database sync';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $this->info('database:sync started');
        (new \App\Http\Controllers\Update\SyncFaveoToLatestVersion())->sync();
        $this->info('database:sync completed');
    }
}
