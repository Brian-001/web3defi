@extends('layouts.dashboard')

@section('title', 'Profile')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="bg-white p-8 rounded-xl shadow-lg">
        <!-- Header -->
        <div class="flex items-center justify-between mb-8">
            <h2 class="text-3xl font-bold text-gray-900">Profile Settings</h2>
            <a href="{{ route('dashboard.index') }}"
                class="flex items-center gap-2 text-sm font-medium text-gray-600 hover:text-cyan-600 transition-colors duration-200">
                <x-icons.arrow-uturn class="w-4 h-4" />
                Back to Dashboard
            </a>
        </div>

        <!-- Alerts -->
        @if ($errors->any() || $errors->updateProfileInformation->any())
            <div class="mb-6 bg-red-50 border-l-4 border-red-500 text-red-700 p-4 rounded-r-lg" role="alert">
                <ul class="list-disc list-inside">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                    @foreach ($errors->updateProfileInformation->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        @if (session('success'))
            <div class="mb-6 bg-green-50 border-l-4 border-green-500 text-green-700 p-4 rounded-r-lg" role="alert">
                {{ session('success') }}
            </div>
        @endif



        <!-- ✅ Profile Update Form -->
        <form action="{{ route('dashboard.profile.update') }}" method="POST" enctype="multipart/form-data" class="space-y-10">
            @csrf
            @method('PUT')

            <!-- Personal Information -->
            <div class="space-y-6">
                <h3 class="text-xl font-semibold text-gray-900">Personal Information</h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="space-y-2">
                        <label for="name" class="block text-sm font-medium text-gray-700">Full Name</label>
                        <input type="text" name="name" id="name" value="{{ old('name', $user->name) }}"
                            class="w-full p-3 text-base text-gray-900 border border-gray-300 rounded-lg focus:ring-2 focus:ring-cyan-500">
                        @error('name', 'updateProfileInformation')
                            <p class="text-red-500 text-sm">{{ $message }}</p>
                        @enderror
                    </div>
                    <div class="space-y-2">
                        <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
                        <input type="email" name="email" id="email" value="{{ old('email', $user->email) }}"
                            class="w-full p-3 text-base text-gray-900 border border-gray-300 rounded-lg focus:ring-2 focus:ring-cyan-500">
                        @error('email', 'updateProfileInformation')
                            <p class="text-red-500 text-sm">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <!-- Avatar Upload -->
                <div class="space-y-2">
                    <label for="avatar" class="block text-sm font-semibold text-gray-800">Profile Picture</label>
                    <div class="flex items-center gap-4">
                        <input type="file" name="avatar" id="avatar" accept="image/*"
                            class="block w-full text-sm text-gray-700 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:bg-cyan-50 file:text-cyan-700 hover:file:bg-cyan-100 focus:ring-2 focus:ring-cyan-500">
                        @if ($user->profile_photo_path)
                        <img src="{{ asset('storage/' . $user->profile_photo_path) }}"
                            alt="Profile Picture"
                            class="w-12 h-12 rounded-full object-cover border border-gray-200 shadow-sm">
                        @else
                        <div class="w-12 h-12 {{ 'bg-' . ['cyan-500', 'blue-500', 'green-500'][abs(crc32($user->name)) % 3] }} rounded-full flex items-center justify-center text-white text-lg font-semibold">
                            {{ strtoupper(substr(trim($user->name ?? ''), 0, 1) ?: '?') }}
                        </div>
                        @endif
                        @error('avatar', 'updateProfileInformation')
                            <p class="text-red-500 text-sm">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </div>

            <!-- Notifications -->
            <div class="space-y-6">
                <h3 class="text-xl font-semibold text-gray-900">Notifications</h3>
                <div class="space-y-4">
                    <label class="flex items-center gap-4">
                        <input type="checkbox" name="notify_applications"
                            {{ old('notify_applications', $user->notify_applications ?? false) ? 'checked' : '' }}
                            class="h-4 w-4 text-sky-600 border-gray-300 rounded focus:ring-sky-200">
                        <span class="text-sm text-gray-600">Email me about notifications</span>
                    </label>
                </div>
            </div>

            <!-- Submit -->
            <div class="flex justify-end gap-2">
                <a href="{{ route('dashboard.profile') }}" class="px-4 py-2 text-sm font-semibold text-white bg-gray-600 rounded-lg hover:bg-gray-500">
                    Cancel
                </a>
                <button type="submit" class="px-4 py-2 text-sm font-semibold text-white bg-sky-700 rounded-lg hover:bg-sky-600">
                    Save Personal Information
                </button>
            </div>
        </form>

        <!-- ✅ Two-Factor Authentication Section -->
        <div class="space-y-6 mt-12">
            <h3 class="text-xl font-semibold text-gray-800">Two-Factor Authentication</h3>

            <div class="flex items-center justify-between bg-gray-50 p-4 rounded-lg border">
                <p class="text-sm text-gray-700">
                    Two-factor authentication is
                    @if (!auth()->user()->two_factor_secret)
                        <span class="font-semibold text-red-500">disabled</span>.
                    @elseif (!auth()->user()->two_factor_confirmed_at)
                        <span class="font-semibold text-yellow-500">pending confirmation</span>.
                    @else
                        <span class="font-semibold text-green-500">enabled</span>.
                    @endif
                </p>

                <div class="flex gap-2">
                    @if (!auth()->user()->two_factor_secret)
                        <form method="POST" action="{{ url('/user/two-factor-authentication') }}">
                            @csrf
                            <input type="hidden" name="from_profile" value="true" />
                            <button type="submit"
                                class="inline-flex items-center bg-green-600 text-white px-4 py-2 text-sm font-medium rounded-md hover:bg-green-700">
                                Enable
                            </button>
                        </form>
                    @else
                        <form method="POST" action="{{ url('/user/two-factor-authentication') }}">
                            @csrf
                            @method('DELETE')
                            <button type="submit"
                                class="inline-flex items-center bg-red-600 text-white px-4 py-2 text-sm font-medium rounded-md hover:bg-red-700">
                                Disable
                            </button>
                        </form>
                    @endif
                </div>
            </div>

            <!-- Confirm QR Setup -->
            @if (auth()->user()->two_factor_secret && !auth()->user()->two_factor_confirmed_at)
                <div class="bg-yellow-50 border-l-4 border-yellow-500 text-yellow-700 p-4 rounded">
                    <p>Please finish setting up 2FA by confirming the code from your authenticator app.</p>
                </div>

                <div class="bg-white border rounded-lg p-6 shadow-sm mt-4">
                    <p class="mb-3 text-sm text-gray-700 font-medium">Scan this QR code:</p>
                    <div>{!! auth()->user()->twoFactorQrCodeSvg() !!}</div>

                    <form method="POST" action="{{ url('/user/confirmed-two-factor-authentication') }}" class="mt-6 space-y-4">
                        @csrf
                        <label for="code" class="block text-sm font-semibold text-gray-700">Enter OTP from Authenticator App</label>
                        <input type="text" name="code" id="code" required
                            class="w-64 p-2 border rounded-md focus:ring-cyan-500 focus:border-cyan-500">
                        <button type="submit"
                            class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700 transition">
                            Confirm Setup
                        </button>
                    </form>
                </div>
            @endif

            <!-- Show Recovery Codes -->
            @if ($recoveryCodes = json_decode(decrypt(auth()->user()->two_factor_recovery_codes), true))
                <div x-data="{ copied: false }" class="mt-6 space-y-4">
                    <p class="text-sm font-medium text-gray-700">Recovery Codes:</p>

                    <div id="recovery-codes-list" class="grid grid-cols-2 md:grid-cols-3 gap-3 text-sm font-mono">
                        @foreach ($recoveryCodes as $code)
                            <div class="bg-gray-100 px-4 py-2 rounded text-gray-800 border border-gray-300 shadow-sm">
                                {{ $code }}
                            </div>
                        @endforeach
                    </div>

                    <div class="flex items-center gap-3 mt-2">
                        <!-- Copy Button -->
                        <button @click="
                            const codes = [...document.querySelectorAll('#recovery-codes-list div')].map(el => el.textContent).join('\n');
                            navigator.clipboard.writeText(codes).then(() => copied = true);
                            setTimeout(() => copied = false, 2000);
                        "
                            class="px-4 py-2 text-sm bg-sky-600 text-white rounded hover:bg-sky-700 transition">
                            Copy All
                        </button>

                        <!-- Feedback Toast -->
                        <div x-show="copied" x-transition class="text-sm text-green-600">
                            ✅ Copied to clipboard!
                        </div>
                    </div>
                </div>
            @endif

        </div>
    </div>
</div>
@endsection
