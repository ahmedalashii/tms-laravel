<?php

namespace App\Http\Controllers\Trainee;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Traits\FirebaseStorageFileProcessing;
use App\Models\Trainee;
use Illuminate\Support\Facades\Session;
use PhpParser\Builder\Trait_;

class TraineeController extends Controller
{

    use FirebaseStorageFileProcessing;

    public function index()
    {
        return view('trainee.index');
    }

    public function upload()
    {
        return view('trainee.upload');
    }

    public function apply_for_training()
    {
        return view('trainee.apply_for_training');
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
        return view('trainee.edit');
    }

    public function update(Trainee $trainee)
    {
        $data = request()->validate([
            'displayName' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:trainees,email,' . $trainee->id,
            'phone' => 'required|string|max:255|unique:trainees,phone,' . $trainee->id,
            'address' => 'required|string|max:255',
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
            }
            $avatarImage = request()->file('avatar-image');
            // Using firebase storage to upload files and make a record for File in the database linked with the trainee
            $avatar_file_name = $trainee->id . '_trainee_avatar_image.' . $avatarImage->getClientOriginalExtension();
            $avatar_file_path = 'Trainee/Images/' . $avatar_file_name;
            $this->uploadFirebaseStorageFile($avatarImage, $avatar_file_path);
        }

        // Check before update firebase user if the email or phone number is used before and not by the same user
        $auth = app('firebase.auth');
        $firebaseUser = $auth->getUserByEmail($data['email']);
        if ($firebaseUser) {
            if ($firebaseUser->uid != $trainee->firebase_uid) {
                return redirect()->back()->with(['fail' => 'The email address is already in use by another account!', 'type' => 'error']);
            }
        }
        // Update firebase user
        $user = $auth->getUser($trainee->firebase_uid);
        $auth->updateUser($user->uid, [
            'email' => $data['email'],
            'displayName' => $data['displayName'],
        ]);
        $status = $trainee->update($data);
        return redirect()->back()->with([$status ? 'success' : 'fail' => $status ? 'Your Information has been updated successfully!' : 'Something is wrong!', 'type' => $status ? 'success' : 'error']);
    }
}
