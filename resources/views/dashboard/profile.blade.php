@extends('layouts.dashboard')

@section('title', 'Profile')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="bg-white p-6 rounded-xl shadow-lg">
        <!-- Header -->
        <div class="flex items-center justify-between mb-6">
            <h2 class="text-2xl md:text-3xl font-bold text-gray-800">Profile</h2>
            <a href="{{ route('dashboard.index') }}" 
               class="flex items-center gap-2 text-sm font-semibold text-gray-700 hover:text-cyan-600 transition-colors duration-200">
                <x-icons.arrow-uturn />
                Back to Home
            </a>
        </div>

        <!-- Success/Error Messages -->
        @if (session('success'))
            <div class="mb-4 bg-green-100 border-l-4 border-green-500 text-green-700 p-4 rounded-r-lg" role="alert">
                {{ session('success') }}
            </div>
        @endif
        @if ($errors->any())
            <div class="mb-4 bg-red-100 border-l-4 border-red-500 text-red-700 p-4 rounded-r-lg" role="alert">
                <ul class="list-disc list-inside">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <!-- Profile Form -->
        <form action="{{ route('dashboard.profile.update') }}" method="POST" enctype="multipart/form-data" class="space-y-8">
            @csrf
            @method('PUT')

            <!-- User Information -->
            <div class="space-y-6">
                <h3 class="text-xl font-semibold text-gray-800">Personal Information</h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <!-- Name -->
                    <div class="space-y-2">
                        <label for="name" class="block text-sm font-semibold text-gray-800">Full Name</label>
                        <input type="text" name="name" id="name" value="{{ old('name', $user->name) }}" 
                               class="w-full p-2 text-sm text-gray-700 border rounded-md focus:outline-none focus:ring-2 focus:ring-cyan-500">
                        @error('name')
                            <span class="text-red-500 text-xs">{{ $message }}</span>
                        @enderror
                    </div>
                    <!-- Email -->
                    <div class="space-y-2">
                        <label for="email" class="block text-sm font-semibold text-gray-800">Email</label>
                        <input type="email" name="email" id="email" value="{{ old('email', $user->email) }}" 
                               class="w-full p-2 text-sm text-gray-700 border rounded-md focus:outline-none focus:ring-2 focus:ring-cyan-500">
                        @error('email')
                            <span class="text-red-500 text-xs">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
                <!-- Profile Picture -->
                <div class="space-y-2">
                    <label for="avatar" class="block text-sm font-semibold text-gray-800">Profile Picture</label>
                    <div class="flex items-center gap-4">
                        <input type="file" name="avatar" id="avatar" accept="image/*" 
                            class="block w-full text-sm text-gray-700 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:bg-cyan-50 file:text-cyan-700 file:cursor-pointer hover:file:bg-cyan-100 focus:outline-none focus:ring-2 focus:ring-cyan-500">
                        @if ($user->profile_photo_path)
                            <img src="{{ asset('storage/' . $user->profile_photo_path) }}" 
                                alt="Profile Picture" 
                                class="w-12 h-12 rounded-full object-cover border border-gray-200 shadow-sm">
                        @else
                            <div class="w-12 h-12 {{ 'bg-' . ['cyan-500', 'blue-500', 'green-500'][abs(crc32($user->name)) % 3] }} rounded-full flex items-center justify-center text-white text-lg font-semibold">
                                {{ strtoupper(substr(trim($user->name ?? ''), 0, 1) ?: '?') }}
                            </div>
                        @endif
                    </div>
                    @error('avatar')
                        <span class="text-red-500 text-xs">{{ $message }}</span>
                    @enderror
                </div>
                <!-- Role (Read-Only) -->
                <div class="space-y-2">
                    <label class="block text-sm font-semibold text-gray-800">Role</label>
                    <p class="text-sm text-gray-600">{{ ucfirst($user->role->name) }}</p>
                </div>
            </div>

            <!-- Notification Preferences -->
            <div class="space-y-6">
                <h3 class="text-xl font-semibold text-gray-800">Notification Preferences</h3>
                <div class="space-y-2">
                    <label class="flex items-center gap-2">
                        <input type="checkbox" name="notify_applications" {{ old('notify_applications', $user->notify_applications ?? true) ? 'checked' : '' }} 
                               class="h-4 w-4 text-cyan-500 border-gray-300 rounded focus:ring-cyan-500">
                        <span class="text-sm text-gray-700">Email me about new job applications</span>
                    </label>
                </div>
            </div>

            <!-- Submit Buttons -->
            <div class="flex justify-end gap-4">
                <a href="/" 
                   class="bg-gray-500 text-white text-sm font-semibold px-6 py-2 rounded-md hover:bg-gray-600 transition-colors duration-200">
                    Cancel
                </a>
                <button type="submit" 
                        class="bg-cyan-500 text-white text-sm font-semibold px-6 py-2 rounded-md hover:bg-cyan-600 transition-colors duration-200">
                    Save Changes
                </button>
            </div>
        </form>

        <!-- Two-Factor Authentication Section -->
    </div>
</div>
@endsection