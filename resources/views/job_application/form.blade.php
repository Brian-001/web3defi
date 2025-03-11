@extends('layouts.app-layouts')

@section('title', 'Job Application Form')

@section('content')
<div class="grid grid-cols-1 gap-4 items-center justify-center mt-10">
    <div class="bg-slate-600 p-6 rounded-lg shadow-lg w-full md:w-1/2 mt-10  md:mx-auto h-full">
        <div class="flex items-center justify-between flex-wrap">
            <a href="/" class="flex  gap-4">
                <span class="text-white order-2">Back</span> 
                <x-icons.arrow-uturn class="w-6 h-6 order-1" />
            </a>
        </div>
        <div class=" flex items-center justify-center mt-10 mb-10">
            <h1 class="text-lg md:text-lg text-white mt-10"><span class="text-cyan-400">{{ $listing->listing_title }}</span></h1>
        </div>
    

    <form action="#" method="POST" enctype="multipart/form-data">
        @csrf

        <!-- Listing Title (Disabled Input) -->
        {{-- <div class="mb-4 mx-4">
            <label for="listing_title">Job Title</label>
            <input type="text" class="text-white font-semibold rounded-md" id="listing_title" value="{{ $listing->title }}" disabled>
        </div> --}}

        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">

             <!-- Applicant Name -->
            <div class="flex flex-col mx-4 mb-4">
                <label for="name" class="text-white mb-2">Your Name <span class="tesxt-sm text-red-500">*</span></label>
                <input type="text" id="name" name="name" class="text-white font-semibold rounded-md bg-slate-500 focus:ring-cyan-300" autocomplete="off" value="{{old('name')}}" required>
                @error('name')
                    <span class="text-sm text-red-500">{{ $message }}</span>
                @enderror
            </div>

            <!-- Applicant Email -->
            <div class="flex flex-col mx-4 mb-4">
                <label for="email" class="text-white mb-2">Your Email<span class="tesxt-sm text-red-500">*</span></label>
                <input type="email" id="email" name="email" class="text-white font-semibold rounded-md bg-slate-500 focus:ring-cyan-300" autocomplete="off" value="{{old('email')}}" required>
                @error('email')
                    <span class="text-sm text-red-500">{{ $message }}</span>
                @enderror
            </div>
        </div>

        <!-- Resume Upload -->
        <div class="flex flex-col mx-4 mb-4">
            <label for="resume" class="text-white mb-3">Upload Resume (PDF only)<span class="tesxt-sm text-red-500">*</span></label>
            <input type="file" id="resume_path" name="resume_path" accept=".pdf" class="file:px-2 file:py-1.5 file:border-none file:rounded-lg file:bg-slate-500
             file:text-white text-white font-semibold file:cursor-pointer rounded-md shadow-sm outline-none border-none file:outline-none focus:ring-0  shadow-cyan-300" 
             required
            >
            @error('resume_path')
                <span class="text-sm text-red-500">{{ $message }}</span>
            @enderror
        </div>

        <!-- Submit Button -->
        <div class="flex items-center justify-center mb-4 mt-10">
            <button type="submit" class="bg-cyan-300 text-slate-700 px-2 py-1.5 rounded-md hover:bg-cyan-500">
                Submit Application
            </button>
        </div>
    </form>
    </div>
</div>

@endsection