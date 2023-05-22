<?php

namespace App\Http\Controllers;

use App\Models\Manager;
use App\Models\Trainee;
use App\Models\Discipline;
use Illuminate\Http\Request;
use App\Models\TrainingProgram;
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


    public function disciplines()
    {
        return view('manager.disciplines');
    }


    public function training_programs(Request $request)
    {
        // Get all training programs that their discipline is not soft deleted
        $paginate = 5;
        $discipline_id = $request->query('discipline');
        if ($discipline_id) {
            $training_programs = TrainingProgram::withTrashed()->where('discipline_id', $discipline_id)->paginate($paginate);
        } else {
            $training_programs = TrainingProgram::withTrashed()->paginate($paginate);
        }
        $disciplines = Discipline::select('id', 'name')->get();
        return view('manager.training_programs', compact('training_programs', 'disciplines'));
    }

    public function create_training_program()
    {
        $disciplines = \App\Models\Discipline::withoutTrashed()->select('id', 'name')->get();
        $duration_units = ['days' => 'Days', 'weeks' => 'Weeks', 'months' => 'Months', 'years' => 'Years'];
        return view('manager.create_training_program', compact('disciplines', 'duration_units'));
    }


    public function store_training_program(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'discipline_id' => 'required|exists:disciplines,id',
            'thumbnail' => 'required|image|mimes:jpeg,png,jpg,gif,svg',
            'description' => 'required|string|max:255',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after:start_date',
            'fees' => 'required|numeric|min:0',
            'duration' => 'required|numeric|min:0',
            'duration_unit' => 'required|in:days,weeks,months,years',
            'location' => 'required|string|max:255',
        ]);
        $trainingProgram = new TrainingProgram;
        $trainingProgram->name = $data['name'];
        $trainingProgram->discipline_id = $data['discipline_id'];
        $trainingProgram->description = $data['description'];
        $trainingProgram->start_date = $data['start_date'];
        $trainingProgram->end_date = $data['end_date'];
        $trainingProgram->fees = $data['fees'];
        $trainingProgram->duration = $data['duration'];
        $trainingProgram->duration_unit = $data['duration_unit'];
        $trainingProgram->location = $data['location'];
        $status = $trainingProgram->save();
        // Upload Thumbnail
        $thumbnailImage = $request->file('thumbnail');
        // Using firebase storage to upload files and make a record for File in the database linked with the TrainingProgram
        $thumbnail_file_name = $data['name'] . '_' . time() . '.' . $thumbnailImage->getClientOriginalExtension();
        $thumbnail_file_path = 'TrainingProgram/Thumbnails/' . $thumbnail_file_name;
        $this->uploadFirebaseStorageFile($thumbnailImage, $thumbnail_file_path);
        // Create a file record in the database
        $file = new \App\Models\File;
        $file->name = $thumbnail_file_name;
        $file->firebase_file_path = $thumbnail_file_path;
        $file->extension = $thumbnailImage->getClientOriginalExtension();
        $file->training_program_id = $trainingProgram->id;
        $file->description = 'Thumbnail for ' . $trainingProgram->name;
        $size = $thumbnailImage->getSize();
        $file->size = $size ? $size : 0;
        $file->save();
        return redirect()->back()->with([$status ? 'success' : 'fail' => $status ? 'Training Program Created Successfully' : 'Something is wrong!', 'type' => $status ? 'success' : 'error']);
    }


    public function edit_training_program(TrainingProgram $trainingProgram)
    {
        return view('manager.edit_training_program', compact('trainingProgram'));
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


    public function deactivate_training_program(TrainingProgram $trainingProgram)
    {
        $destroy = $trainingProgram->delete();
        return redirect()->back()->with([$destroy ? 'success' : 'fail' => $destroy ?  'Training Program Deactivated Successfully' : 'Something is wrong!', 'type' => $destroy ? 'success' : 'error']);
    }


    public function activate_training_program($id)
    {
        $status = TrainingProgram::onlyTrashed()->find($id)->restore();
        return redirect()->back()->with([$status ? 'success' : 'fail' => $status ? 'Training Program Activated Successfully' : 'Something is wrong!', 'type' => $status ? 'success' : 'error']);
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
