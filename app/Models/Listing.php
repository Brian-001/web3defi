<?php

namespace App\Models;

use Carbon\Carbon;
use App\Models\JobApplication;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Listing extends Model
{
    use HasFactory;

    protected $fillable = 
    [
        'listing_title', 
        'company_description', 
        'job_description', 
        'job_roles', 
        'additional_info', 
        'tags', 
        'location', 
        'salary', 
        'job_type',
        'listing_logo',
        'listing_status',
        'user_id'
    ];

    public function getCreatedAtFormattedAttribute()
    {
        return Carbon::parse($this->created_at)->diffForHumans([
            'parts' => 2,
            'short' => true,
            'short_units' => [
                'year' => 'y',
                'month' => 'm',
                'week' => 'w',
                'day' => 'd',
                'hour' =>'h',
                'minute' => 'min',
                'second' => 's'
            ]
        ]);
    }

    //Format job roles into an array, splitting by full stops

    public function getFormattedJobRolesAttribute(): array
    {
        //Split the job roles by full-stops and remove any empty values
        $jobRoles = array_filter(explode('.', $this->job_roles));

        //Trim whitespace from each job role
        $jobRoles = array_map('trim', $jobRoles);

        return $jobRoles;
    }

    public function jobApplications()
    {
        return $this->hasMany(JobApplication::class);
    }
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
