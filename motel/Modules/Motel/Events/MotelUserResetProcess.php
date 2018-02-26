<?php

namespace Modules\Motel\Events;

use Illuminate\Queue\SerializesModels;

class MotelUserResetProcess
{
    use SerializesModels;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public $user;
    public $code;
    
    public function __construct($user, $code)
    {
        $this->user = $user;
        $this->code = $code;
    }

    /**
     * Get the channels the event should be broadcast on.
     *
     * @return array
     */
    public function broadcastOn()
    {
        return [];
    }
}
