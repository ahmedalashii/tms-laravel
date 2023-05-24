<?php

namespace App\Models;

use App\Models\Advisor;
use App\Models\Trainee;
use App\Models\TrainingProgram;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class TrainingProgramUser extends Model
{
    use HasFactory;

    protected $fillable = [
        'training_program_id',
        'trainee_id',
        'advisor_id',
        'status',
        'fees_paid',
    ];


    public function trainingProgram()
    {
        return $this->belongsTo(TrainingProgram::class);
    }

    public function trainee()
    {
        return $this->belongsTo(Trainee::class);
    }

    public function advisor()
    {
        return $this->belongsTo(Advisor::class);
    }
}
