<?php

namespace App\Http\Controllers\Manager;

use App\Models\Advisor;
use App\Models\Manager;
use App\Models\Trainee;
use App\Models\Discipline;
use Illuminate\Http\Request;
use App\Models\TrainingProgram;
use App\Mail\EmailVerificationMail;
use App\Mail\ManagerActivationMail;
use App\Models\TrainingProgramUser;
use App\Http\Controllers\Controller;
use App\Http\Traits\EmailProcessing;
use Illuminate\Support\Facades\Auth;
use App\Mail\AdvisorAuthorizationMail;
use App\Mail\TraineeAuthorizationMail;
use App\Notifications\AdvisorNotification;
use App\Notifications\TraineeNotification;
use App\Mail\TraineeTrainingProgramRejectMail;
use App\Mail\TraineeTrainingProgramApproveMail;
use App\Http\Traits\FirebaseStorageFileProcessing;

class ManagerController extends Controller
{
    use FirebaseStorageFileProcessing, EmailProcessing;

    public function index()
    {
        $training_requests = TrainingProgramUser::where('status', 'pending')->orderBy('created_at', 'desc')->take(5)->get();
        return view('manager.index', compact('training_requests'));
    }

    public function training_requests()
    {
        $paginate = 5;
        $training_requests = TrainingProgramUser::where('status', 'pending')->paginate($paginate);
        return view('manager.training_requests', compact('training_requests'));
    }

    public function read_notifications()
    {
        $manager = auth_manager();
        $notifications = $manager->notifications();
        $notifications->update(['read_at' => now()]);
        return response()->json(['success' => true]);
    }

    public function approve_training_request($id)
    {
        $training_request = TrainingProgramUser::find($id);
        $training_request->status = 'approved';
        $status = $training_request->save();
        $trainee = $training_request->trainee;
        $trainingProgram = $training_request->trainingProgram;
        // $advisor = $training_request->advisor;
        $manager = auth_manager();
        // TODO: add advisor to the mail + notification
        $mailable = new TraineeTrainingProgramApproveMail($trainee, $manager, $trainingProgram);
        $this->sendEmail($trainee->email, $mailable);
        $message = 'Your training request for ' . $trainingProgram->name . ' has been approved by ' . $manager->displayName . '.';
        $trainee->notify(new TraineeNotification($manager, null, $message));
        $advisor = $trainingProgram->advisor;
        if ($advisor) {
            $message = 'A trainee has been approved for your training program ' . $trainingProgram->name . '.';
            $advisor->notify(new AdvisorNotification($manager, null, $message));
        }
        return redirect()->back()->with([$status ? 'success' : 'fail' => $status ? 'Training Request Approved Successfully and an email/notification has been sent!' : 'Something is wrong!', 'type' => $status ? 'success' : 'error']);
    }

    public function update_training_criteria(Request $request)
    {
        // criteria imploded by new line
        $data = $request->validate([
            'criterion' => 'required|string|max:255',
        ]);
        // add this criterion to the training criterion
        $traininingCriterion = new \App\Models\TrainingCriterion;
        $traininingCriterion->name = $data['criterion'];
        $status = $traininingCriterion->save();
        return redirect()->back()->with([$status ? 'success' : 'fail' => $status ? 'Training Criterion Added Successfully' : 'Something is wrong!', 'type' => $status ? 'success' : 'error']);
    }

    public function reject_training_request($id)
    {
        $training_request = TrainingProgramUser::find($id);
        $training_request->status = 'rejected';
        $status = $training_request->save();
        $trainee = $training_request->trainee;
        $trainingProgram = $training_request->trainingProgram;
        // $advisor = $training_request->advisor;
        $manager = auth_manager();
        // TODO: add advisor to the mail + notification
        $mailable = new TraineeTrainingProgramRejectMail($trainee, $manager, $trainingProgram);
        $this->sendEmail($trainee->email, $mailable);
        $message = 'Your training request for ' . $trainingProgram->name . ' has been rejected by ' . $manager->displayName . '.';
        $trainee->notify(new TraineeNotification($manager, null, $message));
        return redirect()->back()->with([$status ? 'success' : 'fail' => $status ? 'Training Request Rejected Successfully and an email/notification has been sent!' : 'Something is wrong!', 'type' => $status ? 'success' : 'error']);
    }


    public function disciplines(Request $request)
    {
        $paginate = 5;
        $search_value = $request->query('search');
        $disciplines = Discipline::withTrashed()->where(function ($query) use ($search_value) {
            $query->where('name', 'LIKE', '%' . $search_value . '%')
                ->orWhere('description', 'LIKE', '%' . $search_value . '%');
        })->paginate($paginate);
        return view('manager.disciplines', compact('disciplines'));
    }


    public function create_discipline()
    {
        return view('manager.create_discipline');
    }

    public function store_discipline(Request $request)
    {
        // name, description
        $data = $request->validate([
            'name' => 'required|string|max:255|unique:disciplines,name',
            'description' => 'required|string|max:255',
        ]);
        $discipline = new Discipline;
        $discipline->name = $data['name'];
        $discipline->description = $data['description'];
        $status = $discipline->save();
        return redirect()->route('manager.disciplines')->with([$status ? 'success' : 'fail' => $status ? 'Discipline Created Successfully' : 'Something is wrong!', 'type' => $status ? 'success' : 'error']);
    }


    public function edit_discipline(Discipline $discipline)
    {
        return view('manager.edit_discipline', compact('discipline'));
    }

    public function update_discipline(Discipline $discipline)
    {
        // name, description
        $data = request()->validate([
            'name' => 'required|string|max:255|unique:disciplines,name,' . $discipline->id,
            'description' => 'required|string|max:255',
        ]);
        $discipline->name = $data['name'];
        $discipline->description = $data['description'];
        $status = $discipline->save();
        return redirect()->route('manager.disciplines')->with([$status ? 'success' : 'fail' => $status ? 'Discipline Updated Successfully' : 'Something is wrong!', 'type' => $status ? 'success' : 'error']);
    }

    public function deactivate_discipline(Discipline $discipline)
    {
        $destroy = $discipline->delete();
        return redirect()->back()->with([$destroy ? 'success' : 'fail' => $destroy ?  'Discipline Deactivated Successfully' : 'Something is wrong!', 'type' => $destroy ? 'success' : 'error']);
    }


    public function activate_discipline($id)
    {
        $status = Discipline::onlyTrashed()->find($id)->restore();
        return redirect()->back()->with([$status ? 'success' : 'fail' => $status ? 'Discipline Activated Successfully' : 'Something is wrong!', 'type' => $status ? 'success' : 'error']);
    }


    public function training_programs(Request $request)
    {
        // Get all training programs that their discipline is not soft deleted
        $paginate = 5;
        $discipline_id = $request->query('discipline');
        $advisor_id = $request->query('advisor');
        $search_value = $request->query('search');
        if ($discipline_id && $advisor_id) {
            $training_programs = TrainingProgram::withTrashed()->where('discipline_id', $discipline_id)->where('advisor_id', $advisor_id)->where(function ($query) use ($search_value) {
                $query->where('name', 'LIKE', '%' . $search_value . '%')
                    ->orWhere('description', 'LIKE', '%' . $search_value . '%')
                    ->orWhere('location', 'LIKE', '%' . $search_value . '%')
                    ->orWhere('fees', 'LIKE', '%' . $search_value . '%')
                    ->orWhere('start_date', 'LIKE', '%' . $search_value . '%')
                    ->orWhere('end_date', 'LIKE', '%' . $search_value . '%')
                    ->orWhere('duration', 'LIKE', '%' . $search_value . '%')
                    ->orWhere('duration_unit', 'LIKE', '%' . $search_value . '%');
            })->paginate($paginate);
        } else if ($advisor_id) {
            $training_programs = TrainingProgram::withTrashed()->where('advisor_id', $advisor_id)->where(function ($query) use ($search_value) {
                $query->where('name', 'LIKE', '%' . $search_value . '%')
                    ->orWhere('description', 'LIKE', '%' . $search_value . '%')
                    ->orWhere('location', 'LIKE', '%' . $search_value . '%')
                    ->orWhere('fees', 'LIKE', '%' . $search_value . '%')
                    ->orWhere('start_date', 'LIKE', '%' . $search_value . '%')
                    ->orWhere('end_date', 'LIKE', '%' . $search_value . '%')
                    ->orWhere('duration', 'LIKE', '%' . $search_value . '%')
                    ->orWhere('duration_unit', 'LIKE', '%' . $search_value . '%');
            })->paginate($paginate);
        } else if ($discipline_id) {
            $training_programs = TrainingProgram::withTrashed()->where('discipline_id', $discipline_id)->where(function ($query) use ($search_value) {
                $query->where('name', 'LIKE', '%' . $search_value . '%')
                    ->orWhere('description', 'LIKE', '%' . $search_value . '%')
                    ->orWhere('location', 'LIKE', '%' . $search_value . '%')
                    ->orWhere('fees', 'LIKE', '%' . $search_value . '%')
                    ->orWhere('start_date', 'LIKE', '%' . $search_value . '%')
                    ->orWhere('end_date', 'LIKE', '%' . $search_value . '%')
                    ->orWhere('duration', 'LIKE', '%' . $search_value . '%')
                    ->orWhere('duration_unit', 'LIKE', '%' . $search_value . '%');
            })->paginate($paginate);
        } else {
            $training_programs = TrainingProgram::withTrashed()->where(function ($query) use ($search_value) {
                $query->where('name', 'LIKE', '%' . $search_value . '%')
                    ->orWhere('description', 'LIKE', '%' . $search_value . '%')
                    ->orWhere('location', 'LIKE', '%' . $search_value . '%')
                    ->orWhere('fees', 'LIKE', '%' . $search_value . '%')
                    ->orWhere('start_date', 'LIKE', '%' . $search_value . '%')
                    ->orWhere('end_date', 'LIKE', '%' . $search_value . '%')
                    ->orWhere('duration', 'LIKE', '%' . $search_value . '%')
                    ->orWhere('duration_unit', 'LIKE', '%' . $search_value . '%');
            })->paginate($paginate);
        }
        $disciplines = Discipline::select('id', 'name')->get();
        $advisors = Advisor::withoutTrashed()->whereNotNull('auth_id')->select('id', 'displayName')->get();
        return view('manager.training_programs', compact('training_programs', 'disciplines', 'advisors'));
    }

    public function create_training_program()
    {
        $disciplines = \App\Models\Discipline::withoutTrashed()->select('id', 'name')->get();
        $duration_units = ['days' => 'Days', 'weeks' => 'Weeks', 'months' => 'Months', 'years' => 'Years'];
        $advisors = Advisor::withoutTrashed()->select('id', 'displayName')->get();
        return view('manager.create_training_program', compact('disciplines', 'duration_units', 'advisors'));
    }


    public function store_training_program(Request $request)
    {
        if ($request->advisor_id) {
            $advisor = Advisor::withoutTrashed()->find($request->advisor_id);
            // advisor_id must be exists in the database and must be an advisor and has the discipline_id is in the disciplines of the advisor (an advisor may have more than one discipline)
            if (!$advisor) {
                return redirect()->back()->with(['fail' => 'Advisor not found!', 'type' => 'error']);
            }
            if (!$advisor->hasDiscipline($request->discipline_id)) {
                return redirect()->back()->with(['fail' => 'Advisor does not have this discipline!', 'type' => 'error']);
            }
        }

        $data = $request->validate([
            'name' => 'required|string|max:255',
            'discipline_id' => 'required|exists:disciplines,id',
            'advisor_id' => 'nullable|exists:advisors,id',
            'thumbnail' => 'required|image|mimes:jpeg,png,jpg,gif,svg',
            'description' => 'required|string|max:255',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after:start_date',
            'fees' => 'nullable|numeric|min:0',
            'duration' => 'required|numeric|min:0',
            'duration_unit' => 'required|in:days,weeks,months,years',
            'location' => 'required|string|max:255',
            'capacity' => 'required|numeric|min:5|max:100',
        ]);
        $trainingProgram = new TrainingProgram;
        $trainingProgram->name = $data['name'];
        $trainingProgram->discipline_id = $data['discipline_id'];
        $trainingProgram->advisor_id = $data['advisor_id'];
        $trainingProgram->description = $data['description'];
        $trainingProgram->start_date = $data['start_date'];
        $trainingProgram->end_date = $data['end_date'];
        $trainingProgram->fees = $data['fees'];
        $trainingProgram->duration = $data['duration'];
        $trainingProgram->duration_unit = $data['duration_unit'];
        $trainingProgram->location = $data['location'];
        $trainingProgram->capacity = $data['capacity'];
        // Upload Thumbnail
        $thumbnailImage = $request->file('thumbnail');
        // Using firebase storage to upload files and make a record for File in the database linked with the TrainingProgram
        $thumbnail_file_name = $data['name'] . '_' . time() . '.' . $thumbnailImage->getClientOriginalExtension();
        $thumbnail_file_path = 'TrainingProgram/Thumbnails/' . $thumbnail_file_name;
        $this->uploadFirebaseStorageFile($thumbnailImage, $thumbnail_file_path);
        $trainingProgram->thumbnail_file_name = $thumbnail_file_name;
        $status = $trainingProgram->save();

        // Create a file record in the database
        $file = new \App\Models\File;
        $file->name = $thumbnail_file_name;
        $file->firebase_file_path = $thumbnail_file_path;
        $file->extension = $thumbnailImage->getClientOriginalExtension();
        $file->training_program_id = $trainingProgram->id;
        $file->description = 'Thumbnail for ' . $trainingProgram->name;
        $size = $thumbnailImage->getSize();
        $file->size = $size ? $size : 0;
        $file->save();
        return redirect()->route('manager.training-programs')->with([$status ? 'success' : 'fail' => $status ? 'Training Program Created Successfully' : 'Something is wrong!', 'type' => $status ? 'success' : 'error']);
    }


    public function edit_training_program(TrainingProgram $trainingProgram)
    {
        $disciplines = \App\Models\Discipline::withoutTrashed()->select('id', 'name')->get();
        $duration_units = ['days' => 'Days', 'weeks' => 'Weeks', 'months' => 'Months', 'years' => 'Years'];
        $advisors = Advisor::withoutTrashed()->select('id', 'displayName')->get();
        return view('manager.edit_training_program', compact('trainingProgram', 'disciplines', 'duration_units', 'advisors'));
    }


    public function update_training_program(Request $request, TrainingProgram $trainingProgram)
    {

        if ($request->advisor_id) {
            $advisor = Advisor::withoutTrashed()->find($request->advisor_id);
            // advisor_id must be exists in the database and must be an advisor and has the discipline_id is in the disciplines of the advisor (an advisor may have more than one discipline)
            if (!$advisor) {
                return redirect()->back()->with(['fail' => 'Advisor not found!', 'type' => 'error']);
            }
            if (!$advisor->hasDiscipline($request->discipline_id)) {
                return redirect()->back()->with(['fail' => 'Advisor does not have this discipline!', 'type' => 'error']);
            }
        }

        $data = request()->validate([
            'name' => 'required|string|max:255',
            'discipline_id' => 'required|exists:disciplines,id',
            'advisor_id' => 'nullable|exists:advisors,id',
            'thumbnail' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg',
            'description' => 'required|string|max:255',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after:start_date',
            'fees' => 'nullable|numeric|min:0',
            // currency and required if fees is not null
            'duration' => 'required|numeric|min:0',
            'duration_unit' => 'required|in:days,weeks,months,years',
            'location' => 'required|string|max:255',
            'capacity' => 'required|numeric|min:5|max:100|gte:users_length',
        ]);

        $trainingProgram->name = $data['name'];
        $trainingProgram->discipline_id = $data['discipline_id'];
        $trainingProgram->advisor_id = $data['advisor_id'];
        $trainingProgram->description = $data['description'];
        $trainingProgram->start_date = $data['start_date'];
        $trainingProgram->end_date = $data['end_date'];
        $trainingProgram->fees = $data['fees'];
        $trainingProgram->duration = $data['duration'];
        $trainingProgram->duration_unit = $data['duration_unit'];
        $trainingProgram->location = $data['location'];
        $trainingProgram->capacity = $data['capacity'];

        // Each training program user in the training program must be updated if it doesn't have an advisor
        $trainingProgramUsers = $trainingProgram->training_program_users()->whereNull('advisor_id')->get();
        foreach ($trainingProgramUsers as $trainingProgramUser) {
            $trainingProgramUser->advisor_id = $data['advisor_id'];
            $trainingProgramUser->save();
        }

        if (request()->hasFile('thumbnail')) {
            // Upload Thumbnail
            $thumbnailImage = request()->file('thumbnail');
            // Using firebase storage to upload files and make a record for File in the database linked with the TrainingProgram
            $thumbnail_file_name = $data['name'] . '_' . time() . '.' . $thumbnailImage->getClientOriginalExtension();
            $thumbnail_file_path = 'TrainingProgram/Thumbnails/' . $thumbnail_file_name;
            $this->uploadFirebaseStorageFile($thumbnailImage, $thumbnail_file_path);
            if ($trainingProgram->thumbnail_file_name) {
                // Delete the old thumbnail file
                $old_thumbnail_file = $trainingProgram->files()->where('name', 'like', $trainingProgram->thumbnail_file_name . '%')->first();
                $this->deleteFirebaseStorageFile($old_thumbnail_file->firebase_file_path);
                $old_thumbnail_file->delete();
            }
            $trainingProgram->thumbnail_file_name = $thumbnail_file_name;
            // Create a file record in the database
            $file = new \App\Models\File;
            $file->name = $thumbnail_file_name;
            $file->firebase_file_path = $thumbnail_file_path;
            $file->extension = $thumbnailImage->getClientOriginalExtension();
            $file->training_program_id = $trainingProgram->id;
            $file->description = 'Thumbnail for ' . $trainingProgram->name;
            $size = $thumbnailImage->getSize();
            $file->size = $size ? $size : 0;
            $file->save();
        }
        $status = $trainingProgram->save();
        return redirect()->route('manager.training-programs')->with([$status ? 'success' : 'fail' => $status ? 'Training Program Updated Successfully' : 'Something is wrong!', 'type' => $status ? 'success' : 'error']);
    }


    public function authorize_trainees(Request $request)
    {
        $search_value = $request->search;
        $paginate = 5;
        $trainees = Trainee::withoutTrashed()->whereNull('auth_id')->where(function ($query) use ($search_value) {
            $query->where('displayName', 'LIKE', '%' . $search_value . '%')
                ->orWhere('email', 'LIKE', '%' . $search_value . '%')
                ->orWhere('phone', 'LIKE', '%' . $search_value . '%')
                ->orWhere('address', 'LIKE', '%' . $search_value . '%');
        })->paginate($paginate);
        return view('manager.authorize_trainees', compact('trainees'));
    }


    public function authorize_advisors(Request $request)
    {
        $search_value = $request->search;
        $paginate = 5;
        $advisors = Advisor::withoutTrashed()->whereNull('auth_id')->where(function ($query) use ($search_value) {
            $query->where('displayName', 'LIKE', '%' . $search_value . '%')
                ->orWhere('email', 'LIKE', '%' . $search_value . '%')
                ->orWhere('phone', 'LIKE', '%' . $search_value . '%')
                ->orWhere('address', 'LIKE', '%' . $search_value . '%');
        })->paginate($paginate);
        return view('manager.authorize_advisors', compact('advisors'));
    }




    public function trainees(Request $request)
    {
        $search_value = $request->search;
        $paginate = 5;
        $trainees = Trainee::withTrashed()->where(function ($query) use ($search_value) {
            $query->where('displayName', 'LIKE', '%' . $search_value . '%')
                ->orWhere('email', 'LIKE', '%' . $search_value . '%')
                ->orWhere('phone', 'LIKE', '%' . $search_value . '%')
                ->orWhere('address', 'LIKE', '%' . $search_value . '%');
        })->paginate($paginate);
        return view('manager.trainees', compact('trainees'));
    }

    public function advisors(Request $request)
    {
        $search_value = $request->search;
        $paginate = 5;
        $advisors = Advisor::where(function ($query) use ($search_value) {
            $query->where('displayName', 'LIKE', '%' . $search_value . '%')
                ->orWhere('email', 'LIKE', '%' . $search_value . '%')
                ->orWhere('phone', 'LIKE', '%' . $search_value . '%')
                ->orWhere('address', 'LIKE', '%' . $search_value . '%');
        })->paginate($paginate);
        return view('manager.advisors', compact('advisors'));
    }

    public function managers(Request $request)
    {
        $manager = Auth::guard('manager')->user();
        $manager_db = Manager::where('firebase_uid', $manager->localId)->first();
        if ($manager_db->role == 'super_manager') {
            // Managers that are not super managers except the current logged in manager
            $search_value = $request->search;
            $paginate = 5;
            $managers = Manager::where('role', '!=', 'super_manager')->where('firebase_uid', '!=', $manager->localId)->where(function ($query) use ($search_value) {
                $query->where('displayName', 'LIKE', '%' . $search_value . '%')
                    ->orWhere('email', 'LIKE', '%' . $search_value . '%')
                    ->orWhere('phone', 'LIKE', '%' . $search_value . '%')
                    ->orWhere('address', 'LIKE', '%' . $search_value . '%');
            })->paginate($paginate);
            return view('manager.managers', compact('managers'));
        }
        return redirect()->back()->with(['fail' => 'You are not authorized to access this page!', 'type' => 'error']);
    }

    public function authorize_trainee(Trainee $trainee)
    {
        // Unique Generated ID for the trainee (auth_id) that will be used to login to the system and never taken before
        $auth_id = uniqid();
        while (Trainee::where('auth_id', $auth_id)->exists()) {
            $auth_id = uniqid();
        }
        // Send Email to the trainee with the auth_id
        $trainee->auth_id = $auth_id;
        $manager = Auth::guard('manager')->user();
        $mailable = new TraineeAuthorizationMail($trainee, $manager);
        $this->sendEmail($trainee->email, $mailable);
        $status = $trainee->save();
        return redirect()->back()->with([$status ? 'success' : 'fail' => $status ? 'Trainee Authorized Successfully and an email has been sent!' : 'Something is wrong!', 'type' => $status ? 'success' : 'error']);
    }

    public function authorize_advisor(Advisor $advisor)
    {
        // Unique Generated ID for the trainee (auth_id) that will be used to login to the system and never taken before
        $auth_id = uniqid();
        while (Advisor::where('auth_id', $auth_id)->exists()) {
            $auth_id = uniqid();
        }
        // Send Email to the trainee with the auth_id
        $advisor->auth_id = $auth_id;
        $manager = Auth::guard('manager')->user();
        $mailable = new AdvisorAuthorizationMail($advisor, $manager);
        $this->sendEmail($advisor->email, $mailable);
        $status = $advisor->save();
        return redirect()->back()->with([$status ? 'success' : 'fail' => $status ? 'Advisor Authorized Successfully and an email has been sent!' : 'Something is wrong!', 'type' => $status ? 'success' : 'error']);
    }

    public function activate_manager(Manager $manager)
    {
        $manager->is_active = true;
        $status = $manager->save();
        $mailable = new ManagerActivationMail($manager);
        $this->sendEmail($manager->email, $mailable);
        return redirect()->back()->with([$status ? 'success' : 'fail' => $status ? 'Manager Activated Successfully and an email has been sent!' : 'Something is wrong!', 'type' => $status ? 'success' : 'error']);
    }


    public function deactivate_manager(Manager $manager)
    {
        $manager->is_active = false;
        $status = $manager->save();
        return redirect()->back()->with([$status ? 'success' : 'fail' => $status ? 'Manager Deactivated Successfully!' : 'Something is wrong!', 'type' => $status ? 'success' : 'error']);
    }


    public function deactivate_training_program(TrainingProgram $trainingProgram)
    {
        $destroy = $trainingProgram->delete();
        return redirect()->back()->with([$destroy ? 'success' : 'fail' => $destroy ?  'Training Program Deactivated Successfully' : 'Something is wrong!', 'type' => $destroy ? 'success' : 'error']);
    }


    public function activate_training_program($id)
    {
        $status = TrainingProgram::onlyTrashed()->find($id)->restore();
        return redirect()->back()->with([$status ? 'success' : 'fail' => $status ? 'Training Program Activated Successfully' : 'Something is wrong!', 'type' => $status ? 'success' : 'error']);
    }

    public function verify_trainee(Trainee $trainee)
    {
        $auth = app('firebase.auth');
        $verification_url = $auth->getEmailVerificationLink($trainee->email);
        $firebaseUser = $auth->getUserByEmail($trainee->email);
        $mailable = new EmailVerificationMail($firebaseUser, $verification_url);
        $this->sendEmail($trainee->email, $mailable);
        return redirect()->back()->with(['success' => 'Email Verification Link Sent Successfully!', 'type' => 'success']);
    }

    public function verify_advisor(Advisor $advisor)
    {
        $auth = app('firebase.auth');
        $verification_url = $auth->getEmailVerificationLink($advisor->email);
        $firebaseUser = $auth->getUserByEmail($advisor->email);
        $mailable = new EmailVerificationMail($firebaseUser, $verification_url);
        $this->sendEmail($advisor->email, $mailable);
        return redirect()->back()->with(['success' => 'Email Verification Link Sent Successfully!', 'type' => 'success']);
    }


    public function deactivate_trainee(Trainee $trainee)
    {
        /*
            Soft Delete:
            deleted_at >> timestamp >> null
            when deleting the row >> deleted_at = current timestamp 
        */
        $destroy = $trainee->delete();
        return redirect()->back()->with([$destroy ? 'success' : 'fail' => $destroy ?  'Trainee Deactivated Successfully' : 'Something is wrong!', 'type' => $destroy ? 'success' : 'error']);
    }

    public function activate_trainee($id)
    {
        $status = Trainee::onlyTrashed()->find($id)->restore();
        return redirect()->back()->with([$status ? 'success' : 'fail' => $status ? 'Trainee Activated Successfully' : 'Something is wrong!', 'type' => $status ? 'success' : 'error']);
    }


    public function deactivate_advisor(Advisor $advisor)
    {
        /*
            Soft Delete:
            deleted_at >> timestamp >> null
            when deleting the row >> deleted_at = current timestamp 
        */
        $destroy = $advisor->delete();
        return redirect()->back()->with([$destroy ? 'success' : 'fail' => $destroy ?  'Advisor Deactivated Successfully' : 'Something is wrong!', 'type' => $destroy ? 'success' : 'error']);
    }

    public function activate_advisor($id)
    {
        $status = Advisor::onlyTrashed()->find($id)->restore();
        return redirect()->back()->with([$status ? 'success' : 'fail' => $status ? 'Advisor Activated Successfully' : 'Something is wrong!', 'type' => $status ? 'success' : 'error']);
    }


    public function issues()
    {
        return view('manager.issues');
    }

    public function issue_response()
    {
        return view('manager.issue_response');
    }

    public function edit_trainee(Trainee $trainee)
    {
        return view('manager.edit_trainee ', compact('trainee'));
    }

    public function update_trainee(Trainee $trainee)
    {
        $data = request()->validate([
            'displayName' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:trainees,email,' . $trainee->id,
            'phone' => 'required|string|max:255|unique:trainees,phone,' . $trainee->id,
            'address' => 'required|string|max:255',
        ]);
        // Check before update firebase user if the email or phone number is used before and not by the same user
        $auth = app('firebase.auth');
        $firebaseUser = $auth->getUserByEmail($trainee->email);
        if ($firebaseUser) {
            if ($firebaseUser->uid != $trainee->firebase_uid) {
                return redirect()->back()->with(['fail' => 'Email or Phone Number is already taken!', 'type' => 'error']);
            }
        }
        // Update firebase user
        $user = $auth->getUser($trainee->firebase_uid);
        $auth->updateUser($user->uid, [
            'email' => $data['email'],
            'displayName' => $data['displayName'],
        ]);
        $status = $trainee->update($data);
        return redirect()->back()->with([$status ? 'success' : 'fail' => $status ? 'Trainee Updated Successfully' : 'Something is wrong!', 'type' => $status ? 'success' : 'error']);
    }
}
