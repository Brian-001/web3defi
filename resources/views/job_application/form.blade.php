@extends('layouts.app-layouts')

@section('title', 'Job Application Form')

@section('content')
<div class="container mx-auto px-4 py-10">
    <div class="bg-gradient-to-br from-slate-700 to-slate-800 p-8 rounded-xl shadow-xl w-full max-w-2xl mx-auto">
        <!-- Header with Back Link -->
        <div class="flex items-center justify-between flex-wrap gap-4 mb-8">
            <a href="{{ route('listings.show', $listing->id) }}" class="flex items-center gap-2 group">
                <x-icons.arrow-uturn class="w-5 h-5 text-cyan-300 transform group-hover:-translate-x-1 transition-transform" />
                <span class="text-cyan-300 font-medium hover:text-cyan-200 transition-colors">Back to Job</span>
            </a>
        </div>

        <!-- Form Title -->
        <div class="text-center mb-10">
            <h1 class="text-2xl md:text-3xl font-bold text-white">
                Apply for <span class="text-cyan-400">{{ $listing->listing_title }}</span>
            </h1>
            <p class="text-gray-400 mt-2 text-sm">Submit your details to get started!</p>
        </div>

        <!-- Form -->
        <form action="{{ route('apply.submit', $listing) }}" method="POST" enctype="multipart/form-data">
            @csrf

            <!-- Applicant Details -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                <!-- Name -->
                <div class="flex flex-col">
                    <label for="name" class="text-gray-200 font-medium mb-2">
                        Your Name <span class="text-red-400 text-sm">*</span>
                    </label>
                    <input type="text" 
                           id="name" 
                           name="name" 
                           class="w-full px-4 py-2 bg-slate-900 text-gray-200 rounded-lg border border-slate-600 focus:ring-2 focus:ring-cyan-400 focus:border-transparent outline-none transition-all" 
                           autocomplete="off" 
                           value="{{ old('name') }}" 
                           required>
                    @error('name')
                        <span class="text-sm text-red-400 mt-1">{{ $message }}</span>
                    @enderror
                </div>

                <!-- Email -->
                <div class="flex flex-col">
                    <label for="email" class="text-gray-200 font-medium mb-2">
                        Your Email <span class="text-red-400 text-sm">*</span>
                    </label>
                    <input type="email" 
                           id="email" 
                           name="email" 
                           class="w-full px-4 py-2 bg-slate-900 text-gray-200 rounded-lg border border-slate-600 focus:ring-2 focus:ring-cyan-400 focus:border-transparent outline-none transition-all" 
                           autocomplete="off" 
                           value="{{ old('email') }}" 
                           required>
                    @error('email')
                        <span class="text-sm text-red-400 mt-1">{{ $message }}</span>
                    @enderror
                </div>
            </div>

            <!-- Resume Upload -->
            <div class="flex flex-col mb-8">
                <label for="resume_path" class="text-gray-200 font-medium mb-2">
                    Upload Resume (PDF only) <span class="text-red-400 text-sm">*</span>
                </label>
                <input type="file" 
                       id="resume_path" 
                       name="resume_path" 
                       accept=".pdf" 
                       class="w-full text-gray-200 bg-slate-900 rounded-lg border border-slate-600 file:bg-cyan-600 file:text-white file:border-none file:px-4 file:py-2 file:rounded-lg file:cursor-pointer file:hover:bg-cyan-500 focus:ring-2 focus:ring-cyan-400 focus:border-transparent transition-all" 
                       required>
                @error('resume_path')
                    <span class="text-sm text-red-400 mt-1">{{ $message }}</span>
                @enderror
            </div>

            <!-- Submit Button -->
            <div class="text-center">
                <button type="submit" 
                        class="bg-cyan-400 text-gray-900 font-semibold text-lg px-8 py-3 rounded-lg hover:bg-cyan-300 transition-colors duration-200 shadow-md w-full md:w-auto">
                    Submit Application
                </button>
            </div>
        </form>
    </div>
</div>
@endsection