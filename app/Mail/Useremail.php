<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class Useremail extends Mailable
{
    use Queueable, SerializesModels;
    public $title;
    public $description;
    public $name;

    public function __construct($title, $description, $name)
    {
        $this->title = $title;
        $this->description = $description;
        $this->name = $name;
    }

    public function build()
    {
        return $this->subject($this->title)->view('emails.useremail');
    }
}
