@extends('layouts.dashboard')

@section('content')
<div class="grid grid-cols-1 items-center justify-center mb-10 bg-white rounded-lg p-6">
    <div class="p-6 rounded-lg shadow-lg w-full mt-10 md:mx-auto h-full">
        <form action="{{route('listings.store')}}" method="POST" enctype="multipart/form-data">
            @csrf
            
            {{-- Flash message for success --}}
            @if (session('success'))
                <div class="mt-4 bg-green-200 border border-green-400 text-green-700 px-4 py-3 rounded relative" role="alert">
                    {{ session('success')}}
                </div>
            @endif

            {{-- Form title --}}
            <div class="flex items-center justify-between mb-10">
                <div>
                    <h1 class="text-lg text-cyan-500 mb-4 place-items-center">Create job</h1>
                </div>
                <div class="flex">
                    <a href="{{ route('dashboard.job-management') }}" class="flex gap-1 hover:gap-2"><x-icons.arrow-uturn class="text-white"/> <span class="text-slate-700 font-semibold"> Back</span></a>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-0 md:mb-10 shadow-md">

                {{-- Job Title --}}
                <div class="mb-4 flex flex-col px-6 py-4">
                    <label for="listing_title" class="font-semibold mb-2">Job Title <span class="text-sm text-red-500">*</span></label>
                    <input type="text" name="listing_title" id="listing_title" value="{{old('listing_title')}}" class="text-slate-700 focus:outline-none rounded-lg p-2 border-b" autocomplete="off" required>
                    @error('listing_title')
                        <span class="text-red-500 text-sm">{{$message}}</span>
                    @enderror
                </div>

                {{-- Location --}}
                <div class="mb-4 flex flex-col px-6 py-4">
                    <label for="location" class="font-semibold mb-2">Location<span class="text-sm text-red-500">*</span></label>
                    <input type="text" name="location" id="location" value="{{old('location')}}" placeholder="City, Country" 
                    class="text-slate-700 rounded-lg p- focus:outline-none">
                    @error('location')
                        <span class="text-red-500 text-sm">{{$message}}</span>
                    @enderror
                </div>

            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-0 md:mb-10 shadow-md">
                {{-- Company Description --}}
                <div class="mb-4 flex flex-col mr-4 w-full px-6 py-4">
                    <label for="company_description" class="font-semibold mb-2">Company Description</label>
                    <textarea name="company_description" id="company_description" cols="30" rows="5" 
                    placeholder="Summarised information about the company" class="text-slate-700 focus:outline-none h-32 resize-none p-2 rounded-lg">{{old('company_description')}}</textarea>
                    @error('company_description')
                        <span class="text-red-500 text-sm">{{$message}}</span>
                    @enderror
                </div>
    
                {{-- Job Description --}}
                <div class="mb-4 flex flex-col w-full px-6 py-4">
                    <label for="job_description" class="font-semibold mb-2">Job Description<span class="text-sm text-red-500">*</span></label>
                    <textarea name="job_description" id="job_description" cols="30" rows="5" placeholder="Enter job description" class="text-slate-700 focus:outline-none h-32 resize-none p-2 rounded-lg">{{old('job_description')}}</textarea>
                    @error('job_description')
                        <span class="text-red-500 text-sm">{{$message}}</span>
                    @enderror
                </div>
            </div>
            

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-0 md:mb-10 shadow-md">
                {{-- Job Roles --}}
                <div class="mb-4 flex flex-col mr-4 w-full px-6 py-4">
                    <label for="job_roles" class="font-semibold mb-2">Job Roles<span class="text-sm text-red-500">*</span></label>
                    <textarea name="job_roles" id="job_roles" cols="30" rows="5" placeholder="Rememeber to include fullstops after every statement" class="text-slate-700 focus:outline-none h-32 resize-none p-2 rounded-lg">{{old('job_roles')}}</textarea>
                    @error('job_roles')
                        <span class="text-red-500 text-sm">{{$message}}</span>
                    @enderror
                </div>
                
                {{-- Additional Information --}}
                <div class="mb-4 flex flex-col w-full px-6 py-4">
                    <label for="additional_info" class="font-semibold mb-2">Additional Information</label>
                    <textarea name="additional_info" id="additional_info" cols="30" rows="5" placeholder="More info about job e.g., Benefits, Holidays" class="text-slate-700 focus:outline-none h-32 resize-none p-2 rounded-lg">{{old('additional_info')}}</textarea>
                    @error('additional_info')
                        <span class="text-red-500 text-sm">{{$message}}</span>
                    @enderror
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-0 md:mb-10">
                {{-- Tags --}}
                <div class="mb-4 flex flex-col px-6 py-4">
                    <label for="tags" class="font-semibold mb-2">Tags<span class="text-sm text-red-500">*</span></label>
                    <div class=" rounded-lg p-4 max-h-56 overflow-y-auto">
                        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-4">
                            @foreach ($tags as $tag)
                                <label class="flex items-center space-x-2 text-slate-700 cursor-pointer">
                                    <input 
                                        type="checkbox" 
                                        name="tags[]" 
                                        value="{{ $tag->id }}" 
                                        class="form-checkbox p-2 h-5 w-5 text-cyan-300 border-slate-500 rounded focus:ring-2 focus:ring-cyan-300"
                                    >
                                    <span class="font-semibold">{{ $tag->tag_name }}</span>
                                </label>
                            @endforeach
                        </div>
                    </div>
                    @error('tags')
                        <span class="text-red-500 text-sm">{{ $message }}</span>
                    @enderror
                </div>

               {{-- Job Type --}}
               <div class="mb-4 flex flex-col px-6 py-4">
                    <label for="job_type" class= "font-semibold mb-2">Job Type<span class="text-sm text-red-500">*</span></label> 
                    <select name= "job_type" id= "job_type" value="{{old('job_type')}}" class= "font-semibold text-slate-700 rounded-lg p-2 focus:outline-none focus:ring-2 focus:ring-cyan-300">
                        <option value="" class="text-gray-500" disabled selected>--Select Job Type--</option>
                        <option value= "onsite" class="text-slate-700">On-site</option> 
                        <option value= "remote" class="text-slate-700">Remote</option> 
                        <option value= "hybrid" class="text-slate-700">Hybrid</option> 
                    </select>
                    @error('job_type')
                        <span class="text-red-500 text-sm">{{$message}}</span>
                    @enderror 
                </div> 
            </div>
    
            
    
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                 {{--Salary placeholder--}}
                 <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mt-2 mb-4">
                    <div class="flex flex-col px-6 py-4">
                        {{-- Salary --}}
                        <label for="min_salary" class="font-semibold mb-2">Estimated Salary (USD)<span class="text-sm text-red-500">*</span></label>
                        <div class="flex flex-col md:flex-row gap-4"> {{-- Changed to flex-col for small screens and flex-row for medium and larger screens --}}
                            {{-- Minimum Salary --}}
                            <div class="flex flex-col w-full"> {{-- Use w-full to ensure full width on small screens --}}
                                <label for="min_salary" class="text-sm mb-2 font-medium">Minimum Salary<span class="text-sm text-red-500">*</span></label>
                                <input type="number" name="min_salary" id="min_salary" min=0 value="{{old('min_salary')}}" class="text-slate-700 rounded-lg p-2 focus:outline-none focus:ring-2 focus:ring-cyan-300" required>
                                @error('min_salary')
                                    <span class="text-red-500 text-sm">{{$message}}</span>
                                @enderror
                            </div>
                            {{-- Maximum Salary --}}
                            <div class="flex flex-col w-full"> {{-- Use w-full to ensure full width on small screens --}}
                                <label for="max_salary" class="text-sm mb-2 font-medium">Maximum Salary<span class="text-sm text-red-500">*</span></label>
                                <input type="number" name="max_salary" min="0" id="max_salary" value="{{old('max_salary')}}" class="text-slate-700 rounded-lg p-2 focus:outline-none focus:ring-2 focus:ring-cyan-300" required>
                                @error('max_salary')
                                    <span class="text-red-500 text-sm">{{$message}}</span>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>
    
                
                
            </div>
            {{--image upload--}}
            <div class="mb-6 px-6 py-4 bg-white rounded-lg shadow-md">
                <div class="grid grid-cols-1 gap-4 md:items-start">
                    <!-- Label -->
                    <label for="listing_logo" class="block text-sm font-semibold text-gray-700 md:mt-2">
                        Company Logo
                    </label>
            
                    <!-- File Input -->
                    <div class="mt-2">
                        <input 
                            type="file" 
                            name="listing_logo" 
                            id="listing_logo" 
                            accept="image/*" 
                            class="block w-full text-sm text-gray-700 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border file:border-dashed file:border-gray-300 file:bg-gray-50 file:text-gray-700 file:cursor-pointer hover:file:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-cyan-500 focus:ring-offset-2 cursor-pointer"
                        >
                    </div>
            
                    <!-- Preview Image -->
                    <div class="mt-2 flex justify-center md:justify-start">
                        {{-- <img 
                            src="{{ $listing->listing_logo ? asset('storage/' . $listing->listing_logo) : asset('images/default_logo.jpg') }}" 
                            alt="Company Logo" 
                            class="w-16 h-16 rounded-full object-cover border border-gray-200 shadow-sm"
                        > --}}
                    </div>
                </div>
                <div class="px-6 py-4 flex items-center justify-center">
                    <button type="submit" class="font-semibold bg-cyan-300 text-slate-700 py-2 md:py-3 w-1/2 rounded-md hover:bg-cyan-500 hover:text-white">Create Job</button>
                </div>
            </div> 
            
        </form> 
    </div>
    
</div> 
@endsection