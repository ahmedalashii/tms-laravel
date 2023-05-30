<?php

namespace App\Models;

use App\Models\Discipline;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class TrainingProgram extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'name',
        'description',
        'thumbnail_file_name',
        'location',
        'fees',
        'discipline_id',
        'advisor_id',
        'duration',
        'duration_unit',
        'start_date',
        'end_date',
        'capacity',
    ];

    public function discipline()
    {
        return $this->belongsTo(Discipline::class)->withTrashed();
    }

    public function trainees(){
        return $this->belongsToMany(Trainee::class, 'training_program_users', 'training_program_id', 'trainee_id')->wherePivot('status', 'approved');
    }

    public function advisor(){
        return $this->belongsTo(Advisor::class)->withTrashed();
    }


    public function tasks(){
        return $this->hasMany(TrainingProgramTask::class, 'training_program_id');
    }

    public function files()
    {
        return $this->hasMany(File::class);
    }

    public function getThumbnailAttribute()
    {
        return $this->files()->where('name', 'like', $this->thumbnail_file_name . '%')->first()?->url;
    }

    public function training_program_users()
    {
        return $this->hasMany(TrainingProgramUser::class);
    }

    public function current_trainee_history()
    {
        return $this->training_program_users()->where('trainee_id', auth_trainee()->id)->first();
    }

    public function getTraineeStatusAttribute(){
        return $this->training_program_users()->where('trainee_id', auth_trainee()->id)->first()?->status;
    }

    public function training_attendances()
    {
        return $this->hasMany(TrainingAttendance::class);
    }

    public function getUsersLengthAttribute()
    {
        return $this->training_program_users()->where('status', 'approved')->count();
    }
}
