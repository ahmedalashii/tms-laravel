<?php

namespace App\Http\Traits;

use Illuminate\Mail\Mailable;
use Illuminate\Support\Facades\Mail;

trait EmailProcessing
{
    public function sendEmail($email, Mailable $mailable)
    {
         Mail::to($email)->send($mailable);
    }
}
