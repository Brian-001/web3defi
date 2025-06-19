<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JobApplication extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'listing_id', 
        'user_id', 
        'name', 
        'email', 
        'github', 
        'linkedin', 
        'resume_path', 
        'answers',
        'application_type',
        'referred_by',
        'application_status',
    ];

    protected $casts = [
        'answers' => 'array',
        'application_type' => 'string',
    ];

    public function listing()
    {
        return $this->belongsTo(Listing::class, 'listing_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function referrer()
    {
        return $this->belongsTo(User::class, 'referred_by');
    }
}
