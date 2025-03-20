@extends('layouts.dashboard')

@section('title', 'Job Management')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="bg-white p-6 rounded-xl shadow-lg">
        <!-- Header -->
        <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between mb-4 gap-4">
            <h2 class="text-2xl md:text-3xl font-bold text-gray-800">Job Management</h2>
            <div class="flex flex-col sm:flex-row gap-2 w-full sm:w-auto">
                <a href="{{ route('listings.create') }}" 
                   class="bg-cyan-600 text-white font-semibold px-4 py-2 rounded-md hover:bg-cyan-700 transition-colors duration-200 w-full sm:w-auto text-center">
                    Create Job
                </a>
                <a href="{{ route('tags.create') }}" 
                   class="bg-gray-600 text-white font-semibold px-4 py-2 rounded-md hover:bg-gray-700 transition-colors duration-200 w-full sm:w-auto text-center">
                    Create Tag
                </a>
                <a href="{{ route('tags.index') }}" 
                   class="bg-gray-400 text-white font-semibold px-4 py-2 rounded-md hover:bg-gray-500 transition-colors duration-200 w-full sm:w-auto text-center">
                    View Tags
                </a>
            </div>
        </div>

        <!-- Table -->
        <div class="overflow-x-auto">
            <table class="w-full table-auto border-collapse">
                <thead>
                    <tr class="bg-gray-100 text-gray-700 text-xs font-semibold uppercase tracking-wide border-b border-gray-200">
                        <th class="py-2 px-2 text-left">Title</th>
                        <th class="py-2 px-2 text-left">Posted By</th>
                        <th class="py-2 px-2 text-left">Type</th>
                        <th class="py-2 px-2 text-left">Posted Date</th>
                        <th class="py-2 px-2 text-left">Status</th>
                        <th class="py-2 px-2 text-left">Actions</th>
                    </tr>
                </thead>
                <tbody class="text-gray-600">
                    @forelse ($listings as $listing)
                        <tr class="hover:bg-gray-50 transition-colors duration-150 border-b border-gray-200">
                            <td class="py-2 px-2 whitespace-nowrap text-sm">{{ $listing->listing_title }}</td>
                            <td class="py-2 px-2 whitespace-nowrap text-sm">{{ $listing->user->name }}</td>
                            <td class="py-2 px-2 whitespace-nowrap text-sm capitalize">{{ $listing->job_type }}</td>
                            <td class="py-2 px-2 whitespace-nowrap text-sm">{{ $listing->created_at->format('d M Y H:i') }}</td>
                            <td class="py-2 px-2 whitespace-nowrap">
                                <form action="{{ route('dashboard.update-listing-status', $listing->id) }}" method="POST" class="inline">
                                    @csrf
                                    @method('PATCH')
                                    <select name="listing_status" 
                                            class="bg-transparent text-gray-700 text-sm py-0 px-6 rounded-lg hover:text-cyan-600" 
                                            onchange="this.form.submit()">
                                        @foreach ($statuses as $status)
                                            <option value="{{ $status }}" {{ $listing->listing_status === $status ? 'selected' : '' }}>
                                                {{ ucfirst($status) }}
                                            </option>
                                        @endforeach
                                    </select>
                                </form>
                            </td>
                            <td class="py-2 px-2 whitespace-nowrap flex gap-2">
                                <a href="{{ route('listings.edit', $listing->id) }}" 
                                   class="bg-emerald-500 text-white text-sm font-medium py-1 px-2 rounded-md hover:bg-emerald-600 transition-colors duration-200">
                                    Edit
                                </a>
                                <form action="{{ route('listings.destroy', $listing->id) }}" method="POST" class="inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" 
                                            class="bg-red-500 text-white text-sm font-medium py-1 px-2 rounded-md hover:bg-red-600 transition-colors duration-200" 
                                            onclick="return confirm('Are you sure you want to delete this job?')">
                                        Delete
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="py-2 px-2 text-center text-gray-500 text-sm">No jobs found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        <div class="mt-4 flex items-center justify-center">
            {{ $listings->links('pagination::tailwind') }}
        </div>
    </div>
</div>
@endsection