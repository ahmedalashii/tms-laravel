<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TrainingAttendanceTrainee extends Model
{
    use HasFactory;

    protected $table = 'training_attendance_trainees';

    protected $fillable = [
        'training_attendance_id',
        'trainee_id',
        'attendance_status',
        'attendance_date',
    ];

    public function trainee()
    {
        return $this->belongsTo(Trainee::class, 'trainee_id');
    }

    public function training_attendance()
    {
        return $this->belongsTo(TrainingAttendance::class, 'training_attendance_id');
    }
}
