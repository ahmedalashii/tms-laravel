<?php

namespace App\Models;

use App\Models\Advisor;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Trainee extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $appends = ['avatar', 'cv', 'email_verified'];
    protected $guard = 'trainee';
    protected $table = 'trainees';

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

    
    public function files()
    {
        return $this->hasMany(File::class);
    }


    public function getAvatarFileAttribute()
    {
        return $this->files()->where('name', 'like',  $this->firebase_uid . '_trainee_avatar_image%')->first();
    }

    public function getAvatarAttribute()
    {
        return $this->files()->where('name', 'like',  $this->firebase_uid . '_trainee_avatar_image%')->first()?->url;
    }


    public function getCvFileAttribute()
    {
        return $this->files()->where('name', 'like', $this->firebase_uid . '_trainee_cv%')->first();
    }

    public function getCvAttribute()
    {
        return $this->files()->where('name', 'like', $this->firebase_uid . '_trainee_cv%')->first()?->url;
    }


    public function getEmailVerifiedAttribute()
    {
        return app("firebase.auth")->getUser($this->firebase_uid)->emailVerified;
    }

    public function disciplines()
    {
        return $this->belongsToMany(Discipline::class, 'trainee_disciplines', 'trainee_id', 'discipline_id');
    }


    public function hasDiscipline($id)
    {
        return $this->disciplines()->where('discipline_id', $id)->exists();
    }
}
