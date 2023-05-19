<?php

namespace App\Models;

use App\Models\Advisor;
use App\Models\Trainee;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Training extends Model
{
    use HasFactory;

    public function advisor()
    {
        return $this->belongsTo(Advisor::class);
    }

    public function trainee()
    {
        return $this->belongsTo(Trainee::class);
    }
}
