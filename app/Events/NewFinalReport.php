<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

// class NewFinalReport
// {
//     use Dispatchable, InteractsWithSockets, SerializesModels;

//     /**
//      * Create a new event instance.
//      */
//     public function __construct()
//     {
//         //
//     }

//     /**
//      * Get the channels the event should broadcast on.
//      *
//      * @return array<int, \Illuminate\Broadcasting\Channel>
//      */
//     public function broadcastOn(): array
//     {
//         return [
//             new PrivateChannel('channel-name'),
//         ];
//     }
// }

class NewFinalReport implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $newFinalReport;

    public function __construct($newFinalReport)
    {
        $this->newFinalReport = $newFinalReport;
    }

    public function broadcastOn(): Channel
    {
        return new Channel('new-final-report');
    }
}
