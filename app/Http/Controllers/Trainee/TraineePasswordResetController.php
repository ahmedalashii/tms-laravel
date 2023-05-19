<?php

namespace App\Http\Controllers\Trainee;

use Illuminate\Support\Facades\Session;
use App\Models\Trainee;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Kreait\Firebase\Exception\FirebaseException;

class TraineePasswordResetController extends Controller
{

    public function index()
    {
        return view('auth.trainee.reset');
    }

    public function reset(Request $request)
    {
        $request->validate([
            "id" => "required|string|exists:trainees,auth_id",
        ]);
        try {
            $id = $request->id;
            $trainee = Trainee::where('auth_id', $id);
            if (!$trainee) {
                Session::flash('error', 'We couldn\'t find your account.');
                return back()->withInput();
            }  
            $email = $trainee->first()->email;
            app('firebase.auth')->sendPasswordResetLink($email);
            Session::flash('message', 'An email has been sent. Please check your inbox.');
            return back()->withInput();
        } catch (FirebaseException $e) {
            $error = str_replace('_', ' ', $e->getMessage());
            Session::flash('error', $error);
            return back()->withInput();
        }
    }
}
