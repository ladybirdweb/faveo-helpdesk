<?php

namespace App\Jobs;

use App\Http\Controllers\Common\PhpMailController;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class SendEmail implements ShouldQueue
{
    use InteractsWithQueue, SerializesModels;

    protected $from;
    protected $to;
    protected $message;
    protected $template;
    protected $thread;
    protected $auto_respond;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($from, $to, $message, $template_variables = '',$thread="",$auto_respond="")
    {
        $this->from = $from;
        $this->to = $to;
        $this->message = $message;
        $this->template = $template_variables;
        $this->thread = $thread;
        $this->auto_respond = $auto_respond;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle(PhpMailController $PhpMailController)
    {
        $p = $PhpMailController->sendEmail($this->from, $this->to, $this->message,$this->template,$this->thread,$this->auto_respond);
        return $p;
    }
}
