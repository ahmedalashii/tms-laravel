<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Http\Traits\FirebaseStorageFileProcessing;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class File extends Model
{
    protected $appends = ['url'];
    use HasFactory, FirebaseStorageFileProcessing;
    protected $fillable = [
        'name',
        'firebase_file_path',
        'extension',
        'trainee_id',
        'manager_id',
        'advisor_id',
    ];

    public function trainee()
    {
        return $this->belongsTo(Trainee::class);
    }

    public function manager()
    {
        return $this->belongsTo(Manager::class);
    }

    public function advisor()
    {
        return $this->belongsTo(Advisor::class);
    }

    public function getUrlAttribute()
    {
        return $this->getUploadedFirebaseFileURL($this->firebase_file_path);
    }
}
