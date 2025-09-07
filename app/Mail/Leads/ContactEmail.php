<?php

namespace App\Mail\Leads;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class ContactEmail extends Mailable
{
    use Queueable, SerializesModels;

    public string $full_name;
    public string $email;
    public string $phone;
    public string $message;

    public function __construct(string $full_name, string $email, string $phone, string $message)
    {
        $this->full_name = $full_name;
        $this->email = $email;
        $this->phone = $phone;
        $this->message = $message;
    }

    public function build(): ContactEmail
    {
        return $this->subject('Novo Contato do Site')
            ->markdown('mail.leads.contact-email')
            ->with([
                'full_name' => $this->full_name,
                'email' => $this->email,
                'phone' => $this->phone,
                'message' => $this->message,
            ]);
    }

    public function attachments(): array
    {
        return [];
    }
}
