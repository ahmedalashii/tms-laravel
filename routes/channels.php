<?php

use App\Models\Advisor;
use App\Models\Trainee;
use Illuminate\Support\Facades\Broadcast;

/*
|--------------------------------------------------------------------------
| Broadcast Channels
|--------------------------------------------------------------------------
|
| Here you may register all of the event broadcasting channels that your
| application supports. The given channel authorization callbacks are
| used to check if an authenticated user can listen to the channel.
|
*/

Broadcast::channel('App.Models.Trainee.{id}', function ($user, $id) {
    $trainee_db = Trainee::where('firebase_uid', $user->localId)->first();
    return (int) $trainee_db->id === (int) $id;
}, ['guards' => 'trainee']);

Broadcast::channel('App.Models.Advisor.{id}', function ($user, $id) {
    $advisor_db = Advisor::where('firebase_uid', $user->localId)->first();
    return (int) $advisor_db->id === (int) $id;
}, ['guards' => 'advisor']);
