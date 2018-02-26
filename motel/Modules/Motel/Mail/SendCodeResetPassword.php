<?php

namespace Modules\Motel\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;
use Modules\User\Entities\UserInterface;

class SendCodeResetPassword extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    protected $array;
    /**
     * @var UserInterface
     */
    public $user;

    /**
     * @var
     */
    public $code;

    public function __construct($array,UserInterface $user, $code)
    {
        $this->array = $array;
        $this->user = $user;
        $this->code = $code;

    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->from(env('MAIL_FROM_ADDRESS'), env('MAIL_FROM_NAME'))
            ->subject(trans($this->array['subject']))
            ->view("fxchange::sentmail.mailtransaction",$this->array);
    }
