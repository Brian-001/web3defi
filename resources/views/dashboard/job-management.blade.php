@extends('layouts.dashboard')

@section('title', 'Job Management')
@section('content')
<div class="bg-white p-6 rounded-lg shadow">
    <h2 class="text-2xl font-bold mb-4">Welcome to Job management</h2>
    <div class="mx-auto my-4">
        <table class="w-full">
            <thead>
                <tr class="border-b border-gray-300">
                    <th class="py-2 px-4 text-left">Listing Title</th>
                    <th class="py-2 px-4 text-left">Posted by</th>
                    <th class="py-2 px-4 text-left">Listing Type</th>
                    <th class="py-2 px-4 text-left">Posted Date</th>
                    <th class="py-2 px-4 text-left">Status</th>
                    <th class="py-2 px-4 text-left">Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($listings as $listing)
                    <tr class="border-b border-gray-200">
                        <td class="py-2 px-4">{{ $listing->listing_title }}</td>
                        <td class="py-2 px-4"> {{ $listing->posted_by }}</td>
                        <td class="py-2 px-4">Remote</td>
                        <td class="py-2 px-4">2021-01-01 12:00:00</td>
                        <td class="py-2 px-4">Active/Closed</td>
                        <td class="py-2 px-4">Edit</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection
