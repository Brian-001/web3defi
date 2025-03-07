@extends('layouts.app-layouts')

@section('content')
<div class="grid grid-cols-1 items-center justify-center mb-10 bg-slate-700">
    <div class="p-6 rounded-lg shadow-lg w-full md:w-1/2 mt-10 md:mx-auto h-full">
        <form action="{{route('listings.update', $listing->id)}}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            {{-- Flash message for success --}}
            @if (session('success'))
                <div class="mt-4 bg-green-200 border border-green-400 text-green-700 px-4 py-3 rounded relative" role="alert">
                    {{ session('success')}}
                </div>
            @endif

            {{-- Form title --}}
            <div class="flex items-center justify-between mb-10">
                <div>
                    <h1 class="text-lg text-cyan-300 mb-4 place-items-center">Edit job</h1>
                </div>
                <div class="flex">
                    <a href="/" class="flex gap-1 hover:gap-2"><x-icons.arrow-uturn /> <span class="text-white"> Back</span></a>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-0 md:mb-10">

                {{-- Job Title --}}
                <div class="mb-4 flex flex-col">
                    <label for="listing_title" class="font-semibold text-slate-300 mb-2">Job Title <span class="text-sm text-red-500">*</span></label>
                    <input type="text" name="listing_title" id="listing_title" value="{{old('listing_title', $listing->listing_title)}}" class="text-white focus:outline-none focus:ring-2 focus:ring-cyan-300 bg-slate-600 font-semibold rounded-lg p-2" autocomplete="off" required>
                    @error('listing_title')
                        <span class="text-red-500 text-sm">{{$message}}</span>
                    @enderror
                </div>

                {{-- Location --}}
                <div class="mb-4 flex flex-col">
                    <label for="location" class="font-semibold text-slate-300 mb-2">Location<span class="text-sm text-red-500">*</span></label>
                    <input type="text" name="location" id="location" value="{{old('location', $listing->location)}}" placeholder="City, Country" 
                    class="text-white bg-slate-600 font-semibold rounded-lg p- focus:outline-none focus:ring-2 focus:ring-cyan-300">
                    @error('location')
                        <span class="text-red-500 text-sm">{{$message}}</span>
                    @enderror
                </div>

            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-0 md:mb-10">
                {{-- Company Description --}}
                <div class="mb-4 flex flex-col mr-4 w-full">
                    <label for="company_description" class="font-semibold text-slate-300 mb-2">Company Description</label>
                    <textarea name="company_description" id="company_description" cols="30" rows="5" 
                    placeholder="Summarised information about the company" class="text-white focus:outline-none focus:ring-2 focus:ring-cyan-300 bg-slate-600 h-32 resize-none p-2 rounded-lg">{{old('company_description', $listing->company_description)}}</textarea>
                    @error('company_description')
                        <span class="text-red-500 text-sm">{{$message}}</span>
                    @enderror
                </div>
    
                {{-- Job Description --}}
                <div class="mb-4 flex flex-col w-full">
                    <label for="job_description" class="font-semibold text-slate-300 mb-2">Job Description<span class="text-sm text-red-500">*</span></label>
                    <textarea name="job_description" id="job_description" cols="30" rows="5" placeholder="Enter job description" class="text-white focus:outline-none focus:ring-2 focus:ring-cyan-300 bg-slate-600 h-32 resize-none p-2 rounded-lg">{{old('job_description', $listing->job_description)}}</textarea>
                    @error('job_description')
                        <span class="text-red-500 text-sm">{{$message}}</span>
                    @enderror
                </div>
            </div>
            

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-0 md:mb-10">
                {{-- Job Roles --}}
                <div class="mb-4 flex flex-col mr-4 w-full">
                    <label for="job_roles" class="font-semibold text-slate-300 mb-2">Job Roles<span class="text-sm text-red-500">*</span></label>
                    <textarea name="job_roles" id="job_roles" cols="30" rows="5" placeholder="Rememeber to include fullstops after every statement" class="text-white focus:outline-none focus:ring-2 focus:ring-cyan-300 bg-slate-600 h-32 resize-none p-2 rounded-lg">{{old('job_roles', $listing->job_roles)}}</textarea>
                    @error('job_roles')
                        <span class="text-red-500 text-sm">{{$message}}</span>
                    @enderror
                </div>
                
                {{-- Additional Information --}}
                <div class="mb-4 flex flex-col w-full">
                    <label for="additional_info" class="font-semibold text-slate-300 mb-2">Additional Information</label>
                    <textarea name="additional_info" id="additional_info" cols="30" rows="5" placeholder="More info about job e.g., Benefits, Holidays" class="text-white focus:outline-none focus:ring-2 focus:ring-cyan-300 bg-slate-600 h-32 resize-none p-2 rounded-lg">{{old('additional_info', $listing->additional_info)}}</textarea>
                    @error('additional_info')
                        <span class="text-red-500 text-sm">{{$message}}</span>
                    @enderror
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-0 md:mb-10">
                {{-- Tags --}}
                <div class="mb-4 flex flex-col">
                    <label for="tags" class="font-semibold text-slate-300 mb-2">Tags<span class="text-sm text-red-500">*</span></label>
                    <div class="bg-slate-600 rounded-lg p-4 max-h-40 overflow-y-auto">
                        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-4">
                            @foreach ($tags as $tag)
                                <label class="flex items-center space-x-2 text-white cursor-pointer">
                                    <input 
                                        type="checkbox" 
                                        name="tags[]" 
                                        value="{{ $tag->id }}" 
                                        class="form-checkbox p-2 h-5 w-5 text-cyan-300 bg-slate-700 border-slate-500 rounded focus:ring-2 focus:ring-cyan-300"
                                        {{ in_array($tag->id, old('tags', $listing->tags ? json_decode($listing->tags, true) : [])) ? 'checked' : '' }}
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
               <div class="mb-4 flex flex-col">
                    <label for="job_type" class= "font-semibold text-white mb-2">Job Type<span class="text-sm text-red-500">*</span></label> 
                    <select name= "job_type" id= "job_type"  class= "bg-slate-600 font-semibold text-white rounded-lg p-2 focus:outline-none focus:ring-2 focus:ring-cyan-300">
                        <option value="" class="text-gray-200" disabled selected>--Select Job Type--</option>
                        <option value= "onsite" {{ old('job_type', $listing->job_type) == 'onsite' ? 'selected' : '' }} class="text-white">On-site</option> 
                        <option value= "remote" {{ old('job_type', $listing->job_type) == 'remote' ? 'selected' : '' }} class="text-white">Remote</option> 
                        <option value= "hybrid" {{ old('job_type', $listing->job_type) == 'hybrid' ? 'selected' : '' }} class="text-white">Hybrid</option> 
                    </select>
                    @error('job_type')
                        <span class="text-red-500 text-sm">{{$message}}</span>
                    @enderror 
                </div> 
            </div>
    
            
    
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                 {{--Salary placeholder--}}
                 <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mt-2 mb-4">
                    <div class="flex flex-col">
                        {{-- Salary --}}
                        <label for="min_salary" class="font-semibold text-white mb-2">Estimated Salary (USD)<span class="text-sm text-red-500">*</span></label>
                        <div class="flex flex-col md:flex-row gap-4"> {{-- Changed to flex-col for small screens and flex-row for medium and larger screens --}}
                            {{-- Minimum Salary --}}
                            <div class="flex flex-col w-full"> {{-- Use w-full to ensure full width on small screens --}}
                                <label for="min_salary" class="text-sm text-white mb-2">Minimum Salary<span class="text-sm text-red-500">*</span></label>
                                <input type="number" name="min_salary" id="min_salary" min=0
                                value="{{ old('min_salary', $listing->salary ? explode(' to ', $listing->salary)[0] : '') }}" 
                                 class="text-white bg-slate-600 font-semibold rounded-lg p-2 focus:outline-none focus:ring-2 focus:ring-cyan-300" required>
                                @error('min_salary')
                                    <span class="text-red-500 text-sm">{{$message}}</span>
                                @enderror
                            </div>
                            {{-- Maximum Salary --}}
                            <div class="flex flex-col w-full"> {{-- Use w-full to ensure full width on small screens --}}
                                <label for="max_salary" class="text-sm text-white mb-2">Maximum Salary<span class="text-sm text-red-500">*</span></label>
                                <input type="number" name="max_salary" min="0" id="max_salary" 
                                value="{{ old('max_salary', $listing->salary ? explode(' to ', $listing->salary)[1] : '') }}"
                                 class="text-white bg-slate-600 font-semibold rounded-lg p-2 focus:outline-none focus:ring-2 focus:ring-cyan-300" required>
                                @error('max_salary')
                                    <span class="text-red-500 text-sm">{{$message}}</span>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>
    
                
                
            </div>
            {{--image upload--}}
            <div class="mb-4 flex flex-col">
                <label for="listing_logo" class="font-semibold text-white mb-2">Company Logo</label>
                <input type="file" name="listing_logo" id="listing_logo" accept="image/*" class="file:px-2 file:py-1.5 file:border-none file:rounded-lg file:bg-slate-600
                 file:text-white text-white file:cursor-pointer rounded-md shadow-sm outline-none border-none file:outline-none shadow-cyan-300">
            </div> 
            <div>
                <button type="submit" class="bg-cyan-300 text-slate-700 px-2 py-1.5 rounded-md">Update Job</button>
            </div>
            
        </form> 
    </div>
    
</div> 
@endsection
