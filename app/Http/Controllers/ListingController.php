<?php

namespace App\Http\Controllers;

use App\Models\Listing;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Http\Requests\StoreListingRequest;

class ListingController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $listings = Listing::all();

        return view('index', compact('listings'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
        return view('listings.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreListingRequest $request)
    {
        // Log validated request data for debugging
        Log::info($request->validated());

        //Initialize the variable for storing logo path
        $listingLogoPath = 'storage\app\public\default_logo.jpg'; //Logo path for an image if at all listing_logo was not uploaded

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
            'tags' => $request->input('tags'),
            'location' => $request->input('location'),
            // Concatenate min and max salary into one string
            'salary' => $request->input('min_salary') . ' to ' . $request->input('max_salary'),
            'job_type' => $request->input('job_type'),
            'listing_logo'=> $listingLogoPath,
        ]);

        return redirect()->back()->with('success', 'Job created successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(Listing $listing)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Listing $listing)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Listing $listing)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Listing $listing)
    {
        //
    }
}
