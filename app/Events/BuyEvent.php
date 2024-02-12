<?php

namespace App\Events;

use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class BuyEvent
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $purchase;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct($user, $purchase)
    {
        $this->user = $user;
        $this->purchase = $purchase;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        return new PrivateChannel('buy-event-channel');
    }
}
