<?php

namespace App\Http\Controllers;

use App\Models\Listing;
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
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'resume' => 'required|file|mimes:pdf|max:2048'
        ]);

        //Save resume path
        $resumePath = $request->file('resume')->store('/storage', 'resumes');

        //Save application data to database
        
        return redirect()->route('home')->with('success', 'Your application has been submitted successfully');
    }
}
