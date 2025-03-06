<?php

namespace App\Http\Controllers;

use App\Models\Tag;
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
        $tags = Tag::all();
        // dd($tags);
        return view('listings.create', compact('tags'));
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
        ]);

        notify()->success('Job created successfully');

        return redirect()->back();
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
