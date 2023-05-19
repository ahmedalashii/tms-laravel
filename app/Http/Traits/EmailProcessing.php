<?php

namespace App\Http\Traits;

use Illuminate\Mail\Mailable;
use Illuminate\Support\Facades\Mail;

trait EmailProcessing
{
    public function sendEmail($trainee, Mailable $mailable)
    {
         Mail::to($trainee->email)->send($mailable);
    }
}
