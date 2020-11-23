<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class EventMemberAdded extends Mailable
{
    use Queueable, SerializesModels;

    public $userName;
    public $eventTitle;

    /**
     * Create a new message instance.
     *
     * @param string $name
     * @param string $title
     */
    public function __construct(string $name, string $title)
    {
        $this->userName = $name;
        $this->eventTitle = $title;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('email.user_registered');
    }
}
