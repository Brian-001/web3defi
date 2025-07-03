@extends('layouts.app-layouts')

@section('title', 'Web3Defi | Login')

@section('head')
    <!-- Alpine.js for password toggle -->
    <script src="https://unpkg.com/alpinejs@3.14.1/dist/cdn.min.js" defer></script>
@endsection

@section('content')
<div class="flex min-h-screen bg-gradient-to-br from-slate-100 to-slate-200">
    <!-- Branding Panel: Visible on lg screens and above -->
    <div class="hidden lg:flex lg:w-1/3 bg-gradient-to-b from-slate-800 to-slate-900 text-white p-8 flex-col justify-center">
        <h1 class="text-4xl font-bold mb-4">Web3Defi</h1>
        <p class="text-lg">Welcome back to Web3Defi! Log in to access your account and explore our platform.</p>
    </div>

    <!-- Form Container -->
    <div class="flex items-center justify-center w-full lg:w-2/3 p-4 sm:p-6">
        <div class="bg-white p-6 sm:p-8 rounded-xl shadow-lg w-full max-w-md transition-all duration-300 hover:shadow-xl">
            <!-- Back Button -->
            <div class="mb-6 flex items-center justify-end">
                <a href="/" class="flex items-center gap-2 text-sm text-slate-600 hover:text-slate-800 transition-all duration-200 group">
                    <svg class="w-4 h-4 transform group-hover:-translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16l-4-4m0 0l4-4m-4 4h18"></path>
                    </svg>
                    Back
                </a>
            </div>

            <!-- Session Messages -->
            <div class="mb-6">
                @if (session('status'))
                    <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 rounded-md" role="alert">
                        <span class="text-sm">{{ session('status') }}</span>
                    </div>
                @endif
                @if (session('error'))
                    <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 rounded-md" role="alert">
                        <span class="text-sm">{{ session('error') }}</span>
                    </div>
                @endif
            </div>

            <!-- Form Header -->
            <h1 class="text-lg sm:text-xl font-bold text-slate-800 text-center mb-6">Log In to Your Account</h1>

            <!-- Form -->
            <form action="{{ route('login') }}" method="POST" class="space-y-6">
                @csrf

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
                                class="absolute inset-y-0 right-0 flex items-center pr-3 text-slate-500 hover:text-slate-700 focus:outline-none transition-all duration-200"
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
                    @error('password')
                        <span class="text-xs text-red-500 mt-1">{{ $message }}</span>
                    @enderror
                </div>

                <!-- Submit Button -->
                <div class="flex items-center justify-center">
                    <button type="submit" 
                            class="w-full sm:w-1/2 bg-blue-500 text-white font-semibold py-3 px-4 rounded-lg hover:bg-blue-600 focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition-all duration-200" aria-label="Log In">
                        Log In
                    </button>
                </div>

                <!-- Links -->
                <div class="flex items-center justify-center gap-4 text-center">
                    <a class="text-xs sm:text-sm text-blue-500 hover:underline" href="{{ route('register') }}">Create a new account?</a>
                    @if (Route::has('password.request'))
                        <a class="text-xs sm:text-sm text-blue-500 hover:underline" href="{{ route('password.request') }}">Forgot Password?</a>
                    @endif
                </div>
            </form>
        </div>
    </div>
</div>
@endsection