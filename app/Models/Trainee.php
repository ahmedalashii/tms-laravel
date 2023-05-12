<?php

namespace App\Models;

use App\Models\Advisor;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Trainee extends Model
{
    use HasFactory;

    public function advisor()
    {
        return $this->belongsTo(Advisor::class);
    }
}
