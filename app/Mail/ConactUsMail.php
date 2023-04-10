<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ConactUsMail extends Mailable
{
    use Queueable, SerializesModels;

    public $data = null;

    public function __construct($data)
    {
        $this->data = $data;
    }

    public function build()
    {
        return $this->view('site page.dynamic page.contact.mail');
    }
}
