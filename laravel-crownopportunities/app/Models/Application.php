<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;

class Application extends Model
{
    use HasFactory, HasUuids;

    protected $fillable = [
        'job_id',
        'first_name',
        'last_name',
        'email',
        'phone',
        'current_location',
        'profile_photo',
        'cv_file',
        'cover_letter',
        'experience',
        'previous_role',
        'status',
    ];

    public function job()
    {
        return $this->belongsTo(Job::class);
    }
}
