<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class AdvisorTraineeMail extends Mailable
{
    use Queueable, SerializesModels;


    public $advisor;
    public $trainee;
    public $subject;
    public $message;
    /**
     * Create a new message instance.
     */
    public function __construct($advisor, $trainee, $subject, $message)
    {
        $this->advisor = $advisor;
        $this->trainee = $trainee;
        $this->subject = $subject;
        $this->message = $message;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        $app_name = config('app.name');
        return new Envelope(
            subject:  $this->subject,
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            markdown: 'emails.advisor_trainee',
            with: [
                'advisor' => $this->advisor,
                'trainee' => $this->trainee,
                'subject' => $this->subject,
                'message' => $this->message,
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