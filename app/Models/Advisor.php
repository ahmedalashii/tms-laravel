<?php

namespace App\Models;

use Laravel\Sanctum\HasApiTokens;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Advisor extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;
    protected $table = 'advisors';
    protected $guard = 'advisor';
    protected $fillable = [
        'firebase_uid',
        'displayName',
        'email',
        'phone',
        'address',
        'localId',
    ];

    public function getAuthIdentifierName()
    {
        return 'localId';
    }
    public function getAuthIdentifier()
    {
        return $this->localId;
    }

    public function disciplines()
    {
        return $this->belongsToMany(Discipline::class, 'advisor_disciplines', 'advisor_id', 'discipline_id');
    }
}
