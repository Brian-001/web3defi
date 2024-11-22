<?php

namespace App\Models;

use Carbon\Carbon;
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
        'listing_logo'
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
}
