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

     public function __construct()
     {
        $this->middleware('auth')->except('index', 'show');
     }
    public function index()
    {
        //
        $listings = Listing::all();
        $tags = Tag::all();

        return view('index', compact('listings', 'tags'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
        $listings = Listing::all();
        $tags = Tag::all();
        // dd($tags);
        return view('listings.create', compact('listings', 'tags'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreListingRequest $request)
    {
        // Log validated request data for debugging
        Log::info($request->validated());

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
            'listing_title' => $request->input('listing_title'),
            'company_description' => $request->input('company_description'),
            'job_description' => $request->input('job_description'),
            'job_roles' => $request->input('job_roles'),
            'additional_info' => $request->input('additional_info'),
            // 'tags' => $request->input('tags'),
            'tags' => json_encode($request->input('tags')), // Store tags as JSON
            'location' => $request->input('location'),
            // Concatenate min and max salary into one string
            'salary' => $request->input('min_salary') . ' to ' . $request->input('max_salary'),
            'job_type' => $request->input('job_type'),
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
        $listing = Listing::findOrFail($listing->id);
        return view('listings.edit', compact('listing', 'tags'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateListingRequest $request, Listing $listing)
    {
        //
        $listingLogoPath = $listing->listing_logo;

        //Handle file upload if an image was provided
        if($request->hasFile('listing_logo') && $request->file('listing_logo')->isValid())
        {
            $listingLogoPath = $request->file('listing_logo')->store('logos', 'public');
        }
        $listing->update([
            'listing_title' => $request->input('listing_title'),
            'company_description' => $request->input('company_description'),
            'job_description' => $request->input('job_description'),
            'job_roles' => $request->input('job_roles'),
            'additional_info' => $request->input('additional_info'),
            'tags' => json_encode($request->input('tags')),
            'location' => $request->input('location'),
            'salary' => $request->input('min_salary') . ' to ' . $request->input('max_salary'),
            'job_type' => $request->input('job_type'),
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
