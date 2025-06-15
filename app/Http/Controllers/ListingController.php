<?php

namespace App\Http\Controllers;

use App\Models\Tag;
use App\Models\Listing;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Illuminate\Routing\Controller as BaseController;
use App\Http\Requests\StoreListingRequest;
use App\Http\Requests\UpdateListingRequest;

class ListingController extends BaseController
{
    /**
     * Display a listing of the resource.
     */

    // public function index()
    // {
    //     // Fetch all listings from the database
    //     $listings = Listing::where('listing_status', 'active')->get();
    //     Log::info('All Listings:', $listings->toArray());
        
    //     // Return the view with the listings data
    //     return view('listings.index', compact('listings'));
    // }

     public function __construct()
     {
        $this->middleware('auth')->except('show');
     }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
        // $listings = Listing::all();
        $tags = Tag::all();
        // dd($tags);
        return view('listings.create', compact('tags'));
    }

    //Show recruiter refer form
    public function refer(Listing $listing)
    {
        return view('listings.refer', compact('listing'));
    }

    /**
     * Store a newly created resource in storage.
     * @param \App\Http\Requests\StoreListingRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(StoreListingRequest $request)
    {
        $data =  $request->validated();
        Log::info('Listing data:', $data);
        
        //Initialize the variable for storing logo path
        $listingLogoPath = null; //Logo path for an image if at all listing_logo was not uploaded

        //Handle file upload if an image was provided
        if($request->hasFile('listing_logo') && $request->file('listing_logo')->isValid())
        {
            $listingLogoPath = $request->file('listing_logo')->store('logos', 'public');
            //Store in public/logos directory
        }
        // Create a new listing instance and save it to the database
        Listing::create([
            'listing_title' => $data['listing_title'],
            'company_description' => $data['company_description'],
            'job_description' => $data['job_description'],
            'job_roles' => $data['job_roles'],
            'additional_info' => $data['additional_info'],
            // 'tags' => $request->input('tags'),
            'tags' => json_encode($data['tags'] ?? []), // Store tags as JSON
            'location' => $data['location'],
            // Concatenate min and max salary into one string
            'salary' => $data['min_salary'] . ' to ' . $data['max_salary'],
            'job_type' => $data['job_type'],
            'listing_logo'=> $listingLogoPath,
            'user_id' => Auth::user()->id,
            'listing_status' => 'active', // Default status
        ]);

        notify()->success('Job created successfully');

        return redirect()->route('dashboard.job-management');
    }

    /**
     * Display the specified resource.
     */
    public function show(Listing $listing)
    {
        //
        Log::info('Listing Data:', $listing->toArray());
        return view('listings.show', compact('listing'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Listing $listing)
    {
        //
        $tags = Tag::all();
        // $listing = Listing::findOrFail($listing->id);
        return view('listings.edit', compact('listing', 'tags'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateListingRequest $request, Listing $listing)
    {
        $data = $request->validated();
        $listingLogoPath = $listing->listing_logo;

        //Handle file upload if an image was provided
        if($request->hasFile('listing_logo') && $request->file('listing_logo')->isValid())
        {
            //Delete the old logo if it exists
            if ($listingLogoPath) {
                \Storage::disk('public')->delete($listingLogoPath);
            }
            //Store the new logo
            $listingLogoPath = $request->file('listing_logo')->store('logos', 'public');
        }
        $listing->update([
            'listing_title' => $data['listing_title'],
            'company_description' => $data['company_description'],
            'job_description' => $data['job_description'],
            'job_roles' => $data['job_roles'],
            'additional_info' => $data['additional_info'] ?? null,
            'tags' => json_encode($data['tags'] ?? []), // Store tags as JSON
            'location' => $data['location'],
            'salary' => $data['min_salary'] . ' to ' . $data['max_salary'],
            'job_type' => $data['job_type'],
            'listing_logo' => $listingLogoPath,
        ]);
        notify()->success('Job updated successfully');
        return redirect()->route('dashboard.job-management');
        
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Listing $listing)
    {
        //
        $listing->delete();
        notify()->success('Job deleted successfully');
        return redirect()->route('dashboard.job-management');
    }
}
