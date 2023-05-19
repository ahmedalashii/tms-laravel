<?php

namespace App\Http\Traits;

use App\Mail\TraineeAuthorizationMail;
use Illuminate\Mail\Mailable;
use Illuminate\Support\Facades\Mail;

trait EmailProcessing
{
    public function sendEmail($trainee, Mailable $mailable)
    {
        $status = Mail::to($trainee->email)->send($mailable);
        if ($status) {
            return true;
        } else {
            return false;
        }
    }
}
