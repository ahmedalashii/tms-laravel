<?php

namespace App\Http\Controllers\Advisor;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Session;
use Kreait\Firebase\Exception\FirebaseException;

class AdvisorPasswordResetController extends Controller
{
    public function index()
    {
        return view('auth.advisor.reset');
    }

    public function reset(Request $request)
    {
        $request->validate([
            "email" => "required|string|email|exists:advisors,email",
        ]);
        try {
            app('firebase.auth')->sendPasswordResetLink($request->email);
            Session::flash('message', 'An email has been sent. Please check your inbox.');
            return back()->withInput();
        } catch (FirebaseException $e) {
            $error = str_replace('_', ' ', $e->getMessage());
            Session::flash('error', $error);
            return back()->withInput();
        }
    }
}
