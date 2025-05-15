<?php

namespace App\Http\Controllers;

use App\Models\Listing;
use Illuminate\Http\Request;
use App\Models\JobApplication;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Redirect;
// use Illuminate\Contracts\Support\ValidatedData;

class JobApplicationController extends Controller
{
    //

    public function showJobApplicationForm(Listing $listing)
    {
        return view('job_application.form', ['listing' => $listing]);
    }

    public function submitApplication(Request $request, Listing $listing)
    {
        //Validate the form data
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'github' => 'required|url',
            'linkedin' => 'required|url',
            'resume_path' => 'required|file|mimes:pdf|max:2048'
        ]);

        //Prepare the data for saving
        $applicationData = [
            'listing_id' => $listing->id,
            'user_id' => Auth::check() ? Auth::user()->id : null, //Set user_id if authenticated
            'name' => $validatedData['name'],
            'email' => $validatedData['email'],
            'github' => $validatedData['github'],
            'linkedin' => $validatedData['linkedin'],
            'resume_path' => $request->file('resume_path')->store('resumes', 'public'),
            'application_type' => 'employee', //Set application type to 'employee'
            'referred_by' => null, //No referrer for direct applications
        ];


        //Save application data to database
        JobApplication::create($applicationData);
        
        notify()->success('Your application has been submitted successfully');
        return redirect()->route('home');
    }
}
