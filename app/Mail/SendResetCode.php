<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class SendResetCode extends Mailable
{
    use Queueable, SerializesModels;

    public $token;

    public function __construct($token)
    {
        $this->token = $token;  // Pass the token to the Mailable
    }

    public function build()
    {
        return $this->subject('Your Password Reset Code')
                    ->view('emails.reset_code') // Use a Blade template for the email
                    ->with([
                        'token' => $this->token,
                    ]);
    }
}
