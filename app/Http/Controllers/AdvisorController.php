<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class AdvisorController extends Controller
{
    public function index()
    {
        return view('advisor.index');
    }

    public function trainees_requests(){
        return view('advisor.trainees_requests');
    }

    public function meetings_schedule(){
        return view('advisor.meetings_schedule');
    }

    public function notifications(){
        return view('advisor.notifications_and_emails');
    }

    public function trainees(){
        return view('advisor.trainees');
    }
}
