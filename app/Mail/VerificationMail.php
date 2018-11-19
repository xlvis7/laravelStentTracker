<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

use DB;

class VerificationMail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public $title;
    public $fname = 'first';
    public $lname = 'last';
    public $activationUrl = 'default_key';

    public function __construct($host, $title, $email)
    {
        $this->title = $title;
        // $this->fname = $register_data['first_name'];
        // $this->lname = $register_data['last_name'];
        // $this->activationKey = $_SERVER['SERVER_NAME'] + "/testing.php";

        $user = DB::table('users')->where('email', $email)->first();
        $regDate = $user->Registration_DateTime;

        $keyUnhashed = $email . $regDate;

        $keyHashed = md5( $keyUnhashed);

        $this->activationUrl = "$host/emailVerification.php?email=$email&activationKey=$keyHashed";
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
        ->view('email.emailVerification');
    }
}