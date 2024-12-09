<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class ConsolidatedActionPlanNotification extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     */
    // public function __construct()
    // {
    //     //
    // }

    public function __construct($customMessage, $responsiblePersonEmail)
    {
        $this->customMessage = $customMessage;
        $this->responsiblePersonEmail = $responsiblePersonEmail;
    }


    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Consolidated Action Plan Notification',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'view.name',
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

    public function build()
    {
        return $this->from('nkaperemela@gmail.com') // Set the desired "from" email address
                    ->to($this->responsiblePersonEmail) // Set the recipient dynamically
                    ->view('send-email-notifications');
    }
}
