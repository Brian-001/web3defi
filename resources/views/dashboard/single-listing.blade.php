@extends('layouts.dashboard')

@section('title', 'View Listing')

@section('content')
<div class="bg-white p-6 rounded-lg shadow">
    <h2 class="text-2xl font-bold mb-4">{{ $listing->listing_title }}</h2>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-6">
        <div>
            <p><strong>Company Description:</strong> {{ $listing->company_description ?? 'N/A' }}</p>
            <p><strong>Job Description:</strong> {{ $listing->job_description }}</p>
            <p><strong>Job Roles:</strong> {{ $listing->job_roles }}</p>
            <p><strong>Location:</strong> {{ $listing->location }}</p>
            <p><strong>Salary:</strong> {{ $listing->salary }}</p>
            <p><strong>Job Type:</strong> {{ $listing->job_type }}</p>
            <p><strong>Status:</strong> {{ ucfirst($listing->listing_status) }}</p>
        </div>
        <div>
            @if ($listing->listing_logo)
                <img src="{{ asset('storage/' . $listing->listing_logo) }}" alt="Logo" class="w-32 h-32 object-cover rounded-full border">
            @else
                <p>No logo available</p>
            @endif
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