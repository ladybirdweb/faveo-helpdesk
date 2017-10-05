<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class WorkFlowEvent
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $options;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct($event)
    {
        $this->options = $event;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return Channel|array
     */
    public function broadcastOn()
    {
        return new PrivateChannel('channel-name');
    }
}
