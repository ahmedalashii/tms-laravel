<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdvisorController;
use App\Http\Controllers\ManagerController;
use App\Http\Controllers\Trainee\TraineeController;
use App\Http\Controllers\Advisor\AdvisorLoginController;
use App\Http\Controllers\Manager\ManagerLoginController;
use App\Http\Controllers\Trainee\TraineeLoginController;
use App\Http\Controllers\Advisor\AdvisorRegisterController;
use App\Http\Controllers\Manager\ManagerRegisterController;
use App\Http\Controllers\Trainee\TraineeRegisterController;
use App\Http\Controllers\Advisor\AdvisorPasswordResetController;
use App\Http\Controllers\Manager\ManagerPasswordResetController;
use App\Http\Controllers\Trainee\TraineePasswordResetController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('index');
});

Route::get('/trainee', [TraineeController::class, 'index'])->name('trainee')->middleware(['user:trainee', 'fireauth:trainee']);
// Auth Trainee routes
Route::group(['prefix' => 'trainee/', 'as' => 'trainee.', 'middleware' => ['guest:trainee']], function () {
    Route::get('/login', [TraineeLoginController::class, 'index'])->name('login');
    Route::post('/login', [TraineeLoginController::class, 'login'])->name('login');
    Route::get('/register', [TraineeRegisterController::class, 'index'])->name('register');
    Route::post('/register', [TraineeRegisterController::class, 'register'])->name('register');
    Route::get('/reset', [TraineePasswordResetController::class, 'index'])->name('reset');
    Route::post('/reset', [TraineePasswordResetController::class, 'reset'])->name('reset');
});
Route::get('/advisor', [AdvisorController::class, 'index'])->name('advisor')->middleware(['user:advisor', 'fireauth:advisor']);
// Auth Advisor routes
Route::group(['prefix' => 'advisor/', 'as' => 'advisor.', 'middleware' => ['guest:advisor']], function () {
    Route::get('/login', [AdvisorLoginController::class, 'index'])->name('login');
    Route::post('/login', [AdvisorLoginController::class, 'login'])->name('login');
    Route::get('/register', [AdvisorRegisterController::class, 'index'])->name('register');
    Route::post('/register', [AdvisorRegisterController::class, 'register'])->name('register');
    Route::get('/reset', [AdvisorPasswordResetController::class, 'index'])->name('reset');
    Route::post('/reset', [AdvisorPasswordResetController::class, 'reset'])->name('reset');
});


Route::get('/manager', [ManagerController::class, 'index'])->name('manager')->middleware(['user:manager', 'fireauth:manager']);
// Auth Manager routes
Route::group(['prefix' => 'manager/', 'as' => 'manager.'], function () {
    // Grouped routes
    Route::middleware(['guest:manager'])->group(function () {
        Route::get('/login', [ManagerLoginController::class, 'index'])->name('login');
        Route::post('/login', [ManagerLoginController::class, 'login'])->name('login');
        Route::get('/register', [ManagerRegisterController::class, 'index'])->name('register');
        Route::post('/register', [ManagerRegisterController::class, 'register'])->name('register');
        Route::get('/reset', [ManagerPasswordResetController::class, 'index'])->name('reset');
        Route::post('/reset', [ManagerPasswordResetController::class, 'reset'])->name('reset');
    });
    Route::get('/logout', [ManagerLoginController::class, 'logout'])->name('logout')->middleware(['fireauth:manager', 'auth:manager']);
    Route::middleware(['user:manager', 'fireauth:manager'])->group(function (){
        Route::get('/training-requests', [ManagerController::class, 'training_requests'])->name('training-requests');
        Route::get('/authorize-trainees', [ManagerController::class, 'authorize_trainees'])->name('authorize-trainees');
        Route::get('/trainees', [ManagerController::class, 'trainees'])->name('trainees');
        Route::get('/trainees/edit/{trainee}', [ManagerController::class, 'edit_trainee'])->name('trainees-edit');
        Route::post('/trainees/edit/{trainee}', [ManagerController::class, 'update_trainee'])->name('trainees-update');
        Route::post('/trainees/authorize/{trainee}', [ManagerController::class, 'authorize_trainee'])->name('authorize-trainee');
        Route::post('/trainees/verify/{trainee}', [ManagerController::class, 'verify_trainee'])->name('verify-trainee');
        Route::get('/issues', [ManagerController::class, 'issues'])->name('issues');
        Route::get('/issue/response/{issue}', [ManagerController::class, 'issue_response'])->name('issue-response');
    });
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home')->middleware('user');

Route::get('/home/customer', [App\Http\Controllers\HomeController::class, 'customer'])->middleware('user', 'fireauth');

Route::get('/email/verify', [App\Http\Controllers\Auth\ResetController::class, 'verify_email'])->name('verify')->middleware('fireauth');

Route::post('login/{provider}/callback', 'Auth\LoginController@handleCallback');

Route::resource('/home/profile', App\Http\Controllers\Auth\ProfileController::class)->middleware('user', 'fireauth');

Route::resource('/password/reset', App\Http\Controllers\Auth\ResetController::class);

Route::resource('/img', App\Http\Controllers\ImageController::class);
