<?php

namespace App\Http\Controllers;

use App\Models\Manager;
use App\Models\Trainee;
use Illuminate\Http\Request;
use App\Mail\ManagerActivationMail;
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

    public function authorize_trainees(Request $request)
    {
        $search_value = $request->search;
        $paginate = 5;
        $trainees = Trainee::withoutTrashed()->whereNull('auth_id')->where(function ($query) use ($search_value) {
            $query->where('displayName', 'LIKE', '%' . $search_value . '%')
                ->orWhere('email', 'LIKE', '%' . $search_value . '%')
                ->orWhere('phone', 'LIKE', '%' . $search_value . '%')
                ->orWhere('address', 'LIKE', '%' . $search_value . '%');
        })->paginate($paginate);
        return view('manager.authorize_trainees', compact('trainees'));
    }

    public function trainees(Request $request)
    {
        $search_value = $request->search;
        $paginate = 5;
        $trainees = Trainee::withTrashed()->where(function ($query) use ($search_value) {
            $query->where('displayName', 'LIKE', '%' . $search_value . '%')
                ->orWhere('email', 'LIKE', '%' . $search_value . '%')
                ->orWhere('phone', 'LIKE', '%' . $search_value . '%')
                ->orWhere('address', 'LIKE', '%' . $search_value . '%');
        })->paginate($paginate);
        return view('manager.trainees', compact('trainees'));
    }


    public function managers(Request $request)
    {
        $manager = Auth::guard('manager')->user();
        $manager_db = Manager::where('firebase_uid', $manager->localId)->first();
        if ($manager_db->role == 'super_manager') {
            // Managers that are not super managers except the current logged in manager
            $search_value = $request->search;
            $paginate = 5;
            $managers = Manager::where('role', '!=', 'super_manager')->where('firebase_uid', '!=', $manager->localId)->where(function ($query) use ($search_value) {
                $query->where('displayName', 'LIKE', '%' . $search_value . '%')
                    ->orWhere('email', 'LIKE', '%' . $search_value . '%')
                    ->orWhere('phone', 'LIKE', '%' . $search_value . '%')
                    ->orWhere('address', 'LIKE', '%' . $search_value . '%');
            })->paginate($paginate);
            return view('manager.managers', compact('managers'));
        }
        return redirect()->back()->with(['fail' => 'You are not authorized to access this page!', 'type' => 'error']);
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
        return view('manager.edit_trainee ', compact('trainee'));
    }

    public function update_trainee(Trainee $trainee)
    {
        $data = request()->validate([
            'displayName' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:trainees,email,' . $trainee->id,
            'phone' => 'required|string|max:255|unique:trainees,phone,' . $trainee->id,
            'address' => 'required|string|max:255',
        ]);
        // Check before update firebase user if the email or phone number is used before and not by the same user
        $auth = app('firebase.auth');
        $firebaseUser = $auth->getUserByEmail($trainee->email);
        if ($firebaseUser) {
            if ($firebaseUser->uid != $trainee->firebase_uid) {
                return redirect()->back()->with(['fail' => 'Email or Phone Number is already taken!', 'type' => 'error']);
            }
        }
        // Update firebase user
        $user = $auth->getUser($trainee->firebase_uid);
        $auth->updateUser($user->uid, [
            'email' => $data['email'],
            'displayName' => $data['displayName'],
        ]);
        $status = $trainee->update($data);
        return redirect()->back()->with([$status ? 'success' : 'fail' => $status ? 'Trainee Updated Successfully' : 'Something is wrong!', 'type' => $status ? 'success' : 'error']);
    }
}
