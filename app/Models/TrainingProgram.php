<?php

namespace App\Models;

use App\Models\Discipline;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class TrainingProgram extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'name',
        'description',
        'thumbnail',
        'discipline_id',
        'duration',
        'start_date',
        'end_date',
    ];

    public function discipline()
    {
        return $this->belongsTo(Discipline::class);
    }
}
