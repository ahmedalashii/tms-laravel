<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class TraineeTrainingProgramEnrollmentMail extends Mailable
{
    use Queueable, SerializesModels;

    public $trainee;
    public $trainingProgram;
    /**
     * Create a new message instance.
     */
    public function __construct($trainee, $trainingProgram)
    {
        $this->trainee = $trainee;
        $this->trainingProgram = $trainingProgram;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        $app_name = config('app.name');
        return new Envelope(
            subject: "You sent a request to enroll in a training program on $app_name",
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            markdown: 'emails.trainee_training_program_enrollment',
            with: [
                'trainee' => $this->trainee,
                "trainingProgram" => $this->trainingProgram,
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
