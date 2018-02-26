<?php

namespace Modules\Motel\Events\Handlers;

use Modules\Motel\Events\MotelUserResetProcess;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Modules\Motel\Mail\SendCodeResetPassword;
use Mail;

class MotelSendResetCodeEmail
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
     * @param \Modules\Motel\Events\MotelUserResetProcess $event
     * @return void
     */
    public function handle(\Modules\Motel\Events\MotelUserResetProcess $event)
    {
        $arr_data = [
                        'subject'            => 'Motel',
                    ];
        Mail::to($event->user->email)->send(new SendCodeResetPassword($arr_data,$event->user, $event->code));
    }
}
