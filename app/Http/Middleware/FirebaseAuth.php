<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Symfony\Component\HttpFoundation\Response;

class FirebaseAuth
{
  /**
   * Handle an incoming request.
   *
   * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
   */
  public function handle(Request $request, Closure $next, ...$guards): Response
  {
    $uid = Session::get('uid');
    $session_guard = Session::get('guard');
    $guard = $guards[0];
    if ($uid) {
      $verify = app('firebase.auth')->getUser($uid)->emailVerified;
      if ($verify == 0) {
        return redirect()->route('verify');
      } else if ($session_guard != $guard) {
        return redirect("$guard/login");
      } else {
        Auth::guard($guard)->loginUsingId($uid);
        return $next($request);
      }
    } else {
      Session::flush();
      // getting the guard using guard used
      return redirect("$guard/login");
    }
  }
}
