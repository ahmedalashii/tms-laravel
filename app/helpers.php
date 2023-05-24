<?php

use App\Models\Advisor;
use App\Models\Trainee;
use App\Models\Manager;
use Illuminate\Support\Facades\Auth;


function auth_trainee()
{
    $trainee = Auth::guard('trainee')->user();
    $trainee_db = Trainee::where('firebase_uid', $trainee->localId)->first();
    return $trainee_db;
}


function auth_advisor()
{
    $advisor = Auth::guard('advisor')->user();
    $advisor_db = Advisor::where('firebase_uid', $advisor->localId)->first();
    return $advisor_db;
}

function auth_manager()
{
    $manager = Auth::guard('manager')->user();
    $manager_db = Manager::where('firebase_uid', $manager->localId)->first();
    return $manager_db;
}
