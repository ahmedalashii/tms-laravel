<?php

namespace App\Http\Controllers\Advisor;

use App\Models\Advisor;
use App\Mail\ResetPasswordMail;
use App\Models\AdvisorDiscipline;
use App\Mail\EmailVerificationMail;
use App\Http\Controllers\Controller;
use App\Http\Traits\EmailProcessing;
use Illuminate\Support\Facades\Hash;
use App\Providers\RouteServiceProvider;
use Illuminate\Support\Facades\Session;
use Illuminate\Foundation\Auth\RegistersUsers;
use Kreait\Firebase\Exception\FirebaseException;
use App\Http\Traits\FirebaseStorageFileProcessing;
use Kreait\Firebase\Contract\Auth as FirebaseAuth;
use App\Http\Requests\Advisor\AdvisorRegistrationRequest;

class AdvisorRegisterController extends Controller
{
    use RegistersUsers, EmailProcessing, FirebaseStorageFileProcessing;
    protected $auth;

    protected $redirectTo = RouteServiceProvider::ADVISOR_HOME;

    public function __construct(FirebaseAuth $auth)
    {
        $this->middleware('guest');
        $this->auth = $auth;
    }

    public function index()
    {
        $disciplines = \App\Models\Discipline::withoutTrashed()->select('id', 'name')->get();
        return view('auth.advisor.register', compact('disciplines'));
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\Models\User
     */
    public function register(AdvisorRegistrationRequest $request)
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
            $email =  $request->input('email');
            $advisor = new Advisor;
            $advisor->firebase_uid = $createdUser->uid;
            $advisor->displayName = $request->input('name');
            $advisor->phone = $request->input('phone');
            $advisor->address = $request->input('address');
            $advisor->gender = $request->input('gender');
            $advisor->email = $email;
            $advisor->password = Hash::make($request->input('password'));
            $status = $advisor->save();
            // Advisor Discipline for each discipline selected
            $disciplines = $request->input('disciplines');
            foreach ($disciplines as $discipline) {
                $advisorDiscipline = new AdvisorDiscipline;
                $advisorDiscipline->advisor_id = $advisor->id;
                $advisorDiscipline->discipline_id = $discipline;
                $advisorDiscipline->save();
            }
            $verification_url = app('firebase.auth')->getEmailVerificationLink($email);
            $firebaseUser = app('firebase.auth')->getUserByEmail($email);
            $mailable = new EmailVerificationMail($firebaseUser, $verification_url);
            $this->sendEmail($email, $mailable);


            $avatarImage = $request->file('avatar-image');
            // Using firebase storage to upload files and make a record for File in the database linked with the advisor
            $avatar_file_name = $advisor->firebase_uid . '_advisor_avatar_image.' . $avatarImage->getClientOriginalExtension();
            // $oldReference = $this->getUploadedFirebaseFileReferenceByName($avatar_file_name);
            // if ($oldReference->exists()) {
            //     $oldReference->delete();
            // }
            $avatar_file_path = 'Advisor/Images/' . $avatar_file_name;
            $this->uploadFirebaseStorageFile($avatarImage, $avatar_file_path);
            // Create a file record in the database
            $file = new \App\Models\File;
            $file->name = $avatar_file_name;
            $file->firebase_file_path = $avatar_file_path;
            $file->extension = $avatarImage->getClientOriginalExtension();
            $file->advisor_id = $advisor->id;
            $file->description = 'Advisor Avatar Image';
            $size = $avatarImage->getSize();
            $file->size = $size ? $size : 0;
            $file->save();

            $cvFile = $request->file('cv-file');
            $cvFileName = $advisor->firebase_uid . '_advisor_cv_file.' . $cvFile->getClientOriginalExtension();
            $cvFilePath = 'Advisor/CVs/' . $cvFileName;
            $this->uploadFirebaseStorageFile($cvFile, $cvFilePath);
            // Create a file record in the database
            $file = new \App\Models\File;
            $file->name = $cvFileName;
            $file->firebase_file_path = $cvFilePath;
            $file->extension = $cvFile->getClientOriginalExtension();
            $file->advisor_id = $advisor->id;
            $file->description = 'Advisor CV File';
            $size = $cvFile->getSize();
            $file->size = $size ? $size : 0;
            $file->save();
            if ($status) {
                Session::flash('message', 'Advisor Created Successfully, Verify your email and please wait for approval from the manager to generate for you a unique ID that you will receive in your email to login with it.');
                return redirect()->route('advisor.login');
                // return redirect()->route('advisor.login')->with(['success' => 'Advisor Created Successfully, Verify your email and please wait for approval from the manager to generate for you a unique ID that you will receive in your email to login with it.', 'type' => 'success']);
            } else {
                Session::flash('error', 'Failed to create an advisor!');
                return back()->withInput();
            }
        } catch (FirebaseException $e) {
            Session::flash('error', $e->getMessage());
            return back()->withInput();
        }
    }
}
