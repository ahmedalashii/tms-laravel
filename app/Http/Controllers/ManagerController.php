<?php

namespace App\Http\Controllers;

use App\Models\Trainee;
use App\Http\Traits\EmailProcessing;
use Illuminate\Support\Facades\Auth;
use App\Mail\TraineeAuthorizationMail;
use App\Http\Traits\FirebaseStorageFileProcessing;

class ManagerController extends Controller
{
    use FirebaseStorageFileProcessing, EmailProcessing;

    public function index()
    {
        return view('manager.index');
    }

    public function training_requests()
    {
        return view('manager.training_requests');
    }

    public function authorize_trainees()
    {
        $paginate = 5;
        $trainees = Trainee::withoutTrashed()->whereNull('auth_id')->paginate($paginate);
        return view('manager.authorize_trainees', compact('trainees'));
    }


    public function authorize_trainee(Trainee $trainee)
    {
        // Unique Generated ID for the trainee (auth_id) that will be used to login to the system and never taken before
        $auth_id = uniqid();
        while (Trainee::where('auth_id', $auth_id)->exists()) {
            $auth_id = uniqid();
        }
        // Send Email to the trainee with the auth_id
        $trainee->auth_id = $auth_id;
        $manager = Auth::guard('manager')->user();
        $mailable = new TraineeAuthorizationMail($trainee, $manager);
        $this->sendEmail($trainee, $mailable);
        $status = $trainee->save();
        return redirect()->back()->with([$status ? 'success' : 'fail' => $status ? 'Trainee Authorized Successfully and email sent!' : 'Something is wrong!', 'type' => $status ? 'success' : 'error']);
    }


    public function verify_trainee(Trainee $trainee){
        $auth = app('firebase.auth');
        $auth->sendEmailVerificationLink($trainee->email);
        return redirect()->back()->with(['success' => 'Email Verification Link Sent Successfully!', 'type' => 'success']);
    }

    public function trainees()
    {
        $paginate = 5;
        $trainees = Trainee::paginate($paginate);
        return view('manager.trainees', compact('trainees'));
    }

    public function issues()
    {
        return view('manager.issues');
    }

    public function issue_response()
    {
        return view('manager.issue_response');
    }

    public function edit_trainee(Trainee $trainee)
    {
        return view('manager.edit_trainee');
    }

    public function update_trainee(Trainee $trainee)
    {
    }
}
