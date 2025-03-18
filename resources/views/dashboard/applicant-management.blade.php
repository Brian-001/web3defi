@extends('layouts.dashboard')

@section('title', 'Applicant Management')

@section('content')
<div class="bg-white p-6 rounded-lg shadow">
    <h2 class="text-2xl font-bold mb-4">Applicants management</h2>
    <div class="mx-auto my-4">
        <table class="w-full">
            <thead>
                <tr class="border-b border-gray-300">
                    <th class="py-2 px-4 text-left">Listing Title</th>
                    <th class="py-2 px-4 text-left">Applicant Name</th>
                    <th class="py-2 px-4 text-left">Application Date</th>
                    <th class="py-2 px-4 text-left">Action</th>
                    <th class="py-2 px-4 text-left">Status</th>
                    <th class="py-2 px-4 text-left">Contact</th>
                    <th class="py-2 px-4 text-left">Resume</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($applicants as $applicant)
                    <tr class="border-b border-gray-200">
                        <td class="py-2 px-4">{{$applicant->listing->listing_title}}</td>
                        <td class="py-2 px-4">{{$applicant->name}}</td>
                        <td class="py-2 px-4">{{$applicant->created_at->format('d M Y')}}</td>
                        <td class="py-2 px-4"><a href="{{ route('dashboard.single-listing', $applicant->id) }}">View</a></td>
                        <td class="py-2 px-4">Active</td>
                        <td class="py-2 px-4"><a href="#" class="email-link bg-gray-200 px-2 py-1 rounded-md hover:shadow-md" data-email = "{{ $applicant->email }}">Send Email</a></td>
                        <td class="py-2 px-4 flex items-center gap-2">
                            <x-icons.document class="text-gray-500 " />
                            <a href="{{ asset('storage/' . $applicant->resume_path) }}" target="_blank" class="hover:underline">View Resume</a>
                        </td>
                    </tr>
                @endforeach                
            </tbody>
        </table>
    </div>
</div>

@endsection
