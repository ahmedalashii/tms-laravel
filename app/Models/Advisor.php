<?php

namespace App\Models;

use App\Models\Discipline;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Advisor extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, SoftDeletes;
    
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $appends = ['avatar', 'cv', 'email_verified'];
    protected $guard = 'advisor';
    protected $table = 'advisors';

    protected $fillable = [
        'firebase_uid',
        "auth_id", // This field is for autorization purposes
        'displayName',
        'email',
        'gender',
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


    public function files()
    {
        return $this->hasMany(File::class);
    }


    public function getAvatarAttribute()
    {
        return $this->files()->where('name', 'like',  $this->firebase_uid . '_advisor_avatar_image%')->first()?->url;
    }

    public function getCvAttribute()
    {
        return $this->files()->where('name', 'like', $this->firebase_uid . '_advisor_cv%')->first()?->url;
    }


    public function getEmailVerifiedAttribute()
    {
        return app("firebase.auth")->getUser($this->firebase_uid)->emailVerified;
    }

    public function hasDiscipline($id)
    {
        return $this->disciplines()->where('discipline_id', $id)->exists();
    }
}
