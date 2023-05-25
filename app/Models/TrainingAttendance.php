<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TrainingAttendance extends Model
{
    use HasFactory;

    protected $fillable = [
        'training_program_id',
        'attendance_day',
        'start_time',
        'end_time',
    ];

    public function training_program()
    {
        return $this->belongsTo(TrainingProgram::class);
    }
}
