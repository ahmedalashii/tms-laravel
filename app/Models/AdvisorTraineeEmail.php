<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AdvisorTraineeEmail extends Model
{
    use HasFactory;

    protected $fillable = [
        'advisor_id',
        'trainee_id',
        'subject',
        'message',
    ];

    public function advisor()
    {
        return $this->belongsTo(Advisor::class);
    }

    public function trainee()
    {
        return $this->belongsTo(Trainee::class);
    }
}
