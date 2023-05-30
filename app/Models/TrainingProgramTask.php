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

    public function file()
    {
        return $this->hasOne(File::class, 'task_id');
    }

    public function getFileUrlAttribute()
    {
        return $this->file()->first()->url ?? null;
    }
}
