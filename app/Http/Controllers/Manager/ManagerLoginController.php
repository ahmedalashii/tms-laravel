<?php

namespace App\Http\Controllers\Manager;

use App\Models\Manager;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Providers\RouteServiceProvider;
use Illuminate\Validation\ValidationException;
use Kreait\Firebase\Exception\FirebaseException;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Kreait\Firebase\Contract\Auth as FirebaseAuth;
use Illuminate\Support\Facades\Session;

class ManagerLoginController extends Controller
{

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $auth;
    protected $redirectTo = RouteServiceProvider::MANAGER_HOME;

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
        return view('auth.manager.login');
    }

    public function login(Request $request)
    {
        try {
            $request->validate([
                "email" => "required|string|email|exists:managers,email",
                "password" => "required|string|min:8",
            ]);
            $manager = Manager::where('email', $request->email);
            if (!$manager) {
                info("Manager not found.");
                Session::flash('error', 'Manager not found.');
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
                $auth->sendEmailVerificationLink($request->input('email'));
                return back()->withInput();
            }
            $user = Manager::where('firebase_uid', $firebaseId)->first();
            if (!$user) {
                Session::flash('error', 'Manager not found.');
                return back()->withInput();
            }
            if ($user->is_active == false) {
                Session::flash('error', 'Your account is not active. Wait for the super manager to activate your account.');
                return back()->withInput();
            }
            // Logout from other guards
            Auth::guard("advisor")->logout();
            Auth::guard("trainee")->logout();
            // uid Session
            Session::put('uid', $firebaseId);
            Session::forget('guard');
            Session::put('guard', 'manager');
            // Login to this guard
            Auth::guard("manager")->login($user);
            $result = Auth::guard("manager")->check();
            if (!$result) {
                Session::flash('error', 'Authentication failed.');
                return back()->withInput();
            }
            return redirect($this->redirectPath())->with(['success' => 'Welcome back!', 'type' => 'success']);
        } catch (FirebaseException $e) {
            throw ValidationException::withMessages([
                $this->username() => [trans("auth.failed")],
            ]);
        }
    }

    public function managerLogout(Request $request)
    {
        Auth::guard("manager")->logout();
        Session::forget('uid');
        Session::forget('guard');
        $this->logout($request);
        return redirect()->route('manager.login')->with(['success' => 'Logout successfully.', 'type' => 'success']);
    }
}
