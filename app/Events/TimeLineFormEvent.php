<?php

namespace App\Events;

use Illuminate\Queue\SerializesModels;

class TimeLineFormEvent extends Event
{
    use SerializesModels;

    public $para1;

    public $para2;

    public $para3;

    public $para4;

    public $para5;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct($para1 = '', $para2 = '', $para3 = '', $para4 = '', $para5 = '')
    {
        $this->para1 = $para1;
        $this->para2 = $para2;
        $this->para3 = $para3;
        $this->para4 = $para4;
        $this->para5 = $para5;
    }
}
