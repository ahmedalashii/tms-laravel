<?php

namespace App\Http\Controllers\Advisor;

use App\Models\Advisor;
use Illuminate\Http\Request;
use App\Mail\EmailVerificationMail;
use App\Http\Controllers\Controller;
use App\Http\Traits\EmailProcessing;
use Illuminate\Support\Facades\Auth;
use App\Providers\RouteServiceProvider;
use Illuminate\Support\Facades\Session;
use Illuminate\Validation\ValidationException;
use Kreait\Firebase\Exception\FirebaseException;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Kreait\Firebase\Contract\Auth as FirebaseAuth;

class AdvisorLoginController extends Controller
{
    use AuthenticatesUsers, EmailProcessing;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $auth;
    protected $redirectTo = RouteServiceProvider::ADVISOR_HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(FirebaseAuth $auth)
    {
        $this->middleware("guest")->except("logout");
        $this->auth = app("firebase.auth");
    }

    public function index()
    {
        return view('auth.advisor.login');
    }

    public function login(Request $request)
    {
        try {
            $request->validate([
                "email" => "required|string|email|exists:advisors,email",
                "password" => "required|string|min:8",
            ]);
            $advisor = Advisor::where('email', $request->email);
            if (!$advisor) {
                Session::flash('error', 'Advisor not found.');
                return back()->withInput();
            }
            $auth = app("firebase.auth");
            $signInResult = $auth->signInWithEmailAndPassword(
                $request["email"],
                $request["password"]
            );
            $firebaseId = $signInResult->firebaseUserId();
            $firebaseUser = $auth->getUser($firebaseId);
            if ($firebaseUser->emailVerified == false) {
                Session::flash('error', 'Your email is not verified. We have sent you a new verification email.');
                $verification_url = app('firebase.auth')->getEmailVerificationLink($request->email);
                $firebaseUser = app('firebase.auth')->getUserByEmail($request->email);
                $mailable = new EmailVerificationMail($firebaseUser, $verification_url);
                $this->sendEmail($request->email, $mailable);
                return back()->withInput();
            }
            $user = Advisor::where('firebase_uid', $firebaseId)->first();
            if (!$user) {
                throw ValidationException::withMessages([
                    $this->username() => [trans("auth.failed")],
                ]);
            }
            // Logout from other guards
            Auth::guard("manager")->logout();
            Auth::guard("trainee")->logout();
            // uid Session
            Session::put('uid', $firebaseId);
            Session::forget('guard');
            Session::put('guard', 'advisor');
            // Login to advisor guard
            $result = Auth::guard("advisor")->login($user, $request->remember);
            return redirect($this->redirectPath())->with(['success' => 'Welcome back!', 'type' => 'success']);
        } catch (FirebaseException $e) {
            throw ValidationException::withMessages([
                $this->username() => [trans("auth.failed")],
            ]);
        }
    }


    public function advisorLogout(Request $request)
    {
        Auth::guard("advisor")->logout();
        Session::forget('uid');
        Session::forget('guard');
        $this->logout($request);
        return redirect()->route('advisor.login')->with(['success' => 'Logout successfully.', 'type' => 'success']);
    }
}
