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
        'thumbnail_file_name',
        'location',
        'fees',
        'discipline_id',
        'duration',
        'duration_unit',
        'start_date',
        'end_date',
    ];

    public function discipline()
    {
        return $this->belongsTo(Discipline::class);
    }

    public function files()
    {
        return $this->hasMany(File::class);
    }

    public function getThumbnailAttribute()
    {
        return $this->files()->where('name', 'like', $this->thumbnail_file_name . '%')->first()?->url;
    }
}
