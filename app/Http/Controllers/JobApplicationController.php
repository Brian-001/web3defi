<?php

namespace App\Http\Controllers;

use App\Models\JobApplication;
use App\Models\Listing;
use Illuminate\Contracts\Support\ValidatedData;
use Illuminate\Http\Request;

class JobApplicationController extends Controller
{
    //

    public function showJobApplicationForm(Listing $listing)
    {
        return view('job_application.form', [
            'listing' => $listing,
        ]);
    }

    public function submitApplication(Request $request, Listing $listing)
    {
        //Validate the form data
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'resume_path' => 'required|file|mimes:pdf|max:2048'
        ]);

        //Save listing_id
        $validatedData['listing_id'] = $listing->id;

        //Save resume path
        if($request->hasFile('resume_path')){
            $resume_path = $request->file('resume_path')->store('resumes', 'public');
            $validatedData['resume_path'] = $resume_path;
        }
        

        //Save application data to database
        JobApplication::create($validatedData);
        // dd($validatedData);
        
        return redirect()->route('home')->with('success', 'Your application has been submitted successfully');
    }
}
