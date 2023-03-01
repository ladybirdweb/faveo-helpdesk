<?php

namespace App\Console\Commands;

use App\Http\Controllers\Update\SyncFaveoToLatestVersion;
use Illuminate\Console\Command;

class Sync extends Command
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
    protected $description = 'Migration and Database seeder';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        (new SyncFaveoToLatestVersion())->sync();

        return Command::SUCCESS;
    }
}
