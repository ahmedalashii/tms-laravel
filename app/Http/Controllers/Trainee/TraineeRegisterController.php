<?php

namespace App\Http\Controllers\Trainee;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use App\Providers\RouteServiceProvider;
use Illuminate\Support\Facades\Session;
use App\Http\Traits\FirebaseStorageFileProcessing;
use Illuminate\Foundation\Auth\RegistersUsers;
use Kreait\Firebase\Exception\FirebaseException;
use Kreait\Firebase\Contract\Auth as FirebaseAuth;
use App\Http\Requests\Trainee\TraineeRegistrationRequest;

class TraineeRegisterController extends Controller
{

    use RegistersUsers, FirebaseStorageFileProcessing;
    protected $auth;


    protected $redirectTo = RouteServiceProvider::TRAINEE_HOME;
    public function __construct(FirebaseAuth $auth)
    {
        $this->middleware('guest');
        $this->auth = $auth;
    }

    public function index()
    {
        return view('auth.trainee.register');
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\Models\User
     */
    public function register(TraineeRegistrationRequest $request)
    {
        try {
            $userProperties = [
                'email' => $request->input('email'),
                'emailVerified' => false,
                'password' => $request->input('password'),
                'displayName' => $request->input('name'),
                'disabled' => false,
            ];
            $createdUser = $this->auth->createUser($userProperties);
            // if the user already exists, then throw an exception
            if (!$createdUser) {
                Session::flash('error', 'User already exists');
                return back()->withInput();
            }
            $trainee = new \App\Models\Trainee;
            $trainee->displayName = $request->input('name');
            $trainee->phone = $request->input('phone');
            $trainee->address = $request->input('address');
            $trainee->gender = $request->input('gender');
            $trainee->email = $request->input('email');
            $trainee->password = Hash::make($request->input('password'));
            $trainee->firebase_uid = $createdUser->uid;
            $status = $trainee->save();
            $this->auth->sendEmailVerificationLink($request->input('email'));
            $avatarImage = $request->file('avatar-image');
            // Using firebase storage to upload files and make a record for File in the database linked with the trainee
            $avatar_file_name = $trainee->id . '_trainee_avatar_image.' . $avatarImage->getClientOriginalExtension();
            $avatar_file_path = 'Trainee/Images/' . $avatar_file_name;
            $this->uploadFirebaseStorageFile($avatarImage, $avatar_file_path);
            // Create a file record in the database
            $file = new \App\Models\File;
            $file->name = $avatar_file_name;
            $file->firebase_file_path = $avatar_file_path;
            $file->extension = $avatarImage->getClientOriginalExtension();
            $file->trainee_id = $trainee->id;
            $file->save();

            $cvFile = $request->file('cv-file');
            $cvFileName = $trainee->id . '_trainee_cv_file.' . $cvFile->getClientOriginalExtension();
            $cvFilePath = 'Trainee/CVs/' . $cvFileName;
            $this->uploadFirebaseStorageFile($cvFile, $cvFilePath);
            // Create a file record in the database
            $file = new \App\Models\File;
            $file->name = $cvFileName;
            $file->firebase_file_path = $cvFilePath;
            $file->extension = $cvFile->getClientOriginalExtension();
            $file->trainee_id = $trainee->id;
            $file->save();
            if ($status) {
                Session::flash('message', 'Trainee Created Successfully, Verify your email and please wait for approval from the manager to generate for you a unique ID that you will receive in your email to login with it.');
                return redirect()->route('trainee.login');
            } else {
                Session::flash('error', 'Failed to create trainee!');
                return back()->withInput();
            }
        } catch (FirebaseException $e) {
            Session::flash('error', $e->getMessage());
            return back()->withInput();
        }
    }
}