@extends('layouts.app-layouts')

@section('content')
<div class="flex items-center justify-center min-h-screen bg-slate-700">
    <form action="{{route('listings.store')}}" method="POST" enctype="multipart/form-data" class="shadow-lg bg-slate-700 p-6 rounded-lg w-full max-w-lg">
        @csrf

        <h1 class="text-2xl text-cyan-300 mb-4 place-items-center">Create a new job</h1>
        {{-- Listing Title --}}

        {{-- Flash message for success --}}
        @if (session('success'))
            <div class="mt-4 bg-green-200 border border-green-400 text-green-700 px-4 py-3 rounded relative" role="alert">
                {{ session('success')}}
            </div>
        @endif
        <div class="mb-4 flex flex-col">
            <label for="listing_title" class="font-semibold">Company Title <span class="text-sm text-red-500">*</span></label>
            <input type="text" name="listing_title" id="listing_title" value="{{old('listing_title')}}" class="focus:outline-none focus:ring-2 focus:ring-cyan-300 bg-slate-600 font-semibold rounded-lg p-2" autocomplete="off" required>
            @error('listing_title')
                <span class="text-red-500 text-sm">{{$message}}</span>
            @enderror
        </div>

        <div class="flex flex-wrap">
            {{-- Company Description --}}
            <div class="mb-4 flex flex-col mr-4 w-full">
                <label for="company_description" class="font-semibold">Company Description</label>
                <textarea name="company_description" id="company_description" cols="30" rows="5" value="{{old('company_description')}}" placeholder="Summarised information about the company" class="focus:outline-none focus:ring-2 focus:ring-cyan-300 bg-slate-600 h-32 resize-none p-2 rounded-lg"></textarea>
                @error('company_description')
                    <span class="text-red-500 text-sm">{{$message}}</span>
                @enderror
            </div>

            {{-- Job Description --}}
            <div class="mb-4 flex flex-col w-full">
                <label for="job_description" class="font-semibold">Job Description<span class="text-sm text-red-500">*</span></label>
                <textarea name="job_description" id="job_description" cols="30" rows="5" value="{{old('job_description')}}" placeholder="Enter job description" class="focus:outline-none focus:ring-2 focus:ring-cyan-300 bg-slate-600 h-32 resize-none p-2 rounded-lg"></textarea>
                @error('job_description')
                    <span class="text-red-500 text-sm">{{$message}}</span>
                @enderror
            </div>
        </div>

        <div class="flex flex-wrap">
            {{-- Job Roles --}}
            <div class="mb-4 flex flex-col mr-4 w-full">
                <label for="job_roles" class="font-semibold">Job Roles<span class="text-sm text-red-500">*</span></label>
                <textarea name="job_roles" id="job_roles" cols="30" rows="5" value={{old('job_roles')}} placeholder="Enter roles and responsibilities" class="focus:outline-none focus:ring-2 focus:ring-cyan-300 bg-slate-600 h-32 resize-none p-2 rounded-lg"></textarea>
                @error('job_roles')
                    <span class="text-red-500 text-sm">{{$message}}</span>
                @enderror
            </div>
            
            {{-- Additional Information --}}
            <div class="mb-4 flex flex-col w-full">
                <label for="additional_info" class="font-semibold">Additional Information</label>
                <textarea name="additional_info" id="additional_info" cols="30" rows="5" value={{old('additional_info')}} placeholder="More info about job e.g., Benefits, Holidays" class="focus:outline-none focus:ring-2 focus:ring-cyan-300 bg-slate-600 h-32 resize-none p-2 rounded-lg"></textarea>
                @error('additional_info')
                    <span class="text-red-500 text-sm">{{$message}}</span>
                @enderror
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mt-2 mb-4">
            <div class="flex flex-col">
                {{-- Salary --}}
                <label for="min_salary" class="font-semibold">Estimated Salary (USD)<span class="text-sm text-red-500">*</span></label>
                <div class="flex flex-col md:flex-row gap-4"> {{-- Changed to flex-col for small screens and flex-row for medium and larger screens --}}
                    {{-- Minimum Salary --}}
                    <div class="flex flex-col w-full"> {{-- Use w-full to ensure full width on small screens --}}
                        <label for="min_salary" class="text-sm">Minimum Salary<span class="text-sm text-red-500">*</span></label>
                        <input type="number" name="min_salary" id="min_salary" min=0 value="{{old('min_salary')}}" class="bg-slate-600 font-semibold rounded-lg p-2 focus:outline-none focus:ring-2 focus:ring-cyan-300" required>
                        @error('min_salary')
                            <span class="text-red-500 text-sm">{{$message}}</span>
                        @enderror
                    </div>
                    {{-- Maximum Salary --}}
                    <div class="flex flex-col w-full"> {{-- Use w-full to ensure full width on small screens --}}
                        <label for="max_salary" class="text-sm">Maximum Salary<span class="text-sm text-red-500">*</span></label>
                        <input type="number" name="max_salary" min="0" id="max_salary" value="{{old('max_salary')}}" class="bg-slate-600 font-semibold rounded-lg p-2 focus:outline-none focus:ring-2 focus:ring-cyan-300" required>
                        @error('max_salary')
                            <span class="text-red-500 text-sm">{{$message}}</span>
                        @enderror
                    </div>
                </div>
            </div>
        </div>


        {{-- Location --}}
        <div class="mb-4 flex flex-col">
            <label for="location" class="font-semibold">Location<span class="text-sm text-red-500">*</span></label>
            <input type="text" name="location" id="location" value="{{old('location')}}" placeholder="City, Country" class="bg-slate-600 font-semibold rounded-lg p- focus:outline-none focus:ring-2 focus:ring-cyan-300">
            @error('location')
                <span class="text-red-500 text-sm">{{$message}}</span>
            @enderror
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            {{-- Tags --}}
            <div class="mb-4 flex flex-col">
                <label for="tags" class="font-semibold">Tags<span class="text-sm text-red-500">*</span></label>
                <select name="tags" id="tags" class="bg-slate-600 font-semibold rounded-lg p-2">
                    <option value="" class="text-gray-200" disabled selected>--Select a tag--</option>
                    <option value="Laravel">Laravel</option>
                    <option value="JavaScript">JavaScript</option>
                    <option value="Java">Java</option>
                    <option value="Golang">Golang</option>
                    <option value="Rust">Rust</option>
                </select>
                @error('tags')
                    <span class="text-red-500 text-sm">{{$message}}</span>
                @enderror
            </div>

            {{-- Job Type --}}
            <div class="mb-4 flex flex-col">
                <label for="job_type" class= "font-semibold">Job Type<span class="text-sm text-red-500">*</span></label> 
                <select name= "job_type" id= "job_type" value="{{old('job_type')}}" class= "bg-slate-600 font-semibold rounded-lg p-2 focus:outline-none focus:ring-2 focus:ring-cyan-300">
                    <option value="" class="text-gray-200" disabled selected>--Select Job Type--</option>
                    <option value= "onsite">On-site</option> 
                    <option value= "remote">Remote</option> 
                    <option value= "hybrid">Hybrid</option> 
                </select>
                @error('job_type')
                    <span class="text-red-500 text-sm">{{$message}}</span>
                @enderror 
            </div> 
            
        </div>
        {{--image upload--}}
        <div class="mb-4 flex flex-col">
            <label for="listing_logo" class="font-semibold">Company Logo</label>
            <input type="file" name="listing_logo" id="listing_logo" accept="image/*" class="file:px-2 file:py-1.5 file:border-none file:rounded-lg file:bg-slate-600
             file:text-white file:cursor-pointer rounded-md shadow-sm outline-none border-none file:outline-none shadow-cyan-300">
        </div> 
        <div>
            <button type="submit" class="bg-cyan-300 text-slate-700 px-2 py-1.5 rounded-md">Post Job</button>
        </div>
    </form> 
</div> 
@endsection
