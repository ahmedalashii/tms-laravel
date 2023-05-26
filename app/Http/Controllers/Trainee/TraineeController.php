<?php

namespace App\Http\Controllers\Trainee;

use App\Models\Trainee;
use App\Models\Discipline;
use Illuminate\Http\Request;
use App\Models\TrainingProgram;
use App\Models\TrainingProgramUser;
use App\Http\Controllers\Controller;
use App\Http\Traits\EmailProcessing;
use Illuminate\Support\Facades\Auth;
use App\Models\TrainingAttendanceTrainee;
use App\Notifications\AdvisorNotification;
use App\Notifications\ManagerNotification;
use App\Http\Requests\ScheduleMeetingRequest;
use App\Http\Traits\FirebaseStorageFileProcessing;
use App\Mail\TraineeTrainingProgramEnrollmentMail;

class TraineeController extends Controller
{

    use FirebaseStorageFileProcessing, EmailProcessing;

    public function index()
    {

        $trainee = auth_trainee();
        $notifications = $trainee->notifications()->latest()->take(5)->get();
        return view('trainee.index', compact('notifications'));
    }

    public function upload()
    {
        $paginate = 3;
        $files = auth_trainee()->files()->paginate($paginate);
        $training_programs = auth_trainee()->approved_training_programs()->get();
        return view('trainee.upload', compact('files', 'training_programs'));
    }

    public function upload_file(Request $request)
    {
        $trainee_programs = auth_trainee()->approved_training_programs()->get();
        if ($request->training_program_id && !in_array($request->training_program_id, $trainee_programs->pluck('id')->toArray())) {
            return redirect()->back()->with(['fail' => 'You are not enrolled in this training program!', 'type' => 'error']);
        }

        $request->validate([
            'file' => 'required|file|max:10240',
            'description' => 'required|string|max:255',
            'training_program_id' => 'nullable|exists:training_programs,id',
        ]);
        $training_program = TrainingProgram::find($request->training_program_id);
        $trainee = auth_trainee();
        $file = $request->file('file');
        $file_name =  $training_program->name . '_' . $trainee->displayName . '_' . time() . '.' . $file->getClientOriginalExtension();
        $file_path = "TrainingPrograms/$training_program->name/Trainees/$trainee->displayName/$file_name";
        $this->uploadFirebaseStorageFile($file, $file_path);

        $file_db = new \App\Models\File;
        $file_db->name = $file_name;
        $file_db->firebase_file_path = $file_path;
        $file_db->extension = $file->getClientOriginalExtension();
        $file_db->trainee_id = $trainee->id;
        $file_db->training_program_id = $request->training_program_id;
        $file_db->description = $request->description;
        $size = $file->getSize();
        $file_db->size = $size ? $size : 0;
        $status = $file_db->save();
        return redirect()->back()->with([$status ? 'success' : 'fail' => $status ? 'File Related to ' . $training_program->name . ' training program has been uploaded successfully!' : 'Something is wrong!', 'type' => $status ? 'success' : 'error']);
    }

    public function read_notifications(Request $request)
    {
        $trainee = auth_trainee();
        $notifications = $trainee->notifications();
        $notifications->update(['read_at' => now()]);
        return response()->json(['success' => true]);
    }


    public function available_training_programs(Request $request)
    {
        $request->validate([
            'discipline_id' => 'nullable|exists:disciplines,id',
        ]);

        $paginate = 3;
        $discipline_id = $request->discipline;
        $search_value = $request->search;
        $price_filter = $request->price_filter;

        $trainee = auth_trainee();
        if ($discipline_id) {
            $training_programs = TrainingProgram::withoutTrashed()
                ->with('training_attendances')
                ->where('discipline_id', $discipline_id)
                ->where(function ($query) use ($price_filter) {
                    // when $price_filter filled with value (either free or paid) >> do conditions 
                    $query->when($price_filter, function ($query, $price_filter) {
                        if ($price_filter == "free") {
                            $query->whereNull('fees');
                        } else {
                            // the maximum double value 
                            $price = 1.7976931348623157E+308;
                            $query->where('fees', '<=', $price);
                        }
                    });
                })
                ->where('start_date', '>', date('Y-m-d'))
                ->where('end_date', '>', date('Y-m-d'))
                ->where('capacity', '>', 0)
                ->whereDoesntHave('training_program_users', function ($query) use ($trainee) {
                    $query->where('trainee_id', $trainee->id);
                })->whereHas('training_program_users', function ($query) {
                    $query->where('status', 'approved')->havingRaw('count(*) < capacity');
                })->where(function ($query) use ($search_value) {
                    $query->where('name', 'like', '%' . $search_value . '%')
                        ->orWhere('description', 'like', '%' . $search_value . '%')
                        ->orWhere('location', 'like', '%' . $search_value . '%');
                })->paginate($paginate);
            $disciplines = Discipline::withoutTrashed()->whereIn('id', $trainee->disciplines->pluck('id'))->get();
        } else {
            $training_programs = TrainingProgram::withoutTrashed()
                ->with('training_attendances')
                ->whereIn('discipline_id', $trainee->disciplines->pluck('id'))
                ->where(function ($query) use ($price_filter) {
                    // when $price_filter filled with value (either free or paid) >> do conditions 
                    $query->when($price_filter, function ($query, $price_filter) {
                        if ($price_filter == "free") {
                            $query->whereNull('fees');
                        } else {
                            // the maximum double value 
                            $price = 1.7976931348623157E+308;
                            $query->where('fees', '<=', $price);
                        }
                    });
                })->where('start_date', '>', date('Y-m-d'))
                ->where('end_date', '>', date('Y-m-d'))
                ->where('capacity', '>', 0)
                ->whereDoesntHave('training_program_users', function ($query) use ($trainee) {
                    $query->where('trainee_id', $trainee->id);
                })->whereHas('training_program_users', function ($query) {
                    $query->where('status', 'approved')->havingRaw('count(*) < capacity');
                })->where(function ($query) use ($search_value) {
                    $query->where('name', 'like', '%' . $search_value . '%')
                        ->orWhere('description', 'like', '%' . $search_value . '%')
                        ->orWhere('location', 'like', '%' . $search_value . '%');
                })->paginate($paginate);
        }
        $disciplines = Discipline::withoutTrashed()->whereIn('id', $trainee->disciplines->pluck('id'))->get();
        return view('trainee.available_training_programs', compact('training_programs', 'disciplines'));
    }


    public function all_training_requests(Request $request)
    {
        $request->validate([
            'discipline_id' => 'nullable|exists:disciplines,id',
        ]);
        $paginate = 3;
        $discipline_id = $request->discipline;
        $search_value = $request->search;
        $price_filter = $request->price_filter;
        $training_requests = TrainingProgramUser::where('trainee_id', auth_trainee()->id)->where(function ($query) use ($price_filter) {
            // when $price_filter filled with value (either free or paid) >> do conditions 
            $query->when($price_filter, function ($query, $price_filter) {
                if ($price_filter == "free") {
                    $query->where('fees_paid', 0);
                } else {
                    // the maximum double value 
                    $price = 1.7976931348623157E+308;
                    $query->where('fees_paid', '<=', $price)->where('fees_paid', '>', 0);
                }
            });
        })->where(function ($query) use ($search_value) {
            $query->whereHas('trainingProgram', function ($query) use ($search_value) {
                $query->where('name', 'like', '%' . $search_value . '%')
                    ->orWhere('description', 'like', '%' . $search_value . '%')
                    ->orWhere('location', 'like', '%' . $search_value . '%');
            });
        })->where(function ($query) use ($discipline_id) {
            $query->when($discipline_id, function ($query, $discipline_id) {
                $query->whereHas('trainingProgram', function ($query) use ($discipline_id) {
                    $query->where('discipline_id', $discipline_id);
                });
            });
        })->paginate($paginate);
        $trainee = auth_trainee();
        $disciplines = Discipline::withoutTrashed()->whereIn('id', $trainee->disciplines->pluck('id'))->get();
        return view('trainee.all_training_requests', compact('training_requests', 'disciplines'));
    }

    public function approved_training_programs(Request $request)
    {

        $request->validate([
            'discipline_id' => 'nullable|exists:disciplines,id',
        ]);
        $paginate = 3;
        $discipline_id = $request->discipline;
        $search_value = $request->search;
        $price_filter = $request->price_filter;
        $training_programs = auth_trainee()->approved_training_programs()->where(function ($query) use ($request, $price_filter) {
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
        $trainee = auth_trainee();
        $disciplines = Discipline::withoutTrashed()->whereIn('id', $trainee->disciplines->pluck('id'))->get();
        return view('trainee.approved_training_programs', compact('training_programs', 'disciplines'));
    }


    public function apply_training_program(Request $request)
    {
        $request->validate([
            'training_program_id' => 'required|exists:training_programs,id',
        ]);
        $trainingProgram = TrainingProgram::find($request->training_program_id);
        $trainee = auth_trainee();

        if ($trainingProgram->fees != null && $trainingProgram->fees > 0) {
            return redirect()->route('trainee.stripe',  $trainingProgram->id);
        } else {
            $data = ['trainee_id' => $trainee->id, 'training_program_id' => $trainingProgram->id, 'status' => 'pending'];
            if ($trainingProgram->advisor_id) {
                $data['advisor_id'] = $trainingProgram->advisor_id;
            }
            $data['fees_paid'] = 0;
            $training_program_user = $trainingProgram->training_program_users()->create($data);
            if ($training_program_user) {
                $mailable = new TraineeTrainingProgramEnrollmentMail($trainee, $trainingProgram);
                $this->sendEmail($trainee->email, $mailable);
                $message = "$trainee->displayName has requested to enroll in $trainingProgram->name training program";
                // send notification to all managers
                $managers = \App\Models\Manager::all();
                foreach ($managers as $manager) {
                    $manager->notify(new ManagerNotification(null, null, $message));
                }
                return redirect()->back()->with(['success' => 'Your request has been sent successfully and waiting for approval!', 'type' => 'success']);
            } else {
                return redirect()->back()->with(['fail' => 'Something is wrong!', 'type' => 'error']);
            }
        }
    }

    public function training_attendance()
    {
        $training_programs = auth_trainee()->approved_training_programs()->with('training_attendances')->get();
        $paginate = 5;
        $attendance_histories = auth_trainee()->attendance_histories()->paginate($paginate);
        return view('trainee.training_attendance', compact('training_programs', 'attendance_histories'));
    }

    public function post_training_attendance(Request $request)
    {
        $request->validate([
            'training_program_id' => 'required|exists:training_programs,id',
            'training_attendance_id' => 'required|exists:training_attendances,id',
            'date' => 'required|date',
            'attendance_status' => 'required|in:present,absent,late,excused',
            'notes' => 'nullable|string|max:255',
        ]);

        $training_program = TrainingProgram::find($request->training_program_id);
        $training_attendance = $training_program->training_attendances()->find($request->training_attendance_id);
        $training_attendance_trainee = new TrainingAttendanceTrainee();
        $training_attendance_trainee->trainee_id = auth_trainee()->id;
        $training_attendance_trainee->training_attendance_id = $training_attendance->id;
        $training_attendance_trainee->attendance_date = $request->date;
        $training_attendance_trainee->attendance_status = $request->attendance_status;
        $training_attendance_trainee->notes = $request->notes;
        $status = $training_attendance_trainee->save();
        return redirect()->back()->with([$status ? 'success' : 'fail' => $status ? 'Your attendance has been recorded successfully!' : 'Something is wrong!', 'type' => $status ? 'success' : 'error']);
    }


    public function request_meeting()
    {
        $trainee = auth_trainee();
        $advisors = $trainee->advisors()->get();
        return view('trainee.request_meeting', compact('advisors'));
    }

    public function schedule_meeting(ScheduleMeetingRequest $request)
    {
        $trainee = auth_trainee();
        $advisor = \App\Models\Advisor::find($request->advisor);
        $meeting = new \App\Models\Meeting;
        $meeting->trainee_id = $trainee->id;
        $meeting->advisor_id = $advisor->id;
        $meeting->date = $request->date;
        $meeting->time = $request->time;
        $meeting->location = $request->location;
        $meeting->notes = $request->notes;
        $status = $meeting->save();
        // Notify the advisor
        $advisor->notify(new AdvisorNotification(null, $trainee, 'A trainee has requested a meeting with you!'));
        return redirect()->back()->with([$status ? 'success' : 'fail' => $status ? 'Your meeting has been scheduled successfully!' : 'Something is wrong!', 'type' => $status ? 'success' : 'error']);
    }


    public function edit()
    {
        $disciplines = \App\Models\Discipline::withoutTrashed()->select('id', 'name')->get();
        return view('trainee.edit', compact('disciplines'));
    }

    public function update(Trainee $trainee)
    {
        $data = request()->validate([
            'displayName' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:trainees,email,' . $trainee->id,
            'phone' => 'required|string|max:255|unique:trainees,phone,' . $trainee->id,
            'address' => 'required|string|max:255',
            'disciplines' => 'required|array|min:1',
            'avatar-image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg',
            'cv-file' => 'nullable|mimes:pdf,doc,docx,txt,rtf,odt,ods,odp,odg,odc,odb,xls,xlsx,ppt,pptx',
        ]);

        // Check if the user uploaded a new avatar image
        if (request()->hasFile('avatar-image')) {
            // Delete the old avatar image from firebase storage
            if ($trainee->avatar) {
                $reference = app('firebase.storage')->getBucket()->object($trainee->avatar);
                if ($reference->exists()) {
                    $reference->delete();
                }
                $trainee->avatar_file->delete();
            }
            $avatarImage = request()->file('avatar-image');
            // Using firebase storage to upload files and make a record for File in the database linked with the trainee
            $avatar_file_name = $trainee->firebase_uid . '_trainee_avatar_image.' . $avatarImage->getClientOriginalExtension();
            $avatar_file_path = 'Trainee/Images/' . $avatar_file_name;
            $this->uploadFirebaseStorageFile($avatarImage, $avatar_file_path);

            // Create a file record in the database
            $file = new \App\Models\File;
            $file->name = $avatar_file_name;
            $file->firebase_file_path = $avatar_file_path;
            $file->extension = $avatarImage->getClientOriginalExtension();
            $file->trainee_id = $trainee->id;
            $file->description = 'Trainee Avatar Image';
            $size = $avatarImage->getSize();
            $file->size = $size ? $size : 0;
            $file->save();
        }

        // cv-file
        // Check if the user uploaded a new cv file
        if (request()->hasFile('cv-file')) {
            // Delete the old cv file from firebase storage
            if ($trainee->cv) {
                $reference = app('firebase.storage')->getBucket()->object($trainee->cv);
                if ($reference->exists()) {
                    $reference->delete();
                }
                $trainee->cv_file->delete();
            }
            $cvFile = request()->file('cv-file');
            // Using firebase storage to upload files and make a record for File in the database linked with the trainee
            $cv_file_name = $trainee->firebase_uid . '_trainee_cv_file.' . $cvFile->getClientOriginalExtension();
            $cv_file_path = 'Trainee/CVs/' . $cv_file_name;
            $this->uploadFirebaseStorageFile($cvFile, $cv_file_path);

            // Create a file record in the database
            $file = new \App\Models\File;
            $file->name = $cv_file_name;
            $file->firebase_file_path = $cv_file_path;
            $file->extension = $cvFile->getClientOriginalExtension();
            $file->trainee_id = $trainee->id;
            $file->description = 'Trainee CV File';
            $size = $cvFile->getSize();
            $file->size = $size ? $size : 0;
            $file->save();
        }


        // Check the disciplines selected by the user and remove the old disciplines and add the new ones
        $disciplines = $data['disciplines'];
        $trainee->disciplines()->detach();
        foreach ($disciplines as $discipline) {
            $trainee->disciplines()->attach($discipline);
        }

        // Check before update firebase user if the email or phone number is used before and not by the same user
        $auth = app('firebase.auth');
        try {
            $firebaseUser = $auth->getUserByEmail($data['email']);
            if ($firebaseUser->uid != $trainee->firebase_uid) {
                return redirect()->back()->with(['fail' => 'The email address is already in use by another account!', 'type' => 'error']);
            }
            // Update firebase user
            $user = $auth->getUser($trainee->firebase_uid);
            $auth->updateUser($user->uid, [
                'email' => $data['email'],
                'displayName' => $data['displayName'],
            ]);
            $trainee->email = $data['email'];
            $trainee->displayName = $data['displayName'];
            $trainee->phone = $data['phone'];
            $trainee->address = $data['address'];
            $status = $trainee->update($data);
            return redirect()->back()->with([$status ? 'success' : 'fail' => $status ? 'Your Information has been updated successfully!' : 'Something is wrong!', 'type' => $status ? 'success' : 'error']);
        } catch (\Throwable $th) { // If the email is not used before then the getUserByEmail will throw an exception
            // Do nothing
            return redirect()->back()->with(['fail' => $th->getMessage(), 'type' => 'error']);
        }
    }
}
