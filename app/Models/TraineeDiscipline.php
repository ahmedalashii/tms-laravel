<?php

namespace App\Models;

use App\Models\Trainee;
use App\Models\Discipline;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class TraineeDiscipline extends Model
{
    use HasFactory;

    protected $table = 'trainee_disciplines';

    protected $fillable = [
        'trainee_id',
        'discipline_id',
    ];

    public function trainee()
    {
        return $this->belongsTo(Trainee::class);
    }

    public function discipline()
    {
        return $this->belongsTo(Discipline::class);
    }
}
