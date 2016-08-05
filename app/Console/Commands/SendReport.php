<?php

namespace App\Console\Commands;

use App\Http\Controllers\Agent\helpdesk\NotificationController;
use App\Http\Controllers\Common\PhpMailController;
use Exception;
use Illuminate\Console\Command;

class SendReport extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'report:send';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Sending the report mail ';
    protected $report;
    protected $mail;

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        $mail = new PhpMailController();
        $report = new NotificationController($mail);
        $this->report = $report;
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        try {
            $this->report->send_notification();
            \Log::info('Report has send');
            $this->info('Report has send');
        } catch (Exception $ex) {
            dd($ex);
            $this->error($ex->getMessage());
        }
    }
}
