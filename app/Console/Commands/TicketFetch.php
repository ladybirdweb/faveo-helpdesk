<?php

namespace App\Console\Commands;

use App\Http\Controllers\Agent\helpdesk\MailController;
use App\Http\Controllers\Agent\helpdesk\TicketWorkflowController;
use Illuminate\Console\Command;

class TicketFetch extends Command
{
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
        if (isInstall()) {
            $controller = $this->mailController();
            $emails = new \App\Model\helpdesk\Email\Emails();
            $settings_email = new \App\Model\helpdesk\Settings\Email();
            $system = new \App\Model\helpdesk\Settings\System();
            $ticket = new \App\Model\helpdesk\Settings\Ticket();
            $controller->readmails($emails, $settings_email, $system, $ticket);
            event('ticket.fetch', ['event' => '']);
            loging('fetching-ticket', 'Ticket has read', 'info');
            //\Log::info('Ticket has read');
            $this->info('Ticket has read');
        }
    }

    public function mailController()
    {
        $PhpMailController = new \App\Http\Controllers\Common\PhpMailController();
        $NotificationController = new \App\Http\Controllers\Common\NotificationController();
        $ticket = new \App\Http\Controllers\Agent\helpdesk\TicketController($PhpMailController, $NotificationController);
        $work = new TicketWorkflowController($ticket);
        $controller = new MailController($work);

        return $controller;
    }
}
