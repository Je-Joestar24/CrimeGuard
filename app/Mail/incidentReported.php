<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use App\Models\User;
use App\Models\Incidents;
use Carbon\Carbon;

class IncidentReported extends Mailable
{
    use Queueable, SerializesModels;

    public $user;
    public $incident;
    public $formattedTime;

    /**
     * Create a new message instance.
     */
    public function __construct(User $user, Incidents $incident)
    {
        $this->user = $user;
        $this->incident = $incident;
        
        // Format the time
        $this->formattedTime = Carbon::parse($incident->time_reported)->format('h:i A');
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Incident Report Confirmation',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'emails.incident-report',
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array<int, \Illuminate\Mail\Mailables\Attachment>
     */
    public function attachments(): array
    {
        return [];
    }
}
