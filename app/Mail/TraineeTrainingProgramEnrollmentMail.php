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
    public ?float $payment = null;
    /**
     * Create a new message instance.
     */
    public function __construct($trainee, $trainingProgram, ?float $payment = null)
    {
        $this->trainee = $trainee;
        $this->trainingProgram = $trainingProgram;
        $this->payment = $payment;
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
                "payment" => $this->payment,
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
