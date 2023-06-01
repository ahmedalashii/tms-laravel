<?php

namespace App\Http\Controllers\Trainee;

use App\Models\Trainee;
use App\Models\TraineeDiscipline;
use App\Mail\EmailVerificationMail;
use App\Http\Controllers\Controller;
use App\Http\Traits\EmailProcessing;
use Illuminate\Support\Facades\Hash;
use App\Providers\RouteServiceProvider;
use Illuminate\Support\Facades\Session;
use App\Notifications\ManagerNotification;
use Illuminate\Foundation\Auth\RegistersUsers;
use Kreait\Firebase\Exception\FirebaseException;
use App\Http\Traits\FirebaseStorageFileProcessing;
use Kreait\Firebase\Contract\Auth as FirebaseAuth;
use App\Http\Requests\Trainee\TraineeRegistrationRequest;

class TraineeRegisterController extends Controller
{

    use RegistersUsers, FirebaseStorageFileProcessing, EmailProcessing;
    protected $auth;


    protected $redirectTo = RouteServiceProvider::TRAINEE_HOME;
    public function __construct(FirebaseAuth $auth)
    {
        $this->middleware('guest');
        $this->auth = $auth;
    }

    public function index()
    {
        $disciplines = \App\Models\Discipline::withoutTrashed()->select('id', 'name')->get();
        return view('auth.trainee.register', compact('disciplines'));
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
            $email  = $request->input('email');
            $trainee = new Trainee;
            $trainee->displayName = $request->input('name');
            $trainee->phone = $request->input('phone');
            $trainee->address = $request->input('address');
            $trainee->gender = $request->input('gender');
            $trainee->email =   $email;
            $trainee->password = Hash::make($request->input('password'));
            $trainee->firebase_uid = $createdUser->uid;
            $status = $trainee->save();
            // Trainee Discipline for each discipline selected
            $disciplines = $request->input('disciplines');
            foreach ($disciplines as $discipline) {
                $traineeDiscipline = new TraineeDiscipline;
                $traineeDiscipline->trainee_id = $trainee->id;
                $traineeDiscipline->discipline_id = $discipline;
                $traineeDiscipline->save();
            }
            $verification_url = app('firebase.auth')->getEmailVerificationLink($email);
            $firebaseUser = app('firebase.auth')->getUserByEmail($email);
            $mailable = new EmailVerificationMail($firebaseUser, $verification_url);
            $this->sendEmail($email, $mailable);
            $avatarImage = $request->file('avatar-image');
            // Using firebase storage to upload files and make a record for File in the database linked with the trainee
            $avatar_file_name = $trainee->firebase_uid . '_trainee_avatar_image.' . $avatarImage->getClientOriginalExtension();
            // $oldReference = $this->getUploadedFirebaseFileReferenceByName($avatar_file_name);
            // if ($oldReference->exists()) {
            //     $oldReference->delete();
            // }
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

            $cvFile = $request->file('cv-file');
            $cvFileName = $trainee->firebase_uid . '_trainee_cv_file.' . $cvFile->getClientOriginalExtension();
            $cvFilePath = 'Trainee/CVs/' . $cvFileName;
            $this->uploadFirebaseStorageFile($cvFile, $cvFilePath);
            // Create a file record in the database
            $file = new \App\Models\File;
            $file->name = $cvFileName;
            $file->firebase_file_path = $cvFilePath;
            $file->extension = $cvFile->getClientOriginalExtension();
            $file->trainee_id = $trainee->id;
            $file->description = 'Trainee CV File';
            $size = $cvFile->getSize();
            $file->size = $size ? $size : 0;
            $file->save();

            // // Store data to firebase firestore
            // $firestore = app('firebase.firestore');
            // $trainee_firestore = $firestore->database()->collection('trainees')->document($trainee->firebase_uid)->set($trainee->toArray());
            // // disciplines of the trainee
            // $traineeDisciplines = $firestore->database()->collection('trainee_disciplines')->document($trainee->firebase_uid);
            // $traineeDisciplines->set([
            //     'disciplines' => $disciplines,
            // ]);
            if ($status) {
                $message = "New Trainee Created: " . $trainee->displayName . " with email: " . $trainee->email . ". Go to Authorize Trainees to approve or reject.";
                // send notification to all managers
                $managers = \App\Models\Manager::all();
                foreach ($managers as $manager) {
                    $manager->notify(new ManagerNotification(null, null, $message));
                }
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
