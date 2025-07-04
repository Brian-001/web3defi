@extends('layouts.dashboard')

@section('title', 'Edit Tag')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="bg-white p-6 rounded-xl shadow-lg max-w-lg mx-auto">
        <!-- Header -->
        <div class="flex items-center justify-between mb-6">
            <h1 class="text-2xl md:text-3xl font-bold text-gray-800">Edit Tag</h1>
            <a wire:navigate href="{{ route('tags.index') }}" 
               class="flex items-center gap-2 text-sm font-semibold text-gray-700 hover:text-cyan-600 transition-colors duration-200">
                <x-icons.arrow-uturn />
                Back to Tags
            </a>
        </div>

        <!-- Form -->
        <form action="{{ route('tags.update', $tag->id) }}" method="POST" class="space-y-6">
            @csrf
            @method('PUT')

            <!-- Tag Name -->
            <div class="space-y-2">
                <label for="tag_name" class="block text-sm font-semibold text-gray-800">
                    Tag Name <span class="text-red-500">*</span>
                </label>
                <input type="text" name="tag_name" id="tag_name" value="{{ old('tag_name', $tag->tag_name) }}" 
                       placeholder="e.g., JavaScript, PHP, Python" 
                       class="w-full p-2 text-sm text-gray-700 border rounded-md focus:outline-none focus:ring-2 focus:ring-cyan-500" 
                       autocomplete="off" required>
                @error('tag_name')
                    <span class="text-red-500 text-xs">{{ $message }}</span>
                @enderror
            </div>

            <!-- Submit Button -->
            <div class="flex justify-end gap-4">
                <a wire:navigate href="{{ route('tags.index') }}" 
                   class="bg-gray-500 text-white text-sm font-semibold px-6 py-2 rounded-md hover:bg-gray-600 transition-colors duration-200">
                    Cancel
                </a>
                <button type="submit" 
                        class="bg-cyan-500 text-white text-sm font-semibold px-6 py-2 rounded-md hover:bg-cyan-600 transition-colors duration-200">
                    Update Tag
                </button>
            </div>
        </form>
        
    </div>
</div>
@endsection