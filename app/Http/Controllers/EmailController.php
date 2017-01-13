<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

use Mail;

class EmailController extends Controller
{
    public function test()
    $data = null;
    {
         Mail::send('emails.test.test', $data, function ($message) use ($attach)
        {
            $message->from('Alfred@Carrotpath.com', 'Alfred Garrett');
            $message->to('aggarret86@gmail.com');
            $message->subject("Hello from Scotch");
        });

       echo "Basic Email Sent. Check your inbox.";
    }
}
