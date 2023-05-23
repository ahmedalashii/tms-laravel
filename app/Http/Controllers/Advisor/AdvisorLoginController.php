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
                "id" => "required|string|exists:advisors,auth_id",
                "password" => "required|string|min:8",
            ]);

            $advisor = Advisor::withTrashed()->where('auth_id', $request->id);
            if (!$advisor) {
                Session::flash('error', 'Email not found.');
                return back()->withInput();
            }
            $email = $advisor?->first()?->email;

            $auth = app("firebase.auth");
            $signInResult = $auth->signInWithEmailAndPassword(
                $email,
                $request["password"]
            );
            $firebaseId = $signInResult->firebaseUserId();
            $firebaseUser = $auth->getUser($firebaseId);
            if ($firebaseUser->emailVerified == false) {
                Session::flash('error', 'Your email is not verified. We have sent you a new verification email.');
                $verification_url = app('firebase.auth')->getEmailVerificationLink($email);
                $firebaseUser = app('firebase.auth')->getUserByEmail($email);
                $mailable = new EmailVerificationMail($firebaseUser, $verification_url);
                $this->sendEmail($email, $mailable);
                return back()->withInput();
            }
            $user = Advisor::withTrashed()->where('firebase_uid', $firebaseId)->first();
            if (!$user) {
                throw ValidationException::withMessages([
                    $this->username() => [trans("auth.failed")],
                ]);
            }
            if ($user->trashed()) {
                Session::flash('error', 'Your account has been deactivated by the manager.');
                return back()->withInput();
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
