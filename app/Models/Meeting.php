<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Meeting extends Model
{
    use HasFactory;

    protected $fillable = [
        'advisor_id',
        'trainee_id',
        'date',
        'time',
        'location',
        'status',
        'notes',
    ];


    public function advisor()
    {
        return $this->belongsTo(Advisor::class);
    }


    public function trainee()
    {
        return $this->belongsTo(Trainee::class);
    }

    public function getFormattedDateAttribute()
    {
        return date('d M Y', strtotime($this->date));
    }
}
