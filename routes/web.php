<?php

use App\Mail\ResetPasswordMail;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdvisorController;
use App\Http\Controllers\StripePaymentController;
use App\Http\Controllers\Manager\ManagerController;
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
})->middleware(['guest:trainee,advisor,manager']);

Route::get('/trainee', [TraineeController::class, 'index'])->name('trainee')->middleware(['fireauth:trainee']);
// Auth Trainee routes
Route::group(['prefix' => 'trainee/', 'as' => 'trainee.'], function () {
    Route::middleware(['guest:trainee'])->group(function () {
        Route::get('/login', [TraineeLoginController::class, 'index'])->name('login');
        Route::post('/login', [TraineeLoginController::class, 'login'])->name('login');
        Route::get('/register', [TraineeRegisterController::class, 'index'])->name('register');
        Route::post('/register', [TraineeRegisterController::class, 'register'])->name('register');
        Route::get('/reset', [TraineePasswordResetController::class, 'index'])->name('reset');
        Route::post('/reset', [TraineePasswordResetController::class, 'reset'])->name('reset');
    });
    Route::post('/logout', [TraineeLoginController::class, 'traineeLogout'])->name('logout')->middleware(['auth:trainee']);

    Route::middleware(['fireauth:trainee'])->group(function () {
        Route::get('training-program/stripe/{id}', [StripePaymentController::class, 'paymentStripe'])->name('stripe')->middleware(['stripe']);
        Route::post('training-program/stripe/{id}', [StripePaymentController::class, 'postPaymentStripe'])->name('stripe-payment')->middleware(['stripe']);
        Route::post('training-program', [TraineeController::class, 'post_training_attendance'])->name('training_attendance');
        Route::post('notifications/read', [TraineeController::class, 'read_notifications'])->name('notifications.read');
        Route::get('/edit-info', [TraineeController::class, 'edit'])->name('edit');
        Route::post('/edit-info/{trainee}', [TraineeController::class, 'update'])->name('update');
        Route::get('/advisor-details/{advisor}', [TraineeController::class, 'advisor_details'])->name('advisor-details');
        Route::get('/advisors-list', [TraineeController::class, 'advisors_list'])->name('advisors-list');
        Route::get('/upload/{task?}', [TraineeController::class, 'upload'])->name('upload');
        Route::post('/upload/{task?}', [TraineeController::class, 'upload_file'])->name('upload');
        Route::get('/all-training-requests', [TraineeController::class, 'all_training_requests'])->name('all-training-requests');
        Route::get('/approved-training-programs', [TraineeController::class, 'approved_training_programs'])->name('approved-training-programs');
        Route::get('/available-training-programs', [TraineeController::class, 'available_training_programs'])->name('available-training-programs');
        Route::post('/apply-training-program', [TraineeController::class, 'apply_training_program'])->name('apply-training-program');
        Route::get('/training-attendance', [TraineeController::class, 'training_attendance'])->name('training-attendance');
        Route::get('/request-meeting', [TraineeController::class, 'request_meeting'])->name('request-meeting');
        Route::post('/schedule-meeting', [TraineeController::class, 'schedule_meeting'])->name('schedule-meeting');
        Route::post('/cancel-meeting/{meeting}', [TraineeController::class, 'cancel_meeting'])->name('cancel-meeting');
        Route::get('/send_email_form/{advisor?}/{subject?}', [TraineeController::class, 'send_email_form'])->name('send-email-form');
        Route::post('/send_email', [TraineeController::class, 'send_email'])->name('send-email');
        Route::get('/received-emails', [TraineeController::class, 'received_emails'])->name('received-emails');
        Route::get('/sent-emails', [TraineeController::class, 'sent_emails'])->name('sent-emails');
        Route::post('/igonre_email/{email}', [TraineeController::class, 'ignore_email'])->name('ignore-email');
    });
});


Route::get('/advisor', [AdvisorController::class, 'index'])->name('advisor')->middleware(['fireauth:advisor']);
// Auth Advisor routes
Route::group(['prefix' => 'advisor/', 'as' => 'advisor.'], function () {
    Route::middleware(['guest:advisor'])->group(function () {
        Route::get('/login', [AdvisorLoginController::class, 'index'])->name('login');
        Route::post('/login', [AdvisorLoginController::class, 'login'])->name('login');
        Route::get('/register', [AdvisorRegisterController::class, 'index'])->name('register');
        Route::post('/register', [AdvisorRegisterController::class, 'register'])->name('register');
        Route::get('/reset', [AdvisorPasswordResetController::class, 'index'])->name('reset');
        Route::post('/reset', [AdvisorPasswordResetController::class, 'reset'])->name('reset');
    });

    Route::post('/logout', [AdvisorLoginController::class, 'advisorLogout'])->name('logout')->middleware(['auth:advisor']);

    Route::middleware(['fireauth:advisor'])->group(function () {
        Route::get('/edit-info', [AdvisorController::class, 'edit'])->name('edit');
        Route::post('notifications/read', [AdvisorController::class, 'read_notifications'])->name('notifications.read');
        Route::post('/edit-info/{advisor}', [AdvisorController::class, 'update'])->name('update');
        Route::get('/trainees-requests', [AdvisorController::class, 'trainees_requests'])->name('trainees-requests');
        Route::get('/assigned-training-programs', [AdvisorController::class, 'assigned_training_programs'])->name('assigned-training-programs');
        Route::get('/trainees-list', [AdvisorController::class, 'trainees_list'])->name('trainees-list');
        Route::get('/trainee-details/{trainee}', [AdvisorController::class, 'trainee_details'])->name('trainee-details');
        Route::get('/send_email_form/{trainee?}/{subject?}', [AdvisorController::class, 'send_email_form'])->name('send-email-form');
        Route::post('/send_email', [AdvisorController::class, 'send_email'])->name('send-email');
        Route::post('/igonre_email/{email}', [AdvisorController::class, 'ignore_email'])->name('ignore-email');
        Route::get('/sent-emails', [AdvisorController::class, 'sent_emails'])->name('sent-emails');
        Route::get('/received-emails', [AdvisorController::class, 'received_emails'])->name('received-emails');
        Route::get('/meetings-schedule', [AdvisorController::class, 'meetings_schedule'])->name('meetings-schedule');
        Route::post('/reject-meeting/{meeting}', [AdvisorController::class, 'reject_meeting'])->name('reject-meeting');
        Route::post('/approve-meeting/{meeting}', [AdvisorController::class, 'approve_meeting'])->name('approve-meeting');
        Route::get('/tasks', [AdvisorController::class, 'tasks'])->name('tasks');
        Route::get('/tasks/create', [AdvisorController::class, 'create_task'])->name('create-task');
        Route::post('/tasks/create', [AdvisorController::class, 'store_task'])->name('create-task');
        Route::get('/tasks/edit/{task}', [AdvisorController::class, 'edit_task'])->name('edit-task');
        Route::post('/tasks/edit/{task}', [AdvisorController::class, 'update_task'])->name('update-task');
        Route::post('/tasks/deactivate/{task}', [AdvisorController::class, 'deactivate_task'])->name('deactivate-task');
        Route::post('/tasks/activate/{id}', [AdvisorController::class, 'activate_task'])->name('activate-task');
    });
});


Route::get('/manager', [ManagerController::class, 'index'])->name('manager')->middleware(['fireauth:manager']);
// Auth Manager routes
Route::group(['prefix' => 'manager/', 'as' => 'manager.'], function () {
    Route::middleware(['guest:manager'])->group(function () {
        Route::get('/login', [ManagerLoginController::class, 'index'])->name('login');
        Route::post('/login', [ManagerLoginController::class, 'login'])->name('login');
        Route::get('/register', [ManagerRegisterController::class, 'index'])->name('register');
        Route::post('/register', [ManagerRegisterController::class, 'register'])->name('register');
        Route::get('/reset', [ManagerPasswordResetController::class, 'index'])->name('reset');
        Route::post('/reset', [ManagerPasswordResetController::class, 'reset'])->name('reset');
    });
    Route::post('/logout', [ManagerLoginController::class, 'managerLogout'])->name('logout')->middleware(['auth:manager']);
    Route::middleware(['fireauth:manager'])->group(function () {
        Route::post('notifications/read', [ManagerController::class, 'read_notifications'])->name('notifications.read');
        Route::get('/trainees', [ManagerController::class, 'trainees'])->name('trainees');
        Route::get('/authorize-trainees', [ManagerController::class, 'authorize_trainees'])->name('authorize-trainees');
        Route::post('/trainees/authorize/{trainee}', [ManagerController::class, 'authorize_trainee'])->name('authorize-trainee');
        Route::get('/advisors', [ManagerController::class, 'advisors'])->name('advisors');
        Route::get('/authorize-advisors', [ManagerController::class, 'authorize_advisors'])->name('authorize-advisors');
        Route::post('/update-training-criteria', [ManagerController::class, 'update_training_criteria'])->name('update-training-criteria');
        Route::post('/advisors/authorize/{advisor}', [ManagerController::class, 'authorize_advisor'])->name('authorize-advisor');
        Route::post('/advisors/verify/{advisor}', [ManagerController::class, 'verify_advisor'])->name('verify-advisor');
        Route::post('/advisors/deactivate/{advisor}', [ManagerController::class, 'deactivate_advisor'])->name('deactivate-advisor');
        Route::post('/advisors/activate/{id}', [ManagerController::class, 'activate_advisor'])->name('activate-advisor');
        Route::get('/training-requests', [ManagerController::class, 'training_requests'])->name('training-requests');
        Route::post('/training-requests/approve/{id}', [ManagerController::class, 'approve_training_request'])->name('approve-training-request');
        Route::post('/training-requests/reject/{id}', [ManagerController::class, 'reject_training_request'])->name('reject-training-request');
        Route::get('/disciplines', [ManagerController::class, 'disciplines'])->name('disciplines');
        Route::get('/disciplines/create', [ManagerController::class, 'create_discipline'])->name('create-discipline');
        Route::post('/disciplines/store', [ManagerController::class, 'store_discipline'])->name('store-discipline');
        Route::get('/disciplines/edit/{discipline}', [ManagerController::class, 'edit_discipline'])->name('edit-discipline');
        Route::post('/disciplines/store/{discipline}', [ManagerController::class, 'update_discipline'])->name('update-discipline');
        Route::post('/disciplines/deactivate/{discipline}', [ManagerController::class, 'deactivate_discipline'])->name('deactivate-discipline');
        Route::post('/disciplines/activate/{id}', [ManagerController::class, 'activate_discipline'])->name('activate-discipline');
        Route::get('/training-programs', [ManagerController::class, 'training_programs'])->name('training-programs');
        Route::get('/training-programs/create', [ManagerController::class, 'create_training_program'])->name('create-training-program');
        Route::post('/training-programs/store', [ManagerController::class, 'store_training_program'])->name('store-training-program');
        Route::get('/training-programs/edit/{trainingProgram}', [ManagerController::class, 'edit_training_program'])->name('edit-training-program');
        Route::post('/training-programs/update/{trainingProgram}', [ManagerController::class, 'update_training_program'])->name('update-training-program');
        Route::post('/training-programs/deactivate/{trainingProgram}', [ManagerController::class, 'deactivate_training_program'])->name('deactivate-training-program');
        Route::post('/training-programs/activate/{id}', [ManagerController::class, 'activate_training_program'])->name('activate-training-program');
        //* The manger for now has no access to edit trainees info (Only the trainee can edit his/her info). However, the manager can authorize, send email verification, deactivate and activate trainees.
        // Route::get('/trainees/edit/{trainee}', [ManagerController::class, 'edit_trainee'])->name('trainees-edit');
        // Route::post('/trainees/edit/{trainee}', [ManagerController::class, 'update_trainee'])->name('trainees-update');
        Route::post('/trainees/verify/{trainee}', [ManagerController::class, 'verify_trainee'])->name('verify-trainee');
        Route::post('/trainees/deactivate/{trainee}', [ManagerController::class, 'deactivate_trainee'])->name('deactivate-trainee');
        Route::post('/trainees/activate/{id}', [ManagerController::class, 'activate_trainee'])->name('activate-trainee');
        Route::get('/issues', [ManagerController::class, 'issues'])->name('issues');
        Route::get('/issue/response/{issue}', [ManagerController::class, 'issue_response'])->name('issue-response');
        Route::get('/managers', [ManagerController::class, 'managers'])->name('managers');
        Route::post('/managers/activate/{manager}', [ManagerController::class, 'activate_manager'])->name('activate-manager');
        Route::post('/managers/deactivate/{manager}', [ManagerController::class, 'deactivate_manager'])->name('deactivate-manager');
    });
});

// Auth::routes();

// Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home')->middleware('user');

// Route::get('/home/customer', [App\Http\Controllers\HomeController::class, 'customer'])->middleware('user', 'fireauth');

// Route::get('/email/verify', [App\Http\Controllers\Auth\ResetController::class, 'verify_email'])->name('verify')->middleware('fireauth');

// Route::post('login/{provider}/callback', 'Auth\LoginController@handleCallback');

// Route::resource('/home/profile', App\Http\Controllers\Auth\ProfileController::class)->middleware('user', 'fireauth');

// Route::resource('/password/reset', App\Http\Controllers\Auth\ResetController::class);

// Route::resource('/img', App\Http\Controllers\ImageController::class);
