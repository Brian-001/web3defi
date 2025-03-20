@extends('layouts.dashboard')

@section('title', 'View Job Listing')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="bg-white p-6 rounded-xl shadow-lg">
        <!-- Header -->
        <div class="flex items-center justify-between mb-4">
            <h2 class="text-2xl md:text-3xl font-bold text-gray-800">{{ $listing->listing_title }}</h2>
            <div class="flex gap-2">
                <a href="{{ route('listings.edit', $listing->id) }}" 
                   class="bg-emerald-500 text-white text-sm font-semibold px-4 py-2 rounded-md hover:bg-emerald-600 transition-colors duration-200">
                    Edit Job
                </a>
                <a href="{{ route('dashboard.applicant-management') }}" 
                   class="bg-gray-500 text-white text-sm font-semibold px-4 py-2 rounded-md hover:bg-gray-600 transition-colors duration-200">
                    Back to Applicants
                </a>
            </div>
        </div>

        <!-- Job Details -->
        <div class="grid grid-cols-1 gap-6">
            <!-- Logo and Overview -->
            <div class="flex flex-col md:flex-row items-start gap-4">
                <div class="flex-shrink-0">
                    @if ($listing->listing_logo)
                        <img src="{{ asset('storage/' . $listing->listing_logo) }}" 
                             alt="Logo" 
                             class="w-16 h-16 md:w-20 md:h-20 object-cover rounded-full border border-gray-200">
                    @else
                        <div class="w-16 h-16 md:w-20 md:h-20 bg-gray-100 rounded-full flex items-center justify-center text-gray-500 text-sm">
                            No Logo
                        </div>
                    @endif
                </div>
                <div class="grid grid-cols-1 gap-3 w-full">
                    <!-- Company Description -->
                    <div>
                        <p class="font-semibold text-gray-800 flex items-center gap-2 w-full text-left">
                            Company Description  
                        </p>
                        <div x-show="open" x-transition class="text-sm text-gray-600">
                            {{ $listing->company_description ?? 'N/A' }}
                        </div>
                    </div>
                    <!-- Job Description -->
                    <div >
                        <p class="font-semibold text-gray-800 flex items-center gap-2 w-full text-left">
                            Job Description
                        </p>

                        <div class="text-sm text-gray-600">
                            {{ $listing->job_description }}
                        </div>
                    </div>
                    <!-- Job Roles -->
                    <div>
                        <p class="font-semibold text-gray-800 flex items-center gap-2 w-full text-left">
                            Job Roles
                        </p>
                        <div>
                            @if (!empty($listing->formatted_job_roles) && is_array($listing->formatted_job_roles))
                                <ul class="ml-4 space-y-1">
                                    @foreach ($listing->formatted_job_roles as $jobRole)
                                        <li class="text-sm text-gray-600 flex items-start">
                                            <span class="text-cyan-600 mr-2">•</span>
                                            <span>{{ $jobRole }}</span>
                                        </li>
                                    @endforeach
                                </ul>
                            @else
                                <p class="text-sm text-gray-600">N/A</p>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            <!-- Details Grid -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div class="grid grid-cols-1 gap-2">
                    <p class="font-semibold text-gray-800">Location</p>
                    <p class="text-sm text-gray-600">{{ $listing->location }}</p>
                </div>
                <div class="grid grid-cols-1 gap-2">
                    <p class="font-semibold text-gray-800">Status</p>
                    <p class="text-sm">
                        <span class="inline-block px-2 py-1 text-xs font-semibold rounded-full {{ $listing->listing_status === 'active' ? 'bg-green-100 text-green-800' : 'bg-gray-100 text-gray-800' }}">
                            {{ ucfirst($listing->listing_status) }}
                        </span>
                    </p>
                </div>
                <div class="grid grid-cols-1 gap-2">
                    <p class="font-semibold text-gray-800">Estimated Salary</p>
                    <p class="text-sm text-gray-600">${{ $listing->salary }}K</p>
                </div>
                <div class="grid grid-cols-1 gap-2">
                    <p class="font-semibold text-gray-800">Job Type</p>
                    <p class="text-sm text-gray-600 capitalize">{{ $listing->job_type }}</p>
                </div>
            </div>
        </div>

        <!-- Applications Section -->
        <div class="mt-6">
            <button class="text-xl font-semibold text-gray-800 flex items-center gap-2 w-full text-left mb-3">
                Applications
            </button>
            <div>
                @if ($listing->jobApplications->isEmpty())
                    <p class="text-sm text-gray-500">No applications yet.</p>
                @else
                    <div class="overflow-x-auto">
                        <table class="w-full table-auto border-collapse">
                            <thead>
                                <tr class="bg-gray-100 text-gray-700 text-xs font-semibold uppercase tracking-wide border-b border-gray-200">
                                    <th class="py-2 px-2 text-left">Applicant</th>
                                    <th class="py-2 px-2 text-left">Email</th>
                                    <th class="py-2 px-2 text-left">Applied On</th>
                                    <th class="py-2 px-2 text-left">Resume</th>
                                </tr>
                            </thead>
                            <tbody class="text-gray-600">
                                @foreach ($listing->jobApplications as $application)
                                    <tr class="hover:bg-gray-50 transition-colors duration-150 border-b border-gray-200">
                                        <td class="py-2 px-2 whitespace-nowrap text-sm">{{ $application->name }}</td>
                                        <td class="py-2 px-2 whitespace-nowrap text-sm">{{ $application->email }}</td>
                                        <td class="py-2 px-2 whitespace-nowrap text-sm">{{ $application->created_at->format('d M Y') }}</td>
                                        <td class="py-2 px-2 whitespace-nowrap text-sm flex items-center gap-2">
                                            <x-icons.document class="text-gray-500"/>
                                            <a href="{{ asset('storage/' . $application->resume_path) }}" 
                                               target="_blank" 
                                               class="text-cyan-600 hover:text-cyan-800 hover:underline transition-colors duration-200">
                                                View
                                            </a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection