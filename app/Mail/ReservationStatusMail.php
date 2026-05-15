<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ReservationStatusMail extends Mailable
{
    use Queueable, SerializesModels;

    public $reservation;
    public $messageText;

    public function __construct($reservation, $messageText)
    {
        $this->reservation = $reservation;
        $this->messageText = $messageText;
    }

    public function build()
    {
        return $this->subject('Estado de tu reserva')
            ->view('emails.reservation-status');
    }
}