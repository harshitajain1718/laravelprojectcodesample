<?php

namespace App\Listeners;

use App\Events\ResetPasswordLinkEvent;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Mail;
use Auth;
use App\User;

class ResetPasswordLinkEventListener
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  ResetPasswordLinkEvent  $event
     * @return void
     */
    public function handle(ResetPasswordLinkEvent $event)
    {
        $user = $event->userData;
        $data['fullName'] = $user['fullName'];
        $data['email']    = $user['email'];
        $data['link']      = $user['link'];
       
        Mail::send('emails.resetPasswordMailer',$data, function($message) use ($data) 
        {
            $message->subject('Taxiapp Team | Reset password link');
            $message->to($data['email']); 
        });
    }
}
