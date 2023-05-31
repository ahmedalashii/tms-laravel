<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class TrainingProgramTask extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'training_program_id',
        'name',
        'description',
        'end_date',
        'file_name',
    ];

    protected $dates = [
        'end_date',
    ];

    public function trainingProgram()
    {
        return $this->belongsTo(TrainingProgram::class);
    }

    public function trainees()
    {
        return $this->trainingProgram->trainees();
    }

    public function files()
    {
        // This relation includes all files of the training program >> submissons and task files
        return $this->hasMany(File::class, 'task_id');
    }

    public function getSubmittedFileUrlAttribute()
    {
        return $this->files()->where('trainee_id', auth_trainee()->id)->first()->url ?? null;
    }


    public function getTraineeSubmittedFileUrl($trainee_id)
    {
        return $this->files()->where('trainee_id', $trainee_id)->first()->url ?? null;
    }

    public function file()
    {
        return $this->files()->where('name',  $this->file_name)->first();
    }

    public function getFileUrlAttribute()
    {
        return $this->files()->where('name', $this->file_name)->first()->url ?? null;
    }
}
