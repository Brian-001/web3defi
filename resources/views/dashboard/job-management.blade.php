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

        {{-- Livewire component --}}
        @livewire('job-management')
    </div>
</div>
@endsection