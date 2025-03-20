@extends('layouts.app-layouts')

@section('content')
    <div class="container mx-auto px-4 py-10">
        <div class="bg-gradient-to-br from-slate-700 to-slate-800 p-8 rounded-xl shadow-xl w-full max-w-3xl mx-auto">
            <!-- Header with Back Link and Posted Date -->
            <div class="flex items-center justify-between flex-wrap gap-4 mb-8">
                <a href="{{ url('/') }}" class="flex items-center gap-2 group">
                    <x-icons.arrow-uturn class="w-5 h-5 text-cyan-300 transform group-hover:-translate-x-1 transition-transform" />
                    <span class="text-cyan-300 font-medium hover:text-cyan-200 transition-colors">Back to Listings</span>
                </a>
                <p class="text-sm text-gray-400"><span class="font-semibold text-gray-300">Posted:</span> {{ $listing->created_at_formatted }}</p>
            </div>

            <!-- Job Title -->
            <div class="text-center mb-8">
                <h1 class="text-3xl md:text-4xl font-bold text-white tracking-tight">{{ $listing->listing_title }}</h1>
            </div>

            <!-- Main Content Sections -->
            <div class="space-y-8">
                <!-- Company Description -->
                <section>
                    <h2 class="text-xl font-semibold text-cyan-300 mb-3">Company Description</h2>
                    <p class="text-gray-200 text-base leading-relaxed">{{ $listing->company_description }}</p>
                </section>

                <!-- Job Description -->
                <section>
                    <h2 class="text-xl font-semibold text-cyan-300 mb-3">Job Description</h2>
                    <p class="text-gray-200 text-base leading-relaxed">{{ $listing->job_description }}</p>
                </section>

                <!-- Job Roles -->
                <section>
                    <h2 class="text-xl font-semibold text-cyan-300 mb-3">Job Roles</h2>
                    @if (!empty($listing->formatted_job_roles) && is_array($listing->formatted_job_roles))
                        <ul class="space-y-2 ml-4">
                            @foreach ($listing->formatted_job_roles as $jobRole)
                                <li class="text-gray-200 text-base flex items-start">
                                    <span class="text-cyan-400 mr-2">▹</span>
                                    <span>{{ $jobRole }}</span>
                                </li>
                            @endforeach
                        </ul>
                    @else
                        <p class="text-gray-400 text-sm italic">No job roles specified.</p>
                    @endif
                </section>

                <!-- Additional Information (Conditional) -->
                @if (!empty($listing->additional_info))
                    <section>
                        <h2 class="text-xl font-semibold text-cyan-300 mb-3">Additional Information</h2>
                        <div class="text-gray-200 text-base leading-relaxed bg-slate-900 p-4 rounded-lg border border-slate-700">
                            {{ $listing->additional_info }}
                        </div>
                    </section>
                @endif

                <!-- Tags -->
                <section>
                    <div class="flex flex-wrap gap-2">
                        @php
                            $tagIds = json_decode($listing->tags, true) ?? [];
                            $tags = App\Models\Tag::whereIn('id', $tagIds)->pluck('tag_name')->toArray();
                        @endphp
                        @foreach ($tags as $tag)
                            <span class="bg-cyan-100 text-cyan-800 text-sm font-medium px-3 py-1 rounded-full shadow-sm">{{ $tag }}</span>
                        @endforeach
                    </div>
                </section>

                <!-- Job Details Grid -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <h2 class="text-xl font-semibold text-cyan-300 mb-3">Location</h2>
                        <p class="text-gray-200 text-base">{{ $listing->location }}</p>
                    </div>
                    <div>
                        <h2 class="text-xl font-semibold text-cyan-300 mb-3">Estimated Salary</h2>
                        <p class="text-gray-200 text-base">
                            <span class="font-semibold text-white">$</span>{{ $listing->salary }}<span class="font-semibold text-white">K</span>
                        </p>
                    </div>
                    <div>
                        <h2 class="text-xl font-semibold text-cyan-300 mb-3">Job Type</h2>
                        <p class="text-gray-200 text-base">{{ $listing->job_type }}</p>
                    </div>
                </div>
            </div>

            <!-- Apply Button -->
            <div class="mt-10 text-center">
                <a href="{{ route('apply.form', $listing) }}" 
                   class="inline-block bg-cyan-400 text-gray-900 font-semibold text-lg px-8 py-3 rounded-lg hover:bg-cyan-300 transition-colors duration-200 shadow-md">
                    Apply Now
                </a>
            </div>

            
        </div>
    </div>
@endsection