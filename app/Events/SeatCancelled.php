<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class SeatCancelled implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $userId;
    public $cancelledSeats;
    public $showtime_id;
    public $action; 

    public function __construct($userId, $cancelledSeats, $showtime_id, $action)
    {
        $this->userId = $userId;
        $this->cancelledSeats = $cancelledSeats;
        $this->showtime_id = $showtime_id;
        $this->action = $action; // Set the action property

    }

    public function broadcastOn()
    {
        return new Channel('seat-cancelled-channel');
    }

    public function broadcastAs()
    {
        return 'seat-cancelled';
    }

    public function broadcastWith()
    {
        return [
            'userId' => $this->userId,
            'cancelledSeats' => $this->cancelledSeats,
            'showtime_id' => $this->showtime_id,
            'action' => $this->action,
        ];
    }
}
