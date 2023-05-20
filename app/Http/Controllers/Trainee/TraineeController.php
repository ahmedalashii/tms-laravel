<?php

namespace App\Http\Controllers\Trainee;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Session;

class TraineeController extends Controller
{
    public function index()
    {
        return view('trainee.index');
    }

    public function upload(){
        return view('trainee.upload');
    }

    public function apply_for_training(){
        return view('trainee.apply_for_training');
    }

    public function training_attendance(){
        return view('trainee.training_attendance');
    }

    public function request_meeting(){
        return view('trainee.request_meeting');
    }


    
}
