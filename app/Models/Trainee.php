<?php

namespace App\Models;

use App\Models\Advisor;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Trainee extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $appends = ['avatar', 'cv', 'email_verified'];
    protected $guard = 'trainee';
    protected $table = 'trainees';

    protected $fillable = [
        'firebase_uid',
        "auth_id", // This field is for autorization purposes
        'displayName',
        'email',
        'gender',
        'phone',
        'address',
        'localId',
    ];

    public function getAuthIdentifierName()
    {
        return 'localId';
    }
    public function getAuthIdentifier()
    {
        return $this->localId;
    }

    public function requested_meetings(){
        return $this->hasMany(Meeting::class, 'trainee_id');
    }

    public function files()
    {
        return $this->hasMany(File::class);
    }

    public function training_programs()
    {
        return $this->belongsToMany(TrainingProgram::class, 'training_program_users', 'trainee_id', 'training_program_id');
    }

    public function approved_training_programs()
    {
        return $this->belongsToMany(TrainingProgram::class, 'training_program_users', 'trainee_id', 'training_program_id')->wherePivot('status', 'approved');
    }

    public function training_requests()
    {
        return $this->hasMany(TrainingProgramUser::class, 'trainee_id');
    }

    public function getAvatarFileAttribute()
    {
        return $this->files()->where('name', 'like',  $this->firebase_uid . '_trainee_avatar_image%')->first();
    }

    public function getAvatarAttribute()
    {
        return $this->files()->where('name', 'like',  $this->firebase_uid . '_trainee_avatar_image%')->first()?->url;
    }


    public function getCvFileAttribute()
    {
        return $this->files()->where('name', 'like', $this->firebase_uid . '_trainee_cv%')->first();
    }

    public function getCvAttribute()
    {
        return $this->files()->where('name', 'like', $this->firebase_uid . '_trainee_cv%')->first()?->url;
    }

    public function sent_emails()
    {
        return $this->hasMany(AdvisorTraineeEmail::class, 'trainee_id')->where('sender', 'trainee')->latest();
    }

    public function getEmailVerifiedAttribute()
    {
        return app("firebase.auth")->getUser($this->firebase_uid)->emailVerified;
    }

    public function received_emails()
    {
        return $this->hasMany(AdvisorTraineeEmail::class, 'trainee_id')->withTrashed()->where('sender', 'advisor')->latest();
    }

    public function disciplines()
    {
        return $this->belongsToMany(Discipline::class, 'trainee_disciplines', 'trainee_id', 'discipline_id');
    }

    public function attendance_histories()
    {
        return $this->hasMany(TrainingAttendanceTrainee::class, 'trainee_id');
    }

    public function advisors()
    {
        return $this->belongsToMany(Advisor::class, 'training_program_users', 'trainee_id', 'advisor_id')->wherePivot('status', 'approved')->distinct();
    }

    public function hasDiscipline($id)
    {
        return $this->disciplines()->where('discipline_id', $id)->exists();
    }
}
