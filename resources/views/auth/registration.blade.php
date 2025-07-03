@extends('layouts.app-layouts')

@section('title', 'Register')

@section('head')
    <!-- Alpine.js for password toggle -->
    <script src="https://unpkg.com/alpinejs@3.14.1/dist/cdn.min.js" defer></script>
@endsection

@section('content')
<div class="flex min-h-screen bg-gradient-to-br from-slate-100 to-slate-200">
    <!-- Branding Panel: Visible on lg screens and above -->
    <div class="hidden lg:flex lg:w-1/3 bg-gradient-to-b from-slate-800 to-slate-900 text-white p-8 flex-col justify-center">
        <h1 class="text-4xl font-bold mb-4">Web3Defi</h1>
        <p class="text-lg">Welcome to Web3Defi! Join our platform to explore innovative opportunities and connect with our community.</p>
    </div>

    <!-- Form Container -->
    <div class="flex items-center justify-center w-full lg:w-2/3 p-4 sm:p-6">
        <div class="bg-white p-6 sm:p-8 rounded-xl shadow-lg w-full max-w-2xl transition-all duration-300 hover:shadow-xl">
            <!-- Back Button -->
            <div class="mb-6 flex items-center justify-end">
                <a href="/" class="flex items-center gap-2 text-sm text-slate-600 hover:text-slate-800 transition-all duration-200 group">
                    <svg class="w-4 h-4 transform group-hover:-translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16l-4-4m0 0l4-4m-4 4h18"></path>
                    </svg>
                    Back
                </a>
            </div>

            <!-- Form Header -->
            <h1 class="text-2xl sm:text-3xl font-bold text-slate-800 text-center mb-8">Create Your Account</h1>

            <!-- Form -->
            <form action="{{ route('register') }}" method="POST" class="space-y-6">
                @csrf

                <!-- Two-Column Grid for Medium and Larger Devices -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 sm:gap-6">
                    <!-- Name Field -->
                    <div>
                        <label for="name" class="block text-sm font-medium text-slate-700">Full Name</label>
                        <input type="text" id="name" name="name" value="{{ old('name') }}" required autocomplete="off" 
                               class="mt-1 p-3 w-full rounded-lg border border-slate-300 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200 @error('name') border-red-500 @enderror" aria-label="Full Name">
                        @error('name')
                            <span class="text-xs text-red-500 mt-1">{{ $message }}</span>
                        @enderror
                    </div>

                    <!-- Email Field -->
                    <div>
                        <label for="email" class="block text-sm font-medium text-slate-700">Email Address</label>
                        <input type="email" id="email" name="email" value="{{ old('email') }}" required autocomplete="off" 
                               class="mt-1 p-3 w-full rounded-lg border border-slate-300 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200 @error('email') border-red-500 @enderror" aria-label="Email Address">
                        @error('email')
                            <span class="text-xs text-red-500 mt-1">{{ $message }}</span>
                        @enderror
                    </div>

                    <!-- Password Field with Toggle -->
                    <div x-data="{ showPassword: false }">
                        <label for="password" class="block text-sm font-medium text-slate-700">Password</label>
                        <div class="relative">
                            <input :type="showPassword ? 'text' : 'password'" id="password" name="password" required 
                                   class="mt-1 p-3 pr-10 w-full rounded-lg border border-slate-300 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200 @error('password') border-red-500 @enderror" aria-label="Password">
                            <button type="button" @click="showPassword = !showPassword" 
                                    class="absolute inset-y-0 right-0 flex items-center pr-3 text-slate-500 hover:text-slate-700 focus:outline-none focus:ring-2 focus:ring-blue-500 rounded-r-lg transition-all duration-200"
                                    :aria-label="showPassword ? 'Hide password' : 'Show password'">
                                <svg x-show="!showPassword" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                </svg>
                                <svg x-show="showPassword" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.542-7a9.97 9.97 0 011.487-3.725m2.838-1.1A10.05 10.05 0 0112 5c4.478 0 8.268 2.943 9.542 7a9.97 9.97 0 01-1.487 3.725m-2.838 1.1A3 3 0 0015 12a3 3 0 00-1.875 6.825M3 3l18 18"></path>
                                </svg>
                            </button>
                        </div>
                        <span class="text-xs text-slate-600 mt-1 block">Password must be at least 8 characters or above.</span>
                        @error('password')
                            <span class="text-xs text-red-500 mt-1">{{ $message }}</span>
                        @enderror
                    </div>

                    <!-- Confirm Password Field with Toggle -->
                    <div x-data="{ showConfirmPassword: false }">
                        <label for="password_confirmation" class="block text-sm font-medium text-slate-700">Confirm Password</label>
                        <div class="relative">
                            <input :type="showConfirmPassword ? 'text' : 'password'" id="password_confirmation" name="password_confirmation" required 
                                   class="mt-1 p-3 pr-10 w-full rounded-lg border border-slate-300 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200 @error('password_confirmation') border-red-500 @enderror" aria-label="Confirm Password">
                            <button type="button" @click="showConfirmPassword = !showConfirmPassword" 
                                    class="absolute inset-y-0 right-0 flex items-center pr-3 text-slate-500 hover:text-slate-700 focus:outline-none focus:ring-2 focus:ring-blue-500 rounded-r-lg transition-all duration-200"
                                    :aria-label="showConfirmPassword ? 'Hide confirm password' : 'Show confirm password'">
                                <svg x-show="!showConfirmPassword" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                </svg>
                                <svg x-show="showConfirmPassword" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.542-7a9.97 9.97 0 011.487-3.725m2.838-1.1A10.05 10.05 0 0112 5c4.478 0 8.268 2.943 9.542 7a9.97 9.97 0 01-1.487 3.725m-2.838 1.1A3 3 0 0015 12a3 3 0 00-1.875 6.825M3 3l18 18"></path>
                                </svg>
                            </button>
                        </div>
                        @error('password_confirmation')
                            <span class="text-xs text-red-500 mt-1">{{ $message }}</span>
                        @enderror
                    </div>
                </div>

                <!-- Role Selection as Cards -->
                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-2">Select Role</label>
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        @forelse ($roles as $role)
                            <label class="relative block">
                                <input type="radio" name="role_id" value="{{ $role->id }}" class="absolute opacity-0 peer" required>
                                <div class="bg-white p-4 rounded-lg border border-slate-300 cursor-pointer transition-all duration-200 peer-checked:border-blue-500 peer-checked:shadow-lg hover:bg-slate-50 flex items-center gap-3">
                                    <svg class="w-6 h-6 text-blue-500 hidden peer-checked:block" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                    </svg>
                                    <div>
                                        <h3 class="text-lg font-semibold text-slate-800">{{ $role->name }}</h3>
                                        <p class="text-sm text-slate-600">Register as {{ $role->name }}</p>
                                    </div>
                                </div>
                            </label>
                        @empty
                            <p class="text-sm text-red-500">No roles available. Please contact support.</p>
                        @endforelse
                    </div>
                    @error('role_id')
                        <span class="text-xs text-red-500 mt-2 block">{{ $message }}</span>
                    @enderror
                </div>

                <!-- Submit Button -->
                <div class="flex items-center justify-center mt-6">
                    <button type="submit" 
                            class="w-full sm:w-1/2 bg-blue-500 text-white font-semibold py-3 px-4 rounded-lg hover:bg-blue-600 focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition-all duration-200" aria-label="Register">
                        Register
                    </button>
                </div>

                <!-- Login Link -->
                <div class="text-center">
                    <p class="text-sm text-slate-600">
                        Already have an account? 
                        <a href="{{ route('login') }}" class="text-blue-500 hover:underline">Log in</a>
                    </p>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection