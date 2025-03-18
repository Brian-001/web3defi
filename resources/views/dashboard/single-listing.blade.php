@extends('layouts.dashboard')

@section('title', 'View Job Listing')

@section('content')
<div class="bg-white p-6 rounded-lg shadow">
    <h2 class="text-2xl font-bold mb-4">{{ $listing->listing_title }}</h2>

    <div class="grid mx-auto">
        <div>
            <div class="grid grid-cols-1 gap-4 mb-4">
                <div>
                    @if ($listing->listing_logo)
                        <img src="{{ asset('storage/' . $listing->listing_logo) }}" alt="Logo" class="w-20 h-20 md:w-28 md:h-28 object-cover rounded-full border">
                    @else
                        <p>No logo available</p>
                    @endif
                </div>
                <div class="grid grid-cols-1 gap-2">
                    <p class="font-semibold">Company Description</p>
                    <p class="text-sm md:text-base md:text-tracking-wide">{{ $listing->company_description ?? 'N/A' }}</p>
                </div>
                <div class="grid grid-cols-1 gap-1">
                    <p class="font-semibold">Job Description</p>
                    <p class="text-sm md:text-base md:text-tracking-wide">{{ $listing->job_description }}</p>
                </div>
                <div class="grid grid-cols-1 gap-2">
                    <p class="font-semibold">Job Roles</p>
                    {{-- <p>{{ $listing->job_roles }}</p> --}}
                    @if (!empty($listing->formatted_job_roles) && is_array($listing->formatted_job_roles))
                        <ul class="ml-6 space-y-3">
                            @foreach ($listing->formatted_job_roles as $jobRole )
                                <div class="text-sm md:text-base md:text-tracking-wide flex items-start">
                                    <span class="font-semibold mr-2">.</span>
                                    <span>{{ $jobRole }}</span>
                                </div>
                            @endforeach
                        </ul>
                        
                    @endif
                </div>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-2">
                    <div>
                        <p class="font-semibold">Location</p>
                        <p class="text-sm md:text-base md:text-tracking-wide">{{ $listing->location }}</p>
                    </div>
                    <div>
                        <p class="font-semibold">Status</p>
                        <p class="text-sm md:text-base md:text-tracking-wide">{{ ucfirst($listing->listing_status) }}</p>
                    </div>
                </div>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-2">
                    <div class="grid grid-cols-1 gap-2">
                        <p class="font-semibold">Estimated Salary ($)</p>
                        <p class="text-sm md:text-base md:text-tracking-wide">{{ $listing->salary }} K</p>
                    </div>
                    <div class="grid grid-cols-1 gap-2">
                        <p class="font-semibold">Job Type</p>
                        <p class="text-sm md:text-base md:text-tracking-wide">{{ $listing->job_type }}</p>
                    </div>
                </div>
            </div>
        </div>
        
    </div>

    <h3 class="text-xl font-semibold mb-4">Applications</h3>
    @if ($listing->jobApplications->isEmpty())
        <p>No applications yet.</p>
    @else
        <table class="w-full">
            <thead>
                <tr class="border-b border-gray-300">
                    <th class="py-2 px-4 text-left">Applicant Name</th>
                    <th class="py-2 px-4 text-left">Email</th>
                    <th class="py-2 px-4 text-left">Application Date</th>
                    <th class="py-2 px-4 text-left">Resume</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($listing->jobApplications as $application)
                    <tr class="border-b border-gray-200">
                        <td class="py-2 px-4">{{ $application->name }}</td>
                        <td class="py-2 px-4">{{ $application->email }}</td>
                        <td class="py-2 px-4">{{ $application->created_at->format('d M Y') }}</td>
                        <td class="py-2 px-4">
                            <a href="{{ asset('storage/' . $application->resume_path) }}" target="_blank" class="hover:underline">View Resume</a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endif

    <a href="{{ route('dashboard.applicant-management') }}" class="mt-4 inline-block bg-gray-500 text-white px-4 py-2 rounded-md hover:bg-gray-600">Back to Applicants</a>
</div>
@endsection