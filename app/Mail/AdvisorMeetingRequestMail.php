<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class AdvisorMeetingRequestMail extends Mailable
{
    use Queueable, SerializesModels;


    public $advisor;
    public $trainee;
    public $meeting;
    /**
     * Create a new message instance.
     */
    public function __construct($advisor, $trainee, $meeting)
    {
        $this->advisor = $advisor;
        $this->trainee = $trainee;
        $this->meeting = $meeting;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        $app_name = config('app.name');
        return new Envelope(
            subject: "Trainee " . $this->trainee->displayName . " has requested a meeting with you on " . $this->meeting->date . " at " . $this->meeting->time,
         );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            markdown: 'emails.advisor_meeting_request',
            with: [
                'advisor' => $this->advisor,
                'trainee' => $this->trainee,
                'meeting' => $this->meeting,
            ],
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