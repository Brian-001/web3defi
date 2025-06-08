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
                        @if ($user->avatar)
                            <img src="{{ asset('storage/' . $user->avatar) }}" 
                                 alt="Profile Picture" 
                                 class="w-12 h-12 rounded-full object-cover border border-gray-200 shadow-sm">
                        @else
                            <div class="w-12 h-12 bg-gray-100 rounded-full flex items-center justify-center text-gray-500 text-xs">No Image</div>
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

            <!-- Password Update -->
            <div class="space-y-6">
                <h3 class="text-xl font-semibold text-gray-800">Change Password</h3>
                <div class="grid grid-cols-1 gap-4">
                    <!-- Current Password -->
                    <div class="space-y-2">
                        <label for="current_password" class="block text-sm font-semibold text-gray-800">Current Password</label>
                        <input type="password" name="current_password" id="current_password" 
                               class="w-full lg:w-1/2 p-2 text-sm text-gray-700 border rounded-md focus:outline-none focus:ring-2 focus:ring-cyan-500">
                        @error('current_password')
                            <span class="text-red-500 text-xs">{{ $message }}</span>
                        @enderror
                    </div>
                    <!-- New Password -->
                    <div class="space-y-2">
                        <label for="password" class="block text-sm font-semibold text-gray-800">New Password</label>
                        <input type="password" name="password" id="password" 
                               class="w-full lg:w-1/2 p-2 text-sm text-gray-700 border rounded-md focus:outline-none focus:ring-2 focus:ring-cyan-500">
                        @error('password')
                            <span class="text-red-500 text-xs">{{ $message }}</span>
                        @enderror
                    </div>
                    <!-- Confirm Password -->
                    <div class="space-y-2">
                        <label for="password_confirmation" class="block text-sm font-semibold text-gray-800">Confirm New Password</label>
                        <input type="password" name="password_confirmation" id="password_confirmation" 
                               class="w-full lg:w-1/2 p-2 text-sm text-gray-700 border rounded-md focus:outline-none focus:ring-2 focus:ring-cyan-500">
                    </div>
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
        <div class="space-y-6 mt-10">
            <h3 class="text-xl font-semibold text-gray-800">Two-Factor Authentication</h3>

            <div class="flex items-center justify-between bg-gray-50 p-4 rounded-lg border">
                <div>
                    <p class="text-sm text-gray-700">
                        Two-factor authentication is
                        @if (!auth()->user()->two_factor_secret)
                            <span class="font-semibold text-red-500">disabled</span>.
                        @elseif(auth()->user()->two_factor_confirmed_at)
                            <span class="font-semibold text-green-500">enabled</span>.
                        @else
                            <span class="font-semibold text-yellow-500">pending confirmation</span>.
                        @endif
                        <br>
                        Enabling two-factor authentication adds an extra layer of security to your account.
                        You will need to use an authenticator app like Google Authenticator or Microsoft Authenticator.
                    </p>
                </div>

                <div>
                    @if (!auth()->user()->two_factor_secret)
                        <form method="POST" action="{{ url('/user/two-factor-authentication') }}">
                            @csrf
                            <button type="submit"
                                class="inline-flex items-center bg-green-600 text-white px-4 py-2 text-sm font-medium rounded-md hover:bg-green-700 transition">
                                Enable
                            </button>
                        </form>
                    @else
                        <form method="POST" action="{{ route('two-factor.disable') }}">
                            @csrf
                            @method('DELETE')
                            <button type="submit"
                                class="inline-flex items-center bg-red-600 text-white px-4 py-2 text-sm font-medium rounded-md hover:bg-red-700 transition">
                                Disable
                            </button>
                        </form>
                    @endif
                </div>
            </div>

            @if (auth()->user()->two_factor_secret && !auth()->user()->two_factor_confirmed_at)
                <!-- Show QR code and OTP input -->
                <div class="bg-white border rounded-lg p-6 shadow-sm">
                    <p class="mb-3 text-sm text-gray-700 font-medium">Scan the QR code using Google Authenticator or Microsoft Authenticator.</p>

                    <div>{!! auth()->user()->twoFactorQrCodeSvg() !!}</div>

                    <form method="POST" action="{{ url('/two-factor-challenge') }}" class="mt-6 space-y-4">
                        @csrf
                        <label for="code" class="block text-sm font-semibold text-gray-700">Enter OTP from app</label>
                        <input type="text" name="code" id="code" required
                               class="w-64 p-2 border rounded-md focus:ring-cyan-500 focus:border-cyan-500" />
                        <button type="submit"
                                class="bg-cyan-500 text-white px-4 py-2 rounded hover:bg-cyan-600 transition">
                            Confirm Setup
                        </button>
                    </form>

                    @if ($recoveryCodes = json_decode(decrypt(auth()->user()->two_factor_recovery_codes), true))
                        <div class="mt-6">
                            <p class="text-sm font-medium text-gray-700 mb-2">Your Recovery Codes:</p>
                            @foreach ($recoveryCodes as $code)
                                <div class="flex items-center gap-3 mb-2">
                                    <input
                                        type="text"
                                        readonly
                                        value="{{ $code }}"
                                        class="w-64 bg-gray-100 px-3 py-1 rounded font-mono text-sm border border-gray-300 focus:outline-none"
                                    />
                                    <button
                                        type="button"
                                        onclick="navigator.clipboard.writeText('{{ $code }}')"
                                        class="bg-cyan-500 text-white px-3 py-1 rounded text-sm hover:bg-cyan-600 transition">
                                        Copy
                                    </button>
                                </div>
                            @endforeach
                            <p class="text-xs text-gray-500 mt-1">Keep these recovery codes safe. They can be used if you lose access to your authenticator.</p>
                        </div>
                    @endif
                </div>
            @endif
        </div>
    </div>
</div>
@endsection