<?php

namespace App\Http\Controllers\Advisor;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Illuminate\Foundation\Auth\RegistersUsers;
use Kreait\Firebase\Exception\FirebaseException;
use Kreait\Firebase\Contract\Auth as FirebaseAuth;
use App\Http\Requests\Advisor\AdvisorRegistrationRequest;

class AdvisorRegisterController extends Controller
{
    use RegistersUsers;
    protected $auth;


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
            $advisor = new \App\Models\Advisor;
            $advisor->firebase_uid = $createdUser->uid;
            $advisor->displayName = $request->input('name');
            $advisor->email = $request->input('email');
            $advisor->password = Hash::make($request->input('password'));
            $status = $advisor->save();
            $this->auth->sendEmailVerificationLink($request->input('email'));
            // Advisor Discipline for each discipline selected
            $disciplines = $request->input('disciplines');
            foreach ($disciplines as $discipline) {
                $advisorDiscipline = new \App\Models\AdvisorDiscipline;
                $advisorDiscipline->advisor_id = $advisor->id;
                $advisorDiscipline->discipline_id = $discipline;
                $advisorDiscipline->save();
            }
            if ($status) {
                Session::flash('message', 'Advisor Created Successfully, Verify your email to login.');
                return redirect()->route('advisor.login');
                // return redirect()->route('advisor.login')->with(['success' => 'Advisor Created Successfully, Verify your email to login.', 'type' => 'success']);
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
