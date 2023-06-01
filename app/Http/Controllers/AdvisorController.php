<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Advisor;
use App\Models\Meeting;
use App\Models\Trainee;
use App\Models\Discipline;
use Illuminate\Http\Request;
use App\Models\TrainingProgram;
use App\Mail\AdvisorToTraineeMail;
use App\Models\AdvisorTraineeEmail;
use App\Models\TrainingProgramTask;
use App\Http\Traits\EmailProcessing;
use Illuminate\Support\Facades\Session;
use App\Notifications\TraineeNotification;
use App\Http\Traits\FirebaseStorageFileProcessing;

class AdvisorController extends Controller
{
    use FirebaseStorageFileProcessing, EmailProcessing;

    public function index()
    {
        $my_trainees_count = auth_advisor()->trainees()->count();
        $my_assigned_training_programs_count = auth_advisor()->assigned_training_programs()->count();
        $my_tasks_count = auth_advisor()->assigned_training_programs()->withCount('tasks')->get()->sum('tasks_count');
        $recent_enrollments = auth_advisor()->recent_enrollments()->take(5)->get();
        return view('advisor.index', compact('recent_enrollments', 'my_trainees_count', 'my_assigned_training_programs_count', 'my_tasks_count'));
    }

    public function edit()
    {
        $disciplines = Discipline::withoutTrashed()->select('id', 'name')->get();
        return view('advisor.edit', compact('disciplines'));
    }

    public function read_notifications(Request $request)
    {
        $advisor = auth_advisor();
        $notifications = $advisor->notifications();
        $notifications->update(['read_at' => now()]);
        return response()->json(['success' => true]);
    }


    public function send_email_form(?Trainee $trainee = null, ?string $subject = null)
    {
        $advisor = auth_advisor();
        if (!$trainee) {
            $trainees = $advisor->trainees()->get();
            return view('advisor.send_email', compact('trainees', 'subject'));
        }
        $trainee = $advisor->trainees()->where('trainee_id', $trainee->id)->first();
        if (!$trainee) {
            return redirect()->back()->with(['fail' => 'You are not allowed to access this trainee!', 'type' => 'error']);
        }
        return view('advisor.send_email', compact('trainee', 'subject'));
    }

    public function send_email(Request $request)
    {

        $data = $request->validate([
            'email' => 'required|email|exists:trainees',
            'subject' => 'required|string|max:255',
            'message' => 'required|string|max:255',
        ]);
        $trainee = Trainee::where('email', $data['email'])->first();

        if (!$trainee) {
            return redirect()->back()->with(['fail' => 'Trainee not found!', 'type' => 'error']);
        }
        $advisor = auth_advisor();
        $trainee = $advisor->trainees()->where('trainee_id', $trainee->id)->first();
        if (!$trainee) {
            return redirect()->back()->with(['fail' => 'You are not allowed to access this trainee!', 'type' => 'error']);
        }
        $mailable = new AdvisorToTraineeMail($advisor, $trainee, $data['subject'], $data['message']);
        $this->sendEmail($trainee->email, $mailable);
        $trainee->notify(new TraineeNotification(null, $advisor, 'You have a new email from your advisor ' . $advisor->displayName . '. Please check your received emails!'));
        // Store the email in the database
        $advisor->sent_emails()->create([
            'trainee_id' => $trainee->id,
            'advisor_id' => $advisor->id,
            'sender' => 'advisor',
            'subject' => $data['subject'],
            'message' => $data['message'],
        ]);
        return redirect()->back()->with(['success' => 'Email sent successfully 😎!', 'type' => 'success']);
    }

    public function ignore_email(AdvisorTraineeEmail $email)
    {
        $status = $email->delete();
        return redirect()->back()->with([$status ? 'success' : 'fail' => $status ? 'Email has been ignored successfully' : 'Something is wrong!', 'type' => $status ? 'success' : 'error']);
    }

    public function sent_emails()
    {
        $paginate = 3;
        $sent_emails = auth_advisor()->sent_emails()->paginate($paginate);
        return view('advisor.sent_emails', compact('sent_emails'));
    }

    public function received_emails()
    {
        $paginate = 3;
        $received_emails = auth_advisor()->received_emails()->paginate($paginate);
        return view('advisor.received_emails', compact('received_emails'));
    }

    public function assigned_training_programs(Request $request)
    {
        $request->validate([
            'discipline_id' => 'nullable|exists:disciplines,id',
        ]);
        $paginate = 3;
        $discipline_id = $request->discipline;
        $search_value = $request->search;
        $price_filter = $request->price_filter;
        $training_programs = auth_advisor()->assigned_training_programs()
            ->where(function ($query) use ($request, $price_filter) {
                $query->when($price_filter, function ($query, $price_filter) {
                    if ($price_filter == "free") {
                        $query->whereNull('fees');
                    } else {
                        // the maximum double value 
                        $price = 1.7976931348623157E+308;
                        $query->where('fees', '<=', $price);
                    }
                });
            })->where(function ($query) use ($search_value) {
                $query->where('name', 'like', '%' . $search_value . '%')
                    ->orWhere('description', 'like', '%' . $search_value . '%')
                    ->orWhere('location', 'like', '%' . $search_value . '%');
            })->where(function ($query) use ($discipline_id) {
                $query->when($discipline_id, function ($query, $discipline_id) {
                    $query->where('discipline_id', $discipline_id);
                });
            })->paginate($paginate);
        $advisor = auth_advisor();
        $disciplines = Discipline::withoutTrashed()->whereIn('id', $advisor->disciplines->pluck('id'))->get();
        return view('advisor.assigned_training_programs', compact('training_programs', 'disciplines'));
    }


    public function tasks()
    {
        $paginate = 5;
        $training_program_id = request()->query('training_program');
        $search_value = request()->query('search');
        $tasks = TrainingProgramTask::withTrashed()->where(function ($query) use ($search_value) {
            $query->where('name', 'LIKE', '%' . $search_value . '%')
                ->orWhere('description', 'LIKE', '%' . $search_value . '%');
        })->when($training_program_id, function ($query, $training_program_id) {
            $query->where('training_program_id', $training_program_id);
        })->whereHas('trainingProgram', function ($query) {
            $query->where('advisor_id', auth_advisor()->id);
        })->paginate($paginate);
        $training_programs = auth_advisor()->assigned_training_programs()->select('training_programs.id', 'training_programs.name')->get();
        return view('advisor.tasks', compact('tasks', 'training_programs'));
    }

    public function create_task()
    {
        $advisor = auth_advisor();
        $training_programs = $advisor->assigned_training_programs()->select('training_programs.id', 'training_programs.name')->get();
        return view('advisor.create_task', compact('training_programs'));
    }


    public function store_task(Request $request)
    {
        // Each task is related to a training program
        // Each task has a name, description, deadline, and file
        $request->validate([
            'training_program_id' => 'required|exists:training_programs,id',
            'name' => 'required|string|max:255',
            'description' => 'required|string|max:255',
            'end_date' => 'required|date|after:today',
            'file' => 'nullable|file|mimes:pdf,doc,docx,xls,xlsx,ppt,pptx,zip,rar,jpeg,png,jpg,gif,svg|max:10240',
        ]);

        $training_program = TrainingProgram::find($request->training_program_id);
        $task = new \App\Models\TrainingProgramTask;
        $task->name = $request->name;
        $task->description = $request->description;
        $task->end_date = $request->end_date;
        $task->training_program_id = $request->training_program_id;

        if ($request->file('file')) {
            // Upload File
            $task_file = $request->file('file');
            // Using firebase storage to upload files and make a record for File in the database linked with the TrainingProgram
            $file_name = $request->name . '_' . time() . '.' . $task_file->getClientOriginalExtension();
            $task->file_name = $file_name;
            $status = $task->save();
            $task_id = $training_program->id . '_' . $task->id;
            $file_path = 'TrainingPrograms/' . $training_program->name . '/Tasks/' . 'Task_' . $task_id . '/' . $file_name;
            $this->uploadFirebaseStorageFile($task_file, $file_path);
            // Create a file record in the database
            $file = new \App\Models\File;
            $file->name = $file_name;
            $file->firebase_file_path = $file_path;
            $file->extension = $task_file->getClientOriginalExtension();
            $file->training_program_id = $training_program->id;
            $file->task_id = $task->id;
            $file->description = 'Task File for ' . $task->name;
            $size = $task_file->getSize();
            $file->size = $size ? $size : 0;
            $file->save();
        } else {
            $status = $task->save();
        }

        // notify the trainees that a new task has been added to the training program that they are registered in

        $trainees = $training_program->trainees;
        foreach ($trainees as $trainee) {
            $trainee->notify(new TraineeNotification(null, auth_advisor(), 'A new task has been added to the training program ' . $training_program->name . ' that you are registered in. Please check your timeline!'));
        }
        return redirect()->route('advisor.tasks')->with([$status ? 'success' : 'fail' => $status ? 'Task Created Successfully' : 'Something is wrong!', 'type' => $status ? 'success' : 'error']);
    }


    public function edit_task(TrainingProgramTask $task)
    {
        $advisor = auth_advisor();
        $training_programs = $advisor->assigned_training_programs()->select('training_programs.id', 'training_programs.name')->get();
        return view('advisor.edit_task', compact('task', 'training_programs'));
    }

    public function update_task(TrainingProgramTask $task, Request $request)
    {
        $request->validate([
            'training_program_id' => 'required|exists:training_programs,id',
            'name' => 'required|string|max:255',
            'description' => 'required|string|max:255',
            'end_date' => 'required|date|after:today',
            'file' => 'nullable|file|mimes:pdf,doc,docx,xls,xlsx,ppt,pptx,zip,rar,jpeg,png,jpg,gif,svg|max:10240',
        ]);
        $training_program = TrainingProgram::find($request->training_program_id);
        $task->name = $request->name;
        $task->description = $request->description;
        $task->end_date = $request->end_date;
        $task->training_program_id = $request->training_program_id;

        // Upload File
        if ($request->file('file')) {
            // Delete the old file
            $old_file = $task->file();
            if ($old_file) {
                $this->deleteFirebaseStorageFile($old_file->firebase_file_path);
                $old_file->delete();
            }

            $task_file = $request->file('file');
            // Using firebase storage to upload files and make a record for File in the database linked with the TrainingProgram
            $file_name = $request->name . '_' . time() . '.' . $task_file->getClientOriginalExtension();
            $task->file_name = $file_name;
            $status = $task->save();
            $task_id = $training_program->id . '_' . $task->id;
            $file_path = 'TrainingPrograms/' . $training_program->name . '/Tasks/' . 'Task_' . $task_id . '/' . $file_name;
            $this->uploadFirebaseStorageFile($task_file, $file_path);
            // Create a file record in the database
            $file = new \App\Models\File;
            $file->name = $file_name;
            $file->firebase_file_path = $file_path;
            $file->extension = $task_file->getClientOriginalExtension();
            $file->training_program_id = $training_program->id;
            $file->task_id = $task->id;
            $file->description = 'Task File for ' . $task->name;
            $size = $task_file->getSize();
            $file->size = $size ? $size : 0;
            $file->save();
        } else {
            $status = $task->save();
        }
        return redirect()->route('advisor.tasks')->with([$status ? 'success' : 'fail' => $status ? 'Task Updated Successfully' : 'Something is wrong!', 'type' => $status ? 'success' : 'error']);
    }

    public function deactivate_task(TrainingProgramTask $task)
    {
        $destroy = $task->delete();
        return redirect()->back()->with([$destroy ? 'success' : 'fail' => $destroy ?  'Task Deactivated Successfully' : 'Something is wrong!', 'type' => $destroy ? 'success' : 'error']);
    }

    public function activate_task($id)
    {
        $status = TrainingProgramTask::onlyTrashed()->find($id)->restore();
        return redirect()->back()->with([$status ? 'success' : 'fail' => $status ? 'Task Activated Successfully' : 'Something is wrong!', 'type' => $status ? 'success' : 'error']);
    }



    public function trainee_details(Trainee $trainee)
    {
        $advisor = auth_advisor();
        $trainee = $advisor->trainees()->where('trainee_id', $trainee->id)->first()->load('disciplines');
        if (!$trainee) {
            return redirect()->back()->with(['fail' => 'You are not allowed to access this trainee!', 'type' => 'error']);
        }
        return view('advisor.trainee_details', compact('trainee'));
    }

    public function trainees_list(Request $request)
    {
        $search_value = $request->search;
        $advisor = auth_advisor();
        $paginate = 3;
        $trainees = $advisor->trainees()->where(function ($query) use ($search_value) {
            $query->where('displayName', 'like', '%' . $search_value . '%')
                ->orWhere('email', 'like', '%' . $search_value . '%')
                ->orWhere('phone', 'like', '%' . $search_value . '%')
                ->orWhere('address', 'like', '%' . $search_value . '%');
        })->paginate($paginate);
        return view('advisor.trainees_list', compact('trainees'));
    }

    public function update(Advisor $advisor)
    {
        $data = request()->validate([
            'displayName' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:advisors,email,' . $advisor->id,
            'phone' => 'required|string|max:255|unique:advisors,phone,' . $advisor->id,
            'address' => 'required|string|max:255',
            'disciplines' => 'required|array|min:1',
            'avatar-image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg',
            'cv-file' => 'nullable|mimes:pdf,doc,docx,txt,rtf,odt,ods,odp,odg,odc,odb,xls,xlsx,ppt,pptx',
        ]);

        // Check if the user uploaded a new avatar image
        if (request()->hasFile('avatar-image')) {
            // Delete the old avatar image from firebase storage
            if ($advisor->avatar) {
                $reference = app('firebase.storage')->getBucket()->object($advisor->avatar);
                if ($reference->exists()) {
                    $reference->delete();
                }
                $advisor->avatar_file->delete();
            }
            $avatarImage = request()->file('avatar-image');
            // Using firebase storage to upload files and make a record for File in the database linked with the advisor
            $avatar_file_name = $advisor->firebase_uid . '_advisor_avatar_image.' . $avatarImage->getClientOriginalExtension();
            $avatar_file_path = 'Advisor/Images/' . $avatar_file_name;
            $this->uploadFirebaseStorageFile($avatarImage, $avatar_file_path);

            // Create a file record in the database
            $file = new \App\Models\File;
            $file->name = $avatar_file_name;
            $file->firebase_file_path = $avatar_file_path;
            $file->extension = $avatarImage->getClientOriginalExtension();
            $file->advisor_id = $advisor->id;
            $file->description = 'Advisor Avatar Image';
            $size = $avatarImage->getSize();
            $file->size = $size ? $size : 0;
        }

        // cv-file
        // Check if the user uploaded a new cv file
        if (request()->hasFile('cv-file')) {
            // Delete the old cv file from firebase storage
            if ($advisor->cv) {
                info('Advisor has a cv file');
                $reference = app('firebase.storage')->getBucket()->object($advisor->cv);
                if ($reference->exists()) {
                    $reference->delete();
                }
                $advisor->cv_file->delete();
            }
            $cvFile = request()->file('cv-file');
            // Using firebase storage to upload files and make a record for File in the database linked with the advisor
            $cv_file_name = $advisor->firebase_uid . '_advisor_cv_file.' . $cvFile->getClientOriginalExtension();
            $cv_file_path = 'Advisor/CVs/' . $cv_file_name;
            $this->uploadFirebaseStorageFile($cvFile, $cv_file_path);
            // Create a file record in the database
            $file = new \App\Models\File;
            $file->name = $cv_file_name;
            $file->firebase_file_path = $cv_file_path;
            $file->extension = $cvFile->getClientOriginalExtension();
            $file->advisor_id = $advisor->id;
            $file->description = 'Advisor CV File';
            $size = $cvFile->getSize();
            $file->size = $size ? $size : 0;
            $file->save();
        }

        // Check the disciplines selected by the user and remove the old disciplines and add the new ones
        $disciplines = $data['disciplines'];
        $advisor->disciplines()->detach();
        foreach ($disciplines as $discipline) {
            $advisor->disciplines()->attach($discipline);
        }

        // Check before update firebase user if the email or phone number is used before and not by the same user
        $auth = app('firebase.auth');
        try {
            $firebaseUser = $auth->getUserByEmail($data['email']);
            if ($firebaseUser->uid != $advisor->firebase_uid) {
                return redirect()->back()->with(['fail' => 'The email address is already in use by another account!', 'type' => 'error']);
            }
            // Update firebase user
            $user = $auth->getUser($advisor->firebase_uid);
            $auth->updateUser($user->uid, [
                'email' => $data['email'],
                'displayName' => $data['displayName'],
            ]);
            $status = $advisor->update($data);
            return redirect()->back()->with([$status ? 'success' : 'fail' => $status ? 'Your Information has been updated successfully!' : 'Something is wrong!', 'type' => $status ? 'success' : 'error']);
        } catch (\Throwable $th) { // If the email is not used before then the getUserByEmail will throw an exception
            // Do nothing
            return redirect()->back()->with(['fail' => $th->getMessage(), 'type' => 'error']);
        }
    }

    public function trainees_requests()
    {
        return view('advisor.trainees_requests');
    }

    public function meetings_schedule()
    {
        // Get all meetings of the advisor
        $meetings = auth_advisor()->meetings()->paginate(5);
        return view('advisor.meetings_schedule', compact('meetings'));
    }

    public function reject_meeting(Meeting $meeting)
    {
        $meeting->status = 'rejected';
        // Send notification to the trainee
        $meeting->trainee->notify(new TraineeNotification(null, auth_advisor(), 'Your meeting request with ' . auth_advisor()->displayName . ' has been rejected!'));
        // Send email to the trainee
        $mailable = new AdvisorToTraineeMail(auth_advisor(), $meeting->trainee, '🫤 Your Meeting is rejected', 'Your meeting request with ' . auth_advisor()->displayName . ' at ' . $meeting->date . ' ' . Carbon::parse($meeting->time)->format('h:i A') . ' has been rejected!');
        $this->sendEmail($meeting->trainee->email, $mailable);
        $status = $meeting->save();
        return redirect()->back()->with([$status ? 'success' : 'fail' => $status ? 'Meeting Rejected Successfully' : 'Something is wrong!', 'type' => $status ? 'success' : 'error']);
    }

    public function approve_meeting(Meeting $meeting)
    {
        $meeting->status = 'approved';
        // Send notification to the trainee
        $meeting->trainee->notify(new TraineeNotification(null, auth_advisor(), 'Your meeting request with ' . auth_advisor()->displayName . ' has been approved!'));
        // Send email to the trainee
        $message = nl2br('Your meeting request with ' . auth_advisor()->displayName . ' at ' . $meeting->date . ' ' . Carbon::parse($meeting->time)->format('h:i A') . ' has been approved! Please be prepared to be on time at the provided meeting location ' . ($meeting->location ? ' ' . $meeting->location : '') . '.');
        $mailable = new AdvisorToTraineeMail(auth_advisor(), $meeting->trainee, '😎 Your Meeting is approved', $message);
        $this->sendEmail($meeting->trainee->email, $mailable);
        $status = $meeting->save();
        return redirect()->back()->with([$status ? 'success' : 'fail' => $status ? 'Meeting Approved Successfully' : 'Something is wrong!', 'type' => $status ? 'success' : 'error']);
    }
}
