<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

class SendsPasswordResetEmails extends Mailable
{
    use Queueable, SerializesModels;

    private $tokenResetPassword;
    private $receiverName;
    private $receiverEmail;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(string $tokenResetPassword, string $receiverName, string $receiverEmail)
    {
        $this->tokenResetPassword = $tokenResetPassword;
        $this->receiverName = $receiverName;
        $this->receiverEmail = $receiverEmail;
    }

    /**
     * Get the message envelope.
     *
     * @return \Illuminate\Mail\Mailables\Envelope
     */
    public function envelope()
    {
        return new Envelope(
            subject: 'Password Reset Emails',
        );
    }

    /**
     * Get the message content definition.
     *
     * @return \Illuminate\Mail\Mailables\Content
     */
    public function content()
    {
        $resetLink = "https://iitc.intermediaamikom.org/reset-password?token=" . $this->tokenResetPassword . "&email=" . $this->receiverEmail;
        return new Content(
            view: 'mails.send_password_reset_email',
            with: [
                'resetLink' => $resetLink,
                'name' => $this->receiverName,
            ],
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array
     */
    public function attachments()
    {
        return [];
    }
}
