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
            
            <div class="flex items-center justify-center">
                <h1 class="text-xl md:text-3xl text-cyan-400 mt-10">{{ $listing->listing_title}}</h1>
            </div>
            <div class="mx-4 mb-4">
                <h2 class="text-cyan-300">Company description</h2>
                <p class="text-white text-sm tracking-wider">{{$listing->company_description}}</p>
            </div>
            <div class="mx-4 mb-4">
                <h2 class="text-cyan-300">Job Description</h2>
                <p class="text-white text-sm md:tracking-wider">{{$listing->job_description}}</p>
            </div>

            <div class="mx-4 mb-4">
                <h2 class="text-cyan-300">Job Roles</h2>
                <ul style="list-style-type:disc;" class="ml-8 mt-4">
                    @if(!empty($listing->formatted_job_roles))
                        @foreach($listing->formatted_job_roles as $index => $jobRole)
                            <li class="text-white text-sm md:tracking-wider mb-3">{{ $jobRole }}</li>
                            @if($index < count($listing->formatted_job_roles) - 1)
                                
                            @endif
                        @endforeach
                    @else
                        <li>No job roles available.</li>
                    @endif
                </ul>
            </div>
            <div class="mx-4 mb-4">
                <h2 class="text-cyan-300">Additional Info</h2>
                <p class="text-white text-sm md:tracking-wider">{{$listing->additional_info}}</p>
            </div>
            <div class="mx-4 mb-4">
                <h2 class="text-cyan-300">Skills</h2>
                @foreach (explode(',', $listing->tags) as $tag )
                    <div class="bg-white text-slate-700 text-sm px-2 py-0.5 rounded-full max-w-fit">{{$tag}}</div>
                @endforeach
            </div>
            <div class="grid grid-cols-1 md:grid-cols-2">
                <div class="mx-4 mb-4">
                    <h2 class="text-cyan-300">Location</h2>
                    <p class="text-white text-sm md:tracking-wider">{{$listing->location}}</p>
                </div>
                <div class="mx-4 mb-4">
                    <h2 class="text-cyan-300">Salary</h2>
                    <p class="text-white text-sm md:tracking-wider"><span class="font-semibold text-white">$ </span>{{$listing->salary}} <span class="font-semibold text-white"> K</span></p>
                </div>
            </div>
            <div class="mx-4 mb-4">
                <h2 class="text-cyan-300">Job Type</h2>
                <p class="text-white text-sm md:tracking-wider">{{$listing->job_type}}</p>
            </div>
            <div class="flex items-center justify-center mx-4 mb-4">
                <a href="{{route('apply.form', $listing)}}" class="bg-cyan-300 text-gray-700 font-semibold rounded-lg px-3 py-1.5 hover:bg-cyan-500 hover:text-white">Apply</a>
            </div>
            
        </div>

    </div>

@endsection