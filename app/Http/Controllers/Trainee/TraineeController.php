<?php

namespace App\Http\Controllers\Trainee;

use App\Models\Trainee;
use Illuminate\Http\Request;
use PhpParser\Builder\Trait_;
use App\Notifications\TraineeNotification;
use App\Models\TrainingProgram;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use App\Http\Traits\FirebaseStorageFileProcessing;

class TraineeController extends Controller
{

    use FirebaseStorageFileProcessing;

    public function index()
    {

        $trainee_db = auth_trainee();
        $message = 'Welcome ' . $trainee_db->displayName . ' To your dashboard';
        $trainee_db->notify(new TraineeNotification(null, $message));
        $notifications = $trainee_db->notifications()->latest()->take(5)->get();
        return view('trainee.index', compact('notifications'));
    }

    public function upload()
    {
        $trainee = Auth::guard('trainee')->user();
        $trainee_db = Trainee::where('firebase_uid', $trainee->localId)->first();
        $paginate = 3;
        $files = $trainee_db->files()->paginate($paginate);
        return view('trainee.upload', compact('files'));
    }


    public function available_training_programs()
    {
        $paginate = 3;
        $firebaseTrainee = Auth::guard('trainee')->user();
        $trainee = Trainee::where('firebase_uid', $firebaseTrainee->localId)->first();
        $training_programs = \App\Models\TrainingProgram::withoutTrashed()->whereIn('discipline_id', $trainee->disciplines->pluck('id'))->where('start_date', '>', date('Y-m-d'))->where('capacity', '>', 0)->whereDoesntHave('training_program_users', function ($query) use ($trainee) {
            $query->where('trainee_id', $trainee->id);
        })->whereHas('training_program_users', function ($query) {
            $query->havingRaw('count(*) < capacity');
        })->whereNotNull('advisor_id')->paginate($paginate);
        return view('trainee.available_training_programs', compact('training_programs'));
    }


    public function apply_training_program(TrainingProgram $trainingProgram)
    {
        $firebaseTrainee = Auth::guard('trainee')->user();
        $trainee = Trainee::where('firebase_uid', $firebaseTrainee->localId)->first();
        $training_program_user = $trainingProgram->training_program_users()->create([
            'trainee_id' => $trainee->id,
            'training_program_id' => $trainingProgram->id,
            'advisor_id' => $trainingProgram->advisor_id,
        ]);
        if ($training_program_user) {
            return redirect()->back()->with(['success' => 'Your request has been sent successfully!', 'type' => 'success']);
        } else {
            return redirect()->back()->with(['fail' => 'Something is wrong!', 'type' => 'error']);
        }
    }

    public function training_attendance()
    {
        return view('trainee.training_attendance');
    }

    public function request_meeting()
    {
        return view('trainee.request_meeting');
    }

    public function edit()
    {
        $disciplines = \App\Models\Discipline::withoutTrashed()->select('id', 'name')->get();
        return view('trainee.edit', compact('disciplines'));
    }

    public function update(Trainee $trainee)
    {
        $data = request()->validate([
            'displayName' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:trainees,email,' . $trainee->id,
            'phone' => 'required|string|max:255|unique:trainees,phone,' . $trainee->id,
            'address' => 'required|string|max:255',
            'disciplines' => 'required|array|min:1',
            'avatar-image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg',
            'cv-file' => 'nullable|mimes:pdf,doc,docx,txt,rtf,odt,ods,odp,odg,odc,odb,xls,xlsx,ppt,pptx',
        ]);

        // Check if the user uploaded a new avatar image
        if (request()->hasFile('avatar-image')) {
            // Delete the old avatar image from firebase storage
            if ($trainee->avatar) {
                $reference = app('firebase.storage')->getBucket()->object($trainee->avatar);
                if ($reference->exists()) {
                    $reference->delete();
                }
                $trainee->avatar_file->delete();
            }
            $avatarImage = request()->file('avatar-image');
            // Using firebase storage to upload files and make a record for File in the database linked with the trainee
            $avatar_file_name = $trainee->firebase_uid . '_trainee_avatar_image.' . $avatarImage->getClientOriginalExtension();
            $avatar_file_path = 'Trainee/Images/' . $avatar_file_name;
            $this->uploadFirebaseStorageFile($avatarImage, $avatar_file_path);

            // Create a file record in the database
            $file = new \App\Models\File;
            $file->name = $avatar_file_name;
            $file->firebase_file_path = $avatar_file_path;
            $file->extension = $avatarImage->getClientOriginalExtension();
            $file->trainee_id = $trainee->id;
            $file->description = 'Trainee Avatar Image';
            $size = $avatarImage->getSize();
            $file->size = $size ? $size : 0;
            $file->save();
        }

        // cv-file
        // Check if the user uploaded a new cv file
        if (request()->hasFile('cv-file')) {
            // Delete the old cv file from firebase storage
            if ($trainee->cv) {
                $reference = app('firebase.storage')->getBucket()->object($trainee->cv);
                if ($reference->exists()) {
                    $reference->delete();
                }
                $trainee->cv_file->delete();
            }
            $cvFile = request()->file('cv-file');
            // Using firebase storage to upload files and make a record for File in the database linked with the trainee
            $cv_file_name = $trainee->firebase_uid . '_trainee_cv_file.' . $cvFile->getClientOriginalExtension();
            $cv_file_path = 'Trainee/CVs/' . $cv_file_name;
            $this->uploadFirebaseStorageFile($cvFile, $cv_file_path);

            // Create a file record in the database
            $file = new \App\Models\File;
            $file->name = $cv_file_name;
            $file->firebase_file_path = $cv_file_path;
            $file->extension = $cvFile->getClientOriginalExtension();
            $file->trainee_id = $trainee->id;
            $file->description = 'Trainee CV File';
            $size = $cvFile->getSize();
            $file->size = $size ? $size : 0;
            $file->save();
        }


        // Check the disciplines selected by the user and remove the old disciplines and add the new ones
        $disciplines = $data['disciplines'];
        $trainee->disciplines()->detach();
        foreach ($disciplines as $discipline) {
            $trainee->disciplines()->attach($discipline);
        }

        // Check before update firebase user if the email or phone number is used before and not by the same user
        $auth = app('firebase.auth');
        try {
            $firebaseUser = $auth->getUserByEmail($data['email']);
            if ($firebaseUser->uid != $trainee->firebase_uid) {
                return redirect()->back()->with(['fail' => 'The email address is already in use by another account!', 'type' => 'error']);
            }
            // Update firebase user
            $user = $auth->getUser($trainee->firebase_uid);
            $auth->updateUser($user->uid, [
                'email' => $data['email'],
                'displayName' => $data['displayName'],
            ]);
            $trainee->email = $data['email'];
            $trainee->displayName = $data['displayName'];
            $trainee->phone = $data['phone'];
            $trainee->address = $data['address'];
            $status = $trainee->update($data);
            return redirect()->back()->with([$status ? 'success' : 'fail' => $status ? 'Your Information has been updated successfully!' : 'Something is wrong!', 'type' => $status ? 'success' : 'error']);
        } catch (\Throwable $th) { // If the email is not used before then the getUserByEmail will throw an exception
            // Do nothing
            return redirect()->back()->with(['fail' => $th->getMessage(), 'type' => 'error']);
        }
    }
}
