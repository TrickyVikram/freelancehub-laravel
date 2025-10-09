<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Job extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'job_postings';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'title',
        'description',
        'company',
        'location',
        'salary',
        'job_type',
        'experience_level',
        'skills',
        'requirements',
        'benefits',
        'application_deadline',
        'is_active',
        'user_id',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'application_deadline' => 'date',
        'is_active' => 'boolean',
        'skills' => 'array',
    ];

    /**
     * Get the user that posted the job.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}