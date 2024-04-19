<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class ContactFormMail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     */
    public $name;
    public $email;
    public $Contactmessage;

    /**
     * Create a new message instance.
     *
     *
     * @param string $Contactmessage
     */

    public function __construct($name, $email, $Contactmessage )
    {
        $this->name = $name;
        $this->email = $email;
        $this->Contactmessage =$Contactmessage;
    }

    public function build()
    {
        return $this->subject('Contact Form Submission')
            ->view('emails.contact')
            ->with([
                'name' => $this->name,
                'email' => $this->email,
                'Contactmessage' => $this->Contactmessage,
            ]);
    }

    /**
     * Get the message envelope.
     */


    /**
     * Get the message content definition.
     */


    /**
     * Get the attachments for the message.
     *
    \Illuminate\Mail\Mailables\Attachment>
     */
}
