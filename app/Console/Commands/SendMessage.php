<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class SendMessage extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'message:send';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

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
        $handler = new \App\Plugins\SMS\Controllers\Scheduler\SendScheduledMessageController();
        $handle = $handler->sendScheduledMessage();
        if ($handle['status']) {
            \Log::info('Send message executed');
            $this->info('Send message executed and messages are sent successfully');
        } else {
            if (is_array($handle['reason'])) {
                $message = "Following error occuerd during sending scheduled messages \"".lcfirst($handle['reason'][0]['reason'])."\" and \"".lcfirst($handle['reason'][1]['reason'])."\"";
            } else {
                $message = "Following error occuerd during sending message: \"".lcfirst($handle['reason']."\"");
            }
            \Log::info($message);
            $this->info($message);
        }
    }
}
