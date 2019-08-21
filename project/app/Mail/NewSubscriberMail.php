<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class NewSubscriberMail extends Mailable
{
    use Queueable, SerializesModels;
    private $email;

    /**
     * Create a new message instance.
     *
     * @param $data
     */
    public function __construct($email)
    {
        $this->email = $email;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('subscribers::emails.new_subscriber')->with(['email' => $this->email]);
    }
}
