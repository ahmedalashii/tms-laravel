<?php

namespace App\Http\Controllers\Trainee;

use App\Models\Trainee;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Kreait\Firebase\Contract\Auth as FirebaseAuth;
use App\Providers\RouteServiceProvider;
use Hamcrest\Core\Set;
use Illuminate\Validation\ValidationException;
use Kreait\Firebase\Exception\FirebaseException;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\Session;

class TraineeLoginController extends Controller
{
    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $auth;
    protected $redirectTo = RouteServiceProvider::TRAINEE_HOME;

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
        return view('auth.trainee.login');
    }


    public function login(Request $request)
    {
        try {
            $request->validate([
                "id" => "required|string|exists:trainees,auth_id",
                "password" => "required|string|min:8",
            ]);
            $trainee = Trainee::where('auth_id', $request->id);
            if (!$trainee) {
                Session::flash('error', 'Email not found.');
                return back()->withInput();
            }
            $email = $trainee?->first()?->email;
            $auth = app("firebase.auth");
            $signInResult = $auth->signInWithEmailAndPassword(
                $email,
                $request["password"]
            );
            $firebaseId = $signInResult->firebaseUserId();
            $firebaseUser = $auth->getUser($firebaseId);
            if ($firebaseUser->emailVerified == false) {
                Session::flash('error', 'Your email is not verified. We have sent you a new verification email.');
                $auth->sendEmailVerificationLink($email);
                return back()->withInput();
            }
            $user = Trainee::where('firebase_uid', $firebaseId)->first();
            if (!$user) {
                throw ValidationException::withMessages([
                    $this->username() => [trans("auth.failed")],
                ]);
            }
            // Logout from other guards
            Auth::guard('advisor')->logout();
            Auth::guard('manager')->logout();
            // uid Session
            Session::put('uid', $firebaseId);
            Session::forget('guard');
            Session::put('guard', 'trainee');
            // Login to this guard
            $result = Auth::guard("trainee")->login($user, $request->remember);
            return redirect($this->redirectPath())->with(['success' => 'Welcome back!', 'type' => 'success']);
        } catch (FirebaseException $e) {
            throw ValidationException::withMessages([
                $this->username() => [trans("auth.failed")],
            ]);
        }
    }

    public function traineeLogout(Request $request)
    {
        Auth::guard("trainee")->logout();
        Session::forget('uid');
        Session::forget('guard');
        $this->logout($request);
        return redirect()->route('trainee.login')->with(['success' => 'Logout successfully.', 'type' => 'success']);
    }
}
