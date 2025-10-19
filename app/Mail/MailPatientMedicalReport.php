<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class MailPatientMedicalReport extends Mailable
{
    use Queueable, SerializesModels;

    protected $mcu;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($mcu)
    {
        $this->mcu = $mcu;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('mail.patient-mcu', ['mcu' => $this->mcu])
                    ->from('admin@emcu.id')
                    ->subject('Hasil MCU');
    }
}
