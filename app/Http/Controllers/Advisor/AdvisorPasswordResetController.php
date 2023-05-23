<?php

namespace App\Http\Controllers\Advisor;

use App\Models\Advisor;
use Illuminate\Http\Request;
use App\Mail\ResetPasswordMail;
use App\Http\Controllers\Controller;
use App\Http\Traits\EmailProcessing;
use Illuminate\Support\Facades\Session;
use Kreait\Firebase\Exception\FirebaseException;

class AdvisorPasswordResetController extends Controller
{

    use EmailProcessing;

    public function index()
    {
        return view('auth.advisor.reset');
    }

    public function reset(Request $request)
    {
        $request->validate([
            "id" => "required|string|exists:advisors,auth_id",
        ]);
        try {
            $id = $request->id;
            $advisor = Advisor::withTrashed()->where('auth_id', $id);
            if (!$advisor) {
                Session::flash('error', 'We couldn\'t find your account.');
                return back()->withInput();
            }  
            $email = $advisor->first()->email;
            $resetting_url = app('firebase.auth')->getPasswordResetLink($email);
            $firebaseUser = app('firebase.auth')->getUserByEmail($email);
            $mailable = new ResetPasswordMail($firebaseUser, $resetting_url);
            $this->sendEmail($email, $mailable);
            Session::flash('message', 'An email has been sent. Please check your inbox.');
            return back()->withInput();
        } catch (FirebaseException $e) {
            $error = str_replace('_', ' ', $e->getMessage());
            Session::flash('error', $error);
            return back()->withInput();
        }
    }
}
