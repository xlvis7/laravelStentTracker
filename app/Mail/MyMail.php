<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class MyMail extends Mailable
{
    use Queueable, SerializesModels;

    public $title;
    public $fname;
    public $lname;
    public $programme;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($title, $obj)
    {
        $this->title = $title;
        $this->fname = $obj->first_name;
        $this->lname = $obj->last_name;
        $this->programme = $obj->Programmes;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->from('Admin@StentTracker.um')
        ->subject($this->title)
        ->view('email.mymail');
    }
}
