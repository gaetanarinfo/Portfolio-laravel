<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use Illuminate\Mail\Mailables\Address;

class OrderApps extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Elements de contact
     * @var array
     */
    public $orders;
    public $projet;
    public $from_mail;
    public $from_name;
    public $sujet;

    /**
     * Create a new message instance.
     */
    public function __construct(object $orders, object $projet, string $from_mail, string $from_name, string $sujet)
    {
        $this->orders = $orders;
        $this->projet = $projet;
        $this->from_mail = $from_mail;
        $this->from_name = $from_name;
        $this->sujet = $sujet;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            from: new Address($this->from_mail, $this->from_name),
            subject: $this->sujet,
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'emails.order_apps',
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
