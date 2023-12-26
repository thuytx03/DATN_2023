<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class SeatSelected implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $userId;
    public $selectedSeats;
    public $showtime_id;
    public $action;

    public function __construct($userId, $selectedSeats, $showtime_id, $action)
    {
        $this->userId = $userId;
        $this->selectedSeats = $selectedSeats;
        $this->showtime_id = $showtime_id;
        $this->action = $action; // Set the action property

    }

    public function broadcastOn()
    {
        return new Channel('seat-selected-channel');
    }

    public function broadcastAs()
    {
        return 'seat-selected';
    }

    public function broadcastWith()
    {
        return [
            'userId' => $this->userId,
            'selectedSeats' => $this->selectedSeats,
            'showtime_id' => $this->showtime_id,
            'action' => $this->action, // Include the action in the broadcast data
        ];
    }
}
