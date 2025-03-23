@extends('layouts.dashboard')

@section('title', 'Dashboard')

@section('content')
<div class="container mx-auto px-4 py-8">
    <!-- Welcome Section -->
    <div class="bg-gradient-to-r from-gray-50 to-gray-100 p-6 rounded-xl shadow-lg mb-8">
        <h2 class="text-2xl md:text-3xl font-bold mb-4 text-gray-800 flex items-center gap-2">
            Welcome to Web3Defi, {{ auth()->user()->name }} <span class="text-cyan-500 text-xl">👋</span>
        </h2>
        <p class="text-gray-600 text-sm md:text-base leading-relaxed mb-6">
            Your hub for Web3 and developer opportunities. Build decentralized apps, code smart contracts, and connect with top-tier jobs and talent shaping the future of tech.
        </p>
        <div class="flex flex-col sm:flex-row items-center gap-4">
            <a href="/" 
               class="inline-block bg-cyan-600 text-white font-semibold px-6 py-3 rounded-lg hover:bg-cyan-700 transition-colors duration-200 shadow-md w-full sm:w-auto text-center">
                Explore Jobs
            </a>
            <a href="{{ route('dashboard.profile') }}" 
               class="inline-block text-cyan-600 hover:text-cyan-800 font-semibold px-6 py-3 rounded-lg border border-cyan-600 hover:bg-cyan-50 transition-colors duration-200 w-full sm:w-auto text-center">
                Complete Your Profile
            </a>
        </div>
    </div>

    @if (Auth::user()->hasRole('Admin'))
        <!-- Admin Stats -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
            <!-- Jobs Card -->
            <div class="bg-white p-6 rounded-xl shadow-lg hover:shadow-xl transition-shadow duration-200">
                <h3 class="text-lg font-semibold text-gray-800 mb-4">Jobs Overview</h3>
                <div class="grid grid-cols-3 gap-4 text-gray-600">
                    <div class="flex flex-col">
                        <p class="text-sm text-gray-500">Total Posted</p>
                        <p class="text-xl font-bold text-cyan-600">{{ \App\Models\Listing::count() }}</p>
                    </div>
                    <div class="flex flex-col">
                        <p class="text-sm text-gray-500">Active</p>
                        <p class="text-xl font-bold text-cyan-600">{{ \App\Models\Listing::where('listing_status', 'active')->count() }}</p>
                    </div>
                    <div class="flex flex-col">
                        <p class="text-sm text-gray-500">&nbsp;</p> <!-- Empty placeholder for alignment -->
                        <p class="text-xl font-bold text-cyan-600">&nbsp;</p>
                    </div>
                </div>
            </div>
        
            <!-- Users Card -->
            <div class="bg-white p-6 rounded-xl shadow-lg hover:shadow-xl transition-shadow duration-200">
                <h3 class="text-lg font-semibold text-gray-800 mb-4">User Roles</h3>
                <div class="grid grid-cols-3 gap-4 text-gray-600">
                    <div class="flex flex-col">
                        <p class="text-sm text-gray-500">Admins</p>
                        <p class="text-xl font-bold text-cyan-600">{{ $userStats['Admin'] ?? 0 }}</p>
                    </div>
                    <div class="flex flex-col">
                        <p class="text-sm text-gray-500">Employers</p>
                        <p class="text-xl font-bold text-cyan-600">{{ $userStats['Employer'] ?? 0 }}</p>
                    </div>
                    <div class="flex flex-col">
                        <p class="text-sm text-gray-500">Employees</p>
                        <p class="text-xl font-bold text-cyan-600">{{ $userStats['Employee'] ?? 0 }}</p>
                    </div>
                </div>
            </div>
        
            <!-- Recents Card -->
            <div class="bg-white p-6 rounded-xl shadow-lg hover:shadow-xl transition-shadow duration-200">
                <h3 class="text-lg font-semibold text-gray-800 mb-4">Recent Activity</h3>
                <div class="grid grid-cols-3 gap-4 text-gray-600">
                    <div class="flex flex-col">
                        <p class="text-sm text-gray-500">Jobs</p>
                        <p class="text-xl font-bold text-cyan-600">{{ \App\Models\Listing::count() }}</p>
                    </div>
                    <div class="flex flex-col">
                        <p class="text-sm text-gray-500">Applicants</p>
                        <p class="text-xl font-bold text-cyan-600">{{ \App\Models\JobApplication::count() }}</p>
                    </div>
                    <div class="flex flex-col">
                        <p class="text-sm text-gray-500">Users</p>
                        <p class="text-xl font-bold text-cyan-600">{{ \App\Models\User::count() }}</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Charts -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            <!-- Users Bar Chart -->
            <div class="bg-white p-6 rounded-xl shadow-lg">
                <h3 class="text-lg font-semibold text-gray-800 mb-4">User Distribution</h3>
                <div class="chart-container h-64">
                    <canvas id="usersChart"></canvas>
                </div>
            </div>

            <!-- Jobs Line Chart -->
            <div class="bg-white p-6 rounded-xl shadow-lg">
                <h3 class="text-lg font-semibold text-gray-800 mb-4">Jobs Over Time</h3>
                <div class="chart-container h-64">
                    <canvas id="listingsChart"></canvas>
                </div>
            </div>

            <!-- Job Categories Pie Chart -->
            <div class="bg-white p-6 rounded-xl shadow-lg">
                <h3 class="text-lg font-semibold text-gray-800 mb-4">Job Categories</h3>
                <div class="chart-container h-64">
                    <canvas id="jobTypeChart"></canvas>
                </div>
            </div>
        </div>

        <!-- Pass data to JS -->
        @push('scripts')
            <script>
                window.userStats = @json($userStats);
                window.listingsPerDay = @json($listingsPerDay);
                window.listingsByJobType = @json($listingsByJobType);
            </script>
        @endpush
    @endif
</div>
@endsection