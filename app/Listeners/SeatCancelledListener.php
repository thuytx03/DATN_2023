<?php

namespace App\Listeners;

use App\Events\SeatCancelled;
use App\Events\SeatSelected;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class SeatCancelledListener implements ShouldQueue
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  object  $event
     * @return void
     */
    public function handle(SeatCancelled $event)
    {
        //
    }
}
