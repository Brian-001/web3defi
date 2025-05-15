@extends('layouts.dashboard')

@section('title', 'Edit Job Listing')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="bg-white p-6 rounded-xl shadow-lg">
        <!-- Header -->
        <div class="flex items-center justify-between mb-6">
            <h1 class="text-2xl md:text-3xl font-bold text-gray-800">Edit Job Listing</h1>
            <a wire:navigate href="{{ route('dashboard.job-management') }}" 
               class="flex items-center gap-2 text-sm font-semibold text-gray-700 hover:text-cyan-600 transition-colors duration-200">
                <x-icons.arrow-uturn />
                Back to Jobs
            </a>
        </div>

        <!-- Success Message -->
        @if (session('success'))
            <div class="mb-4 bg-green-100 border-l-4 border-green-500 text-green-700 p-4 rounded-r-lg" role="alert">
                {{ session('success') }}
            </div>
        @endif

        <!-- Form -->
        <form action="{{ route('listings.update', $listing->id) }}" method="POST" enctype="multipart/form-data" class="space-y-6">
            @csrf
            @method('PUT')

            <!-- Job Title and Location -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div class="space-y-2">
                    <label for="listing_title" class="block text-sm font-semibold text-gray-800">Job Title <span class="text-red-500">*</span></label>
                    <input type="text" name="listing_title" id="listing_title" value="{{ old('listing_title', $listing->listing_title) }}" 
                           class="w-full p-2 text-sm text-gray-700 border rounded-md focus:outline-none focus:ring-2 focus:ring-cyan-500" 
                           autocomplete="off" required>
                    @error('listing_title')
                        <span class="text-red-500 text-xs">{{ $message }}</span>
                    @enderror
                </div>
                <div class="space-y-2">
                    <label for="location" class="block text-sm font-semibold text-gray-800">Location <span class="text-red-500">*</span></label>
                    <input type="text" name="location" id="location" value="{{ old('location', $listing->location) }}" 
                           placeholder="City, Country" 
                           class="w-full p-2 text-sm text-gray-700 border rounded-md focus:outline-none focus:ring-2 focus:ring-cyan-500" required>
                    @error('location')
                        <span class="text-red-500 text-xs">{{ $message }}</span>
                    @enderror
                </div>
            </div>

            <!-- Descriptions -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div class="space-y-2">
                    <label for="company_description" class="block text-sm font-semibold text-gray-800">Company Description</label>
                    <textarea name="company_description" id="company_description" rows="4" 
                              placeholder="Summarized company info" 
                              class="w-full p-2 text-sm text-gray-700 border rounded-md focus:outline-none focus:ring-2 focus:ring-cyan-500 resize-none">{{ old('company_description', $listing->company_description) }}</textarea>
                    @error('company_description')
                        <span class="text-red-500 text-xs">{{ $message }}</span>
                    @enderror
                </div>
                <div class="space-y-2">
                    <label for="job_description" class="block text-sm font-semibold text-gray-800">Job Description <span class="text-red-500">*</span></label>
                    <textarea name="job_description" id="job_description" rows="4" 
                              placeholder="Enter job description" 
                              class="w-full p-2 text-sm text-gray-700 border rounded-md focus:outline-none focus:ring-2 focus:ring-cyan-500 resize-none" required>{{ old('job_description', $listing->job_description) }}</textarea>
                    @error('job_description')
                        <span class="text-red-500 text-xs">{{ $message }}</span>
                    @enderror
                </div>
            </div>

            <!-- Roles and Additional Info -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div class="space-y-2">
                    <label for="job_roles" class="block text-sm font-semibold text-gray-800">Job Roles <span class="text-red-500">*</span></label>
                    <textarea name="job_roles" id="job_roles" rows="4" 
                              placeholder="Use full stops after each role (e.g., 'Develop features. Test code.')" 
                              class="w-full p-2 text-sm text-gray-700 border rounded-md focus:outline-none focus:ring-2 focus:ring-cyan-500 resize-none" required>{{ old('job_roles', $listing->job_roles) }}</textarea>
                    @error('job_roles')
                        <span class="text-red-500 text-xs">{{ $message }}</span>
                    @enderror
                </div>
                <div class="space-y-2">
                    <label for="additional_info" class="block text-sm font-semibold text-gray-800">Additional Information</label>
                    <textarea name="additional_info" id="additional_info" rows="4" 
                              placeholder="Benefits, holidays, etc." 
                              class="w-full p-2 text-sm text-gray-700 border rounded-md focus:outline-none focus:ring-2 focus:ring-cyan-500 resize-none">{{ old('additional_info', $listing->additional_info) }}</textarea>
                    @error('additional_info')
                        <span class="text-red-500 text-xs">{{ $message }}</span>
                    @enderror
                </div>
            </div>

            <!-- Tags and Job Type -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div class="space-y-2">
                    <label for="tags" class="block text-sm font-semibold text-gray-800">Tags <span class="text-red-500">*</span></label>
                    <div class="max-h-40 overflow-y-auto p-2 border rounded-md bg-gray-50">
                        <div class="grid grid-cols-2 gap-2">
                            @foreach ($tags as $tag)
                                <label class="flex items-center gap-2 text-sm text-gray-700 cursor-pointer">
                                    <input type="checkbox" name="tags[]" value="{{ $tag->id }}" 
                                           class="h-4 w-4 text-cyan-500 border-gray-300 rounded focus:ring-cyan-500"
                                           {{ in_array($tag->id, old('tags', $listing->tags ? json_decode($listing->tags, true) : [])) ? 'checked' : '' }}>
                                    <span>{{ $tag->tag_name }}</span>
                                </label>
                            @endforeach
                        </div>
                    </div>
                    @error('tags')
                        <span class="text-red-500 text-xs">{{ $message }}</span>
                    @enderror
                </div>
                <div class="space-y-2">
                    <label for="job_type" class="block text-sm font-semibold text-gray-800">Job Type <span class="text-red-500">*</span></label>
                    <select name="job_type" id="job_type" 
                            class="w-full p-2 text-sm text-gray-700 border rounded-md focus:outline-none focus:ring-2 focus:ring-cyan-500" required>
                        <option value="" disabled {{ old('job_type', $listing->job_type) ? '' : 'selected' }}>-- Select Job Type --</option>
                        <option value="onsite" {{ old('job_type', $listing->job_type) === 'onsite' ? 'selected' : '' }}>On-site</option>
                        <option value="remote" {{ old('job_type', $listing->job_type) === 'remote' ? 'selected' : '' }}>Remote</option>
                        <option value="hybrid" {{ old('job_type', $listing->job_type) === 'hybrid' ? 'selected' : '' }}>Hybrid</option>
                    </select>
                    @error('job_type')
                        <span class="text-red-500 text-xs">{{ $message }}</span>
                    @enderror
                </div>
            </div>

            <!-- Salary -->
            <div class="space-y-2">
                <label class="block text-sm font-semibold text-gray-800">Estimated Salary (USD) <span class="text-red-500">*</span></label>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div class="space-y-2">
                        <label for="min_salary" class="block text-xs font-medium text-gray-600">Minimum Salary</label>
                        <input type="number" name="min_salary" id="min_salary" min="0" 
                               value="{{ old('min_salary', $listing->salary ? explode(' to ', $listing->salary)[0] : '') }}" 
                               class="w-full p-2 text-sm text-gray-700 border rounded-md focus:outline-none focus:ring-2 focus:ring-cyan-500" required>
                        @error('min_salary')
                            <span class="text-red-500 text-xs">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="space-y-2">
                        <label for="max_salary" class="block text-xs font-medium text-gray-600">Maximum Salary</label>
                        <input type="number" name="max_salary" id="max_salary" min="0" 
                               value="{{ old('max_salary', $listing->salary ? explode(' to ', $listing->salary)[1] : '') }}" 
                               class="w-full p-2 text-sm text-gray-700 border rounded-md focus:outline-none focus:ring-2 focus:ring-cyan-500" required>
                        @error('max_salary')
                            <span class="text-red-500 text-xs">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
            </div>

            <!-- Logo Upload -->
            <div class="space-y-2">
                <label for="listing_logo" class="block text-sm font-semibold text-gray-800">Company Logo</label>
                <div class="flex items-center gap-4">
                    <input type="file" name="listing_logo" id="listing_logo" accept="image/*" 
                           class="block w-full text-sm text-gray-700 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:bg-cyan-50 file:text-cyan-700 file:cursor-pointer hover:file:bg-cyan-100 focus:outline-none focus:ring-2 focus:ring-cyan-500">
                    @if ($listing->listing_logo)
                        <img src="{{ asset('storage/' . $listing->listing_logo) }}" 
                             alt="Current Logo" 
                             class="w-12 h-12 rounded-full object-cover border border-gray-200 shadow-sm">
                    @else
                        <div class="w-12 h-12 bg-gray-100 rounded-full flex items-center justify-center text-gray-500 text-xs">No Logo</div>
                    @endif
                </div>
                @error('listing_logo')
                    <span class="text-red-500 text-xs">{{ $message }}</span>
                @enderror
            </div>

            <!-- Submit Button -->
            <div class="flex justify-end gap-4">
                <a href="{{ route('dashboard.job-management') }}" 
                   class="bg-gray-500 text-white text-sm font-semibold px-6 py-2 rounded-md hover:bg-gray-600 transition-colors duration-200">
                    Cancel
                </a>
                <button type="submit" 
                        class="bg-cyan-500 text-white text-sm font-semibold px-6 py-2 rounded-md hover:bg-cyan-600 transition-colors duration-200">
                    Update Job
                </button>
            </div>
        </form>

        {{-- Dynamic Job Questions --}}
        <livewire:job-question-form :listing-id="$listing->id" />
    </div>
</div>
@endsection