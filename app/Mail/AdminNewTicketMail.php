<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class AdminNewTicketMail extends Mailable
{
    use Queueable, SerializesModels;
    public $data;

    /**
     * Create a new message instance.
     */
    public function __construct($data)
    {
        $this->data = $data;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        if($this->data['ticket_type']==1){
            return new Envelope(
                subject: 'Ticket ID: '.$this->data['ticket_id'].' | New Remote Service Ticket Created',
            );
        }
        if($this->data['ticket_type']==2){
            return new Envelope(
                subject: 'Ticket ID: '.$this->data['ticket_id'].' | New Installation and Commissioning Ticket Created',
            );
        }
        if($this->data['ticket_type']==3){
            return new Envelope(
                subject: 'Ticket ID: '.$this->data['ticket_id'].' | New Field Service Ticket Created',
            );
        }
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'emails.admin.new_ticket',
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
