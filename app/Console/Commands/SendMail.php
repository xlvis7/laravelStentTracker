<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use DB;

class SendMail extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'send:reminderMail';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send reminder mail to stent expired user';

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
        try{
            $list = DB::table('users')
            ->join('students', 'users.user_id', '=', 'students.user_id')
            ->join('seru_courses', 'students.courses', '=', 'seru_courses.no')
            ->select('users.email', 'users.first_name', 'users.last_name', 'seru_courses.Programmes')
            ->where('seru_courses.Date', '=', '31-12-2020')
            ->get();
            // change '31-12-2020' to date("Y-m-d") on deployment
            
            foreach ( $list as $obj){
                $mailer
                ->to($obj->email)
                ->send(new \App\Mail\MyMail('Stent Expiry Reminder', $obj));
            }
        } catch (Exception $e) {
            report($e);
            info($e);
            Log::debug($e);
        }
    }
}
