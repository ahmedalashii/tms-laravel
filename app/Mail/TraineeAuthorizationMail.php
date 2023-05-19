<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Address;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class TraineeAuthorizationMail extends Mailable
{
    use Queueable, SerializesModels;


    public $trainee;
    public $manager;
    /**
     * Create a new message instance.
     */
    public function __construct($trainee, $manager)
    {
        $this->trainee = $trainee;
        $this->manager = $manager;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        $app_name = config('app.name');
        return new Envelope(
            subject: "Your $app_name Account is Ready to Use",
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            markdown: 'emails.trainee_authorization',
            with: [
                'trainee' => $this->trainee,
                'manager' => $this->manager,
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