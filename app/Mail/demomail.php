<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class demomail extends Mailable
{
    use Queueable, SerializesModels;

    public $title;
    public $emailMessage;

    /**
     * Create a new message instance.
     *
     * @param string $title
     * @param string $message
     */
    public function __construct($title, $emailMessage)
    {
        $this->title = $title;
        $this->emailMessage = $emailMessage;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject($this->title)
                    ->view('emails.demo')
                    ->with([
                        'title' => $this->title,
                        'emailMessage' => $this->emailMessage,
                    ]);
    }
}
