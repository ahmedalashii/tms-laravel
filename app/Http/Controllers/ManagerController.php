<?php

namespace App\Http\Controllers;

use App\Models\Manager;
use App\Models\Trainee;
use App\Http\Traits\EmailProcessing;
use Illuminate\Support\Facades\Auth;
use App\Mail\TraineeAuthorizationMail;
use App\Http\Traits\FirebaseStorageFileProcessing;
use App\Mail\ManagerActivationMail;

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
        $this->sendEmail($trainee->email, $mailable);
        $status = $trainee->save();
        return redirect()->back()->with([$status ? 'success' : 'fail' => $status ? 'Trainee Authorized Successfully and an email has been sent!' : 'Something is wrong!', 'type' => $status ? 'success' : 'error']);
    }


    public function activate_manager(Manager $manager)
    {
        $manager->is_active = true;
        $status = $manager->save();
        $mailable = new ManagerActivationMail($manager);
        $this->sendEmail($manager->email, $mailable);
        return redirect()->back()->with([$status ? 'success' : 'fail' => $status ? 'Manager Activated Successfully and an email has been sent!' : 'Something is wrong!', 'type' => $status ? 'success' : 'error']);
    }


    public function deactivate_manager(Manager $manager)
    {
        $manager->is_active = false;
        $status = $manager->save();
        return redirect()->back()->with([$status ? 'success' : 'fail' => $status ? 'Manager Deactivated Successfully!' : 'Something is wrong!', 'type' => $status ? 'success' : 'error']);
    }

    public function verify_trainee(Trainee $trainee)
    {
        $auth = app('firebase.auth');
        $auth->sendEmailVerificationLink($trainee->email);
        return redirect()->back()->with(['success' => 'Email Verification Link Sent Successfully!', 'type' => 'success']);
    }


    public function deactivate_trainee(Trainee $trainee)
    {
        /*
            Soft Delete:
            deleted_at >> timestamp >> null
            when deleting the row >> deleted_at = current timestamp 
        */
        $destroy = $trainee->delete();
        return redirect()->back()->with([$destroy ? 'success' : 'fail' => $destroy ?  'Trainee Deactivated Successfully' : 'Something is wrong!', 'type' => $destroy ? 'success' : 'error']);
    }

    public function activate_trainee($id)
    {
        $status = Trainee::onlyTrashed()->find($id)->restore();
        return redirect()->back()->with([$status ? 'success' : 'fail' => $status ? 'Trainee Activated Successfully' : 'Something is wrong!', 'type' => $status ? 'success' : 'error']);
    }

    public function trainees()
    {
        $paginate = 5;
        $trainees = Trainee::withTrashed()->paginate($paginate);
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

    public function managers()
    {
        $manager = Auth::guard('manager')->user();
        $manager_db = Manager::where('firebase_uid', $manager->localId)->first();
        if ($manager_db->role == 'super_manager') {
            // Managers that are not super managers except the current logged in manager
            $managers = Manager::where('role', '!=', 'super_manager')->where('firebase_uid', '!=', $manager->localId)->get();
            return view('manager.managers', compact('managers'));
        }
        return redirect()->back()->with(['fail' => 'You are not authorized to access this page!', 'type' => 'error']);
    }
}
