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
}
