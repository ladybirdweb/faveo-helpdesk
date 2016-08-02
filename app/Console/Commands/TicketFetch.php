<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Http\Controllers\Agent\helpdesk\MailController;

class TicketFetch extends Command {

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'ticket:fetch';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Fetching the tickets from service provider';
    protected $controller;

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct(MailController $controller) {
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
            $emails = new \App\Model\helpdesk\Email\Emails();
            $settings_email = new \App\Model\helpdesk\Settings\Email();
            $system = new \App\Model\helpdesk\Settings\System();
            $ticket = new \App\Model\helpdesk\Settings\Ticket();
            $this->controller->readmails($emails, $settings_email, $system, $ticket);
            \Log::useDailyFiles(storage_path() . "/logs/info/ticket-fetch.log");
            \Log::info('Ticket has read');
            $this->info('Ticket has read');
        }
    }

}
