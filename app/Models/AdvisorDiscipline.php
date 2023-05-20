<?php

namespace App\Models;

use App\Models\Advisor;
use App\Models\Discipline;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class AdvisorDiscipline extends Model
{
    use HasFactory;

    protected $table = 'advisor_disciplines';

    protected $fillable = [
        'advisor_id',
        'discipline_id',
    ];

    public function advisor()
    {
        return $this->belongsTo(Advisor::class);
    }

    public function discipline()
    {
        return $this->belongsTo(Discipline::class);
    }
}
