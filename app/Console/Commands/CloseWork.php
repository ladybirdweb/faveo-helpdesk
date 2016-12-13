<?php

namespace App\Console\Commands;

use App\Http\Controllers\Client\helpdesk\UnAuthController;
use Illuminate\Console\Command;

class CloseWork extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'ticket:close';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Ticket will close according to workflow';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        if (env('DB_INSTALL') == 1) {
            $PhpMailController = new \App\Http\Controllers\Common\PhpMailController();
            $controller = new UnAuthController($PhpMailController);
            $controller->autoCloseTickets();
            loging('ticket-close-workflow', 'Close ticket workflow executed', 'info');
            //\Log::info('Close ticket workflow executed');
            $this->info('Close ticket workflow executed');
        }
    }
}
