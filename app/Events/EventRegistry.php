<?php

namespace App\Events;

use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class EventRegistry
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $name;
    public $phone;
    public $mail;
    public $event;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct($name, $phone, $mail, $event)
    {
        $this->name = $name;
        $this->phone = $phone;
        $this->mail = $mail;
        $this->event = $event;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        return new PrivateChannel('channel-name');
    }
}
