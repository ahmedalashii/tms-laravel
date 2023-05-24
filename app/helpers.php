<?php

use App\Models\Trainee;
use Illuminate\Support\Facades\Auth;


function auth_trainee()
{
    $trainee = Auth::guard('trainee')->user();
    $trainee_db = Trainee::where('firebase_uid', $trainee->localId)->first();
    return $trainee_db;
}
