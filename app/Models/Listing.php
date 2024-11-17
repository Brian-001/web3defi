<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

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
}
