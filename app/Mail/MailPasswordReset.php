<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class MailPasswordReset extends Mailable
{
    use Queueable, SerializesModels;

    public $token;
    public $notifiable;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($token, $notifiable)
    {
        $this->token = $token;
        $this->notifiable = $notifiable;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {

        return $this->view('mail.password-reset', [
            'token' => $this->token,
            'notifiable' => $this->notifiable
        ])
        ->subject('Reset Password')
        ->from('admin@emcu.id');
    }
}
