<?php

namespace App\Models;

use App\Models\Trainee;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Advisor extends Model
{
    use HasFactory;

    public function trainees()
    {
        return $this->hasMany(Trainee::class);
    }
}
