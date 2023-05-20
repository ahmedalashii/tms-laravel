<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class ManagerActivationMail extends Mailable
{
    use Queueable, SerializesModels;


    public $manager;
    /**
     * Create a new message instance.
     */
    public function __construct($manager)
    {
        $this->manager = $manager;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        $app_name = config('app.name');
        return new Envelope(
            subject: "You can now manage $app_name",
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            markdown: 'emails.manager_activation',
            with: [
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