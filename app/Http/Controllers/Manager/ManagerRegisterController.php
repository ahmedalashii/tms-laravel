<?php

namespace App\Http\Controllers\Manager;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use App\Providers\RouteServiceProvider;
use Illuminate\Support\Facades\Session;
use Illuminate\Foundation\Auth\RegistersUsers;
use Kreait\Firebase\Exception\FirebaseException;
use Kreait\Firebase\Contract\Auth as FirebaseAuth;
use App\Http\Requests\Manager\ManagerRegistrationRequest;

class ManagerRegisterController extends Controller
{
    use RegistersUsers;
    protected $auth;


    protected $redirectTo = RouteServiceProvider::MANAGER_HOME;
    public function __construct(FirebaseAuth $auth)
    {
        $this->middleware('guest');
        $this->auth = $auth;
    }

    public function index()
    {
        return view('auth.manager.register');
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\Models\User
     */
    public function register(ManagerRegistrationRequest $request)
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
            $manager = new \App\Models\Manager;
            $manager->firebase_uid = $createdUser->uid;
            $manager->displayName = $request->input('name');
            $manager->email = $request->input('email');
            $manager->phone = $request->input('phone');
            $manager->address = $request->input('address');
            $manager->role = 'manager';
            $manager->password = Hash::make($request->input('password'));
            $status = $manager->save();
            $this->auth->sendEmailVerificationLink($request->input('email'));
            if ($status) {
                Session::flash('message', 'Manager Created Successfully, Verify your email and wait for the super manager to activate your account.');
                return redirect()->route('manager.login');
                // return redirect()->route('manager.login')->with(['success' => 'Manager Created Successfully, Verify your email to login.', 'type' => 'success']);
            } else {
                Session::flash('error', 'Failed to create a manager!');
                return back()->withInput();
            }
        } catch (FirebaseException $e) {
            Session::flash('error', $e->getMessage());
            return back()->withInput();
        }
    }
}
