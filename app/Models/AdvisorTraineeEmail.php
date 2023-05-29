<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class AdvisorTraineeEmail extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'advisor_id',
        'trainee_id',
        'subject',
        'message',
        'sender',
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
