<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Kreait\Firebase\Contract\Auth;

use Illuminate\Support\Facades\Session;
use Symfony\Component\HttpFoundation\Response;
use Kreait\Firebase\Exception\FirebaseException;

class VerifyUser
{
  /**
   * Handle an incoming request.
   *
   * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
   */
  public function handle(Request $request, Closure $next): Response
  {
    $uid = Session::get('uid');
    if ($uid) {
      $verify = app('firebase.auth')->getUser($uid)->emailVerified;
      if ($verify == 0) {
        return redirect()->route('verify');
      } else {
        return $next($request);
      }
    } else {
      return $next($request);
    }
  }
}
