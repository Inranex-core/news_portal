<?php

namespace App\Mail;

use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class JournalistInvitationMail extends Mailable
{
    use Queueable, SerializesModels;

    public User $user;
    public string $inviteUrl;

    /**
     * Create a new message instance.
     */
    public function __construct(User $user, string $inviteUrl)
    {
        $this->user = $user;
        $this->inviteUrl = $inviteUrl;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Official Invitation to Join as Journalist - ' . config('app.name'),
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'emails.journalist_invitation',
        );
    }
}
