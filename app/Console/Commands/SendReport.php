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
        try {
            if (env('DB_INSTALL') == 1) {
                $mail = new PhpMailController();
                $mail->setQueue();
                $this_report = new NotificationController($mail);
                $report = $this_report->send_notification();

                if ($report !== 0) {
                    loging('sending-mail-report', 'Report has send', 'info');
                    //\Log::info("Report has send");
                    $this->info('Report has send');
                } else {
                    loging('sending-mail-report', 'Nothing to send', 'info');
                    $this->info('Nothing to send');
                }
            }
        } catch (Exception $ex) {
            //dd($ex);
            $this->error($ex->getMessage());
        }
    }
}
