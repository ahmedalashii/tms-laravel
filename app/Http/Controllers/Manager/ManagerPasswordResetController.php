<?php

namespace App\Http\Controllers\Manager;

use App\Models\Manager;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Traits\EmailProcessing;
use App\Mail\ResetPasswordMail;
use Kreait\Firebase\Exception\FirebaseException;
use Illuminate\Support\Facades\Session;

class ManagerPasswordResetController extends Controller
{
    use EmailProcessing;

    public function index()
    {
        return view('auth.manager.reset');
    }

    public function reset(Request $request)
    {
        $request->validate([
            "email" => "required|string|email|exists:managers,email",
        ]);
        try {
            $resetting_url = app('firebase.auth')->getPasswordResetLink($request->email);
            $email = $request->email;
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
