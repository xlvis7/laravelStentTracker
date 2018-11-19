<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class SendVerificationEmail extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'send:verificationMail {--email=} {--host=}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send Verification Mail to New User';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle(\Illuminate\Mail\Mailer $mailer)
    {
        $email = $this->option('email');
        $host = $this->option('host');
        try{
            $mailer
            ->to($email)
            ->send(new \App\Mail\VerificationMail($host, 'Stent Tracker Email Verification', $email));

        } catch (Exception $e) {
            report($e);
            info($e);
            Log::debug($e);
        }
    }
}
