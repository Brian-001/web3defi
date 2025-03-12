@extends('layouts.app-layouts')

@section('content')
    <div class="grid grid-cols-1 gap-4 items-center justify-center mb-10">
        <div class="bg-slate-600 p-6 rounded-lg shadow-lg w-full md:w-1/2 mt-10 md:mx-auto h-full">
            <div class="flex items-center justify-between flex-wrap">
                <a href="/" class="flex  gap-4">
                    <span class="text-white order-2">Back</span> 
                    <x-icons.arrow-uturn class="w-6 h-6 order-1" />
                </a>
                <div class="flex">
                    <p class="text-sm text-gray-200 opacity-50"><span>Posted: </span>{{ $listing->created_at_formatted }}</p>
                </div>
            </div>
            
            <div class="flex items-center justify-center mb-6">
                <h1 class="text-xl md:text-3xl text-cyan-400 mt-10">{{ $listing->listing_title}}</h1>
            </div>
            <div class="mx-4 mb-4">
                <h2 class="text-cyan-300">Company description</h2>
                <p class="text-slate-200 text-sm md:text-base tracking-wider">{{$listing->company_description}}</p>
            </div>
            <div class="mx-4 mb-4">
                <h2 class="text-cyan-300">Job Description</h2>
                <p class="text-slate-200 text-sm md:text-base md:tracking-wider">{{$listing->job_description}}</p>
            </div>

            <div class="mx-4 mb-4">
                <h2 class="text-cyan-300 mb-4">Job Roles</h2>
                @if(!empty($listing->formatted_job_roles) && is_array($listing->formatted_job_roles))
                    <ul class="ml-6 space-y-3">
                        @foreach($listing->formatted_job_roles as $jobRole)
                            <li class="text-slate-200 text-sm md:text-base md:tracking-wide flex items-start">
                                <span class="text-cyan-300 mr-2">•</span>
                                <span>{{ $jobRole }}</span>
                            </li>
                        @endforeach
                    </ul>
                @else
                    <p class="text-slate-200 text-sm italic">No job roles available.</p>
                @endif
            </div>
            {{-- Additional Information (Conditional) --}}
            @if (!empty($listing->additional_info))
            <div class="mb-4 mx-4 flex flex-col w-full">
                <h3 class="text-cyan-300 mb-2">Additional Information</h3>
                <div class="text-slate-200 text-sm md:text-base md:tracking-wide bg-slate-600 p-2 rounded-lg">
                    {{ $listing->additional_info }}
                </div>
            </div>
            @endif
            <div class="flex mt-2 mb-4 mx-4 gap-4 flex-wrap">
                @php
                    // Decode the JSON string into an array of tag IDs
                    $tagIds = json_decode($listing->tags, true) ?? [];
                    // Fetch the tags from the database
                    $tags = App\Models\Tag::whereIn('id', $tagIds)->pluck('tag_name')->toArray();
                @endphp
                @foreach ($tags as $tag)
                    <div class="bg-white text-slate-700 text-xs md:text-sm px-1 md:px-2 py-0.5 rounded-md md:rounded-full">{{ $tag }}</div>
                @endforeach
            </div>
            <div class="grid grid-cols-1 md:grid-cols-2">
                <div class="mx-4 mb-4">
                    <h2 class="text-cyan-300">Location</h2>
                    <p class="text-slate-200 text-sm md:tracking-wider">{{$listing->location}}</p>
                </div>
                <div class="mx-4 mb-4">
                    <h2 class="text-cyan-300">Estimated Salary</h2>
                    <p class="text-slate-200 text-sm md:tracking-wider"><span class="font-semibold text-white">$ </span>{{$listing->salary}} <span class="font-semibold text-white"> K</span></p>
                </div>
            </div>
            <div class="mx-4 mb-4">
                <h2 class="text-cyan-300">Job Type</h2>
                <p class="text-slate-200 text-sm md:tracking-wider">{{$listing->job_type}}</p>
            </div>
            <div class="flex items-center justify-center mx-4 mb-4">
                <a href="{{route('apply.form', $listing)}}" class="bg-cyan-300 text-gray-700 font-semibold rounded-lg py-3 w-1/2 flex items-center justify-center text-center hover:bg-cyan-500 hover:text-white">Apply</a>
            </div>
            {{-- <div class="flex items-center justify-start mx-4 mb-4">
                <a href="{{route('listings.edit', $listing)}}" class="bg-emerald-500 text-white font-semibold rounded-lg px-3 py-1.5 hover:bg-emerald-600">Edit</a>
            </div> --}}
        </div>

    </div>

@endsection