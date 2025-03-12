@extends('layouts.dashboard')

@section('title', 'Job Management')
@section('content')
<div class="bg-white p-6 rounded-lg shadow">
    <div class="flex items-center justify-between">
        <h2 class="text-2xl font-bold mb-4">Welcome to Job management</h2>
        <a href="{{ route('listings.create') }}" class="bg-cyan-300 text-slate-700 px-6 py-2 rounded-md hover:bg-cyan-500 hover:text-white">Create Job</a>
    </div>
    
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
                        <td class="py-2 px-4">{{ $listing->listing_type }}</td>
                        <td class="py-2 px-4 flex flex-col text-sm">{{ $listing->created_at->format('d/m/Y H:i') }}</td>
                        <td class="py-2 px-4">
                            <form action="{{ route('dashboard.update-listing-status', $listing->id) }}" method="POST" class="inline" >
                                @csrf
                                @method('PATCH')
                                <select name="listing_status" class="border rounded py-1 px-8" onchange="this.form.submit()">
                                    @foreach ($statuses as $status)
                                        <option value="{{ $status }}" {{ $listing->listing_status === $status ? 'selected' : '' }} class="text-left">
                                            {{ ucfirst($status) }}
                                        </option>
                                    @endforeach
                                </select>
                            </form>
                        </td>
                        <td class="py-2 px-4 flex space-x-2">
                            <a href="{{ route('listings.edit', $listing->id) }}" class="text-white bg-emerald-500 hover:bg-emerald-700 py-1 px-2 rounded-md">Edit</a>
                            <form action="{{ route('listings.destroy', $listing->id) }}" method="POST" class="inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-white bg-red-500 hover:bg-red-700 py-1 px-2 rounded-md">Delete</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection
