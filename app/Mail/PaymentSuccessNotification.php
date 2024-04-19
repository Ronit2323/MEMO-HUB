<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class PaymentSuccessNotification extends Mailable
{
    use Queueable, SerializesModels;
    public $payment;

    public function __construct($payment)
    {
        $this->payment = $payment;
    }

    public function build()
    {
        return $this->subject('Payment Successful')
                    ->view('emails.payment_success_notification');
    }

    /**
     * Create a new message instance.
     */
    

    /**
     * Get the attachments for the message.
     *
      \Illuminate\Mail\Mailables\Attachment>
     */
  
}
