<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

use Mail;

class SendEmails extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'emails:send';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send test email to mailgun account';

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
    public function handle()
    {
        Mail::send('emails.test.test', [] , function ($message)
        {
            $message->from('Alfred@Carrotpath.com', 'Alfred Garrett');
            $message->to('aggarret86@gmail.com');
            $message->subject("Hello from Scotch");
        });

       echo "Basic Email Sent. Check your inbox.";
    }
}
