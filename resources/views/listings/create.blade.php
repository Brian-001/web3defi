@extends('layouts.app-layouts')

@section('content')
<div class="flex items-center justify-center min-h-screen bg-slate-700">
    <form action="#" class="shadow-md bg-slate-700 p-6 rounded-lg w-full max-w-lg">
        @csrf

        <h1 class="text-2xl text-cyan-300 mb-4 place-items-center">Create a new job</h1>
        {{-- Listing Title --}}
        <div class="mb-4 flex flex-col">
            <label for="listing_title" class="font-semibold">Listing Title</label>
            <input type="text" name="listing_title" id="listing_title" class="bg-slate-600 font-semibold rounded-lg p-2" required>
        </div>

        <div class="flex flex-wrap">
            {{-- Company Description --}}
            <div class="mb-4 flex flex-col mr-4 w-full">
                <label for="company_description" class="font-semibold">Company Description</label>
                <textarea name="company_description" id="company_description" cols="30" rows="5" placeholder="Summarised information about the company" class="bg-slate-600 font-semibold rounded-lg h-32 resize-none p-2"></textarea>
            </div>

            {{-- Job Description --}}
            <div class="mb-4 flex flex-col w-full">
                <label for="job_description" class="font-semibold">Job Description</label>
                <textarea name="job_description" id="job_description" cols="30" rows="5" placeholder="Enter job description" class="bg-slate-600 font-semibold rounded-lg h-32 resize-none p-2"></textarea>
            </div>
        </div>

        <div class="flex flex-wrap">
            {{-- Job Roles --}}
            <div class="mb-4 flex flex-col mr-4 w-full">
                <label for="job_roles" class="font-semibold">Job Roles</label>
                <textarea name="job_roles" id="job_roles" cols="30" rows="5" placeholder="Enter roles and responsibilities" class="bg-slate-600 font-semibold rounded-lg h-32 resize-none p-2"></textarea>
            </div>
            
            {{-- Additional Information --}}
            <div class="mb-4 flex flex-col w-full">
                <label for="additional_info" class="font-semibold">Additional Information</label>
                <textarea name="additional_info" id="additional_info" cols="30" rows="5" placeholder="More info about job e.g., Benefits, Holidays" class="bg-slate-600 font-semibold rounded-lg h-32 resize-none p-2"></textarea>
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            {{-- Salary --}}
            <div class="mb-4 flex flex-col">
                <label for="salary" class="font-semibold">Salary</label>
                <input type="number" name="salary" id="salary" class="bg-slate-600 font-semibold rounded-lg p-2" required>
            </div>

            {{-- Location --}}
            <div class="mb-4 flex flex-col">
                <label for="location" class="font-semibold">Location</label>
                <input type="text" name="location" id="location" placeholder="City, Country" class="bg-slate-600 font-semibold rounded-lg p-2">
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            {{-- Tags --}}
            <div class="mb-4 flex flex-col">
                <label for="tags" class="font-semibold">Tags</label>
                <select name="tags" id="tags" class="bg-slate-600 font-semibold rounded-lg p-2">
                    <option value="">Select a tag</option>
                    <option value="Laravel">Laravel</option>
                    <option value="JavaScript">JavaScript</option>
                    <option value="Java">Java</option>
                    <option value="Golang">Golang</option>
                    <option value="Rust">Rust</option>
                </select>
            </div>

            {{-- Job Type --}}
            <div class="mb-4 flex flex-col">
                <label for="job_type" class= "font-semibold">Job Type</label> 
                <select name= "job_type"id= "job_type"class= "bg-slate-600 font-semibold rounded-lg p-2">
                    <option value= "onsite">On-site</option> 
                    <option value= "remote">Remote</option> 
                    <option value= "hybrid">Hybrid</option> 
                </select> 
            </div> 
            <div>
                <button type="submit" class="bg-cyan-300 text-slate-700 px-2 py-1.5 rounded-md">Post Job</button>
            </div>
        </div> 
    </form> 
</div> 
@endsection
