<?php

namespace App\Http\Controllers\Trainee;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Session;

class TraineeController extends Controller
{
    public function index()
    {
        try {
            $uid = Session::get('uid');
            $user = app('firebase.auth')->getUser($uid);
            return view('trainee.index');
        } catch (\Exception $e) {
            return $e;
        }
    }
}
