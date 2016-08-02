<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Http\Controllers\Client\helpdesk\UnAuthController;

class CloseWork extends Command {

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
    protected $controller;

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct(UnAuthController $controller) {
        $this->controller = $controller;
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle() {
        if (env('DB_INSTALL') === 1) {
            $this->controller->autoCloseTickets();
            \Log::useDailyFiles(storage_path() . "/logs/info/ticket-close.log");
            \Log::info('Close ticket workflow executed');
            $this->info('Close ticket workflow executed');
        }
    }

}
