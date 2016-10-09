<?php

namespace App\Console\Commands;
use App\Http\Controllers\Common\PhpMailController;
use Illuminate\Console\Command;
use App\Http\Controllers\Client\helpdesk\UnAuthController;

class FollowUp extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'users:followup';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';
    protected $controller;

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
         // $this->controller = $controller;
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        //
          if (env('DB_INSTALL') == 1) {
            $phpmail= new PhpMailController();
           
            $controller = new UnAuthController($phpmail);
            $controller->followup();

            // \Log::useDailyFiles(storage_path() . "/logs/info/ticket-close.log");
            \Log::info('FollowUp ticket followup executed');
            $this->info('FollowUp ticket followup executed');
        }
    }
}
