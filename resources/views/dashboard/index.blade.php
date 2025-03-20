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

        @push('scripts')
        <!-- Chart.js -->
        <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.2/dist/chart.umd.min.js"></script>

        <!-- Users Bar Chart -->
        <script>
            const userStats = @json($userStats);
            const ctxUsers = document.getElementById('usersChart').getContext('2d');
            new Chart(ctxUsers, {
                type: 'bar',
                data: {
                    labels: Object.keys(userStats),
                    datasets: [{
                        label: 'Users',
                        data: Object.values(userStats),
                        backgroundColor: 'rgba(34, 211, 238, 0.6)', // Cyan-400
                        borderColor: 'rgba(34, 211, 238, 1)',
                        borderWidth: 1,
                        borderRadius: 4,
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    scales: {
                        y: { beginAtZero: true, title: { display: true, text: 'User Count', color: '#4B5563' } },
                        x: { title: { display: true, text: 'Roles', color: '#4B5563' } }
                    },
                    plugins: {
                        legend: { display: false },
                        title: { display: true, text: 'User Distribution', color: '#1F2937', font: { size: 16 } }
                    }
                }
            });
        </script>

        <!-- Listings Line Chart -->
        <script>
            const listingsPerDay = @json($listingsPerDay);
            const ctxListings = document.getElementById('listingsChart').getContext('2d');
            new Chart(ctxListings, {
                type: 'line',
                data: {
                    labels: Object.keys(listingsPerDay),
                    datasets: [{
                        label: 'Job Listings',
                        data: Object.values(listingsPerDay),
                        borderColor: 'rgba(34, 211,-diff238, 1)',
                        backgroundColor: 'rgba(34, 211, 238, 0.1)',
                        fill: true,
                        tension: 0.3,
                        pointBackgroundColor: 'rgba(34, 211, 238, 1)',
                        pointRadius: 4,
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    scales: {
                        y: { beginAtZero: true, title: { display: true, text: 'Listings', color: '#4B5563' } },
                        x: { title: { display: true, text: 'Date (Last 7 Days)', color: '#4B5563' } }
                    },
                    plugins: {
                        legend: { display: false },
                        title: { display: true, text: 'Jobs Over Time', color: '#1F2937', font: { size: 16 } }
                    }
                }
            });
        </script>

        <!-- Job Type Pie Chart -->
        <script>
            const listingsByJobType = @json($listingsByJobType);
            const ctxJobType = document.getElementById('jobTypeChart').getContext('2d');
            new Chart(ctxJobType, {
                type: 'pie',
                data: {
                    labels: Object.keys(listingsByJobType),
                    datasets: [{
                        label: 'Job Types',
                        data: Object.values(listingsByJobType),
                        backgroundColor: [
                            'rgba(34, 211, 238, 0.6)',  // Cyan-400
                            'rgba(16, 185, 129, 0.6)',  // Emerald-500
                            'rgba(59, 130, 246, 0.6)',  // Blue-500
                        ],
                        borderColor: [
                            'rgba(34, 211, 238, 1)',
                            'rgba(16, 185, 129, 1)',
                            'rgba(59, 130, 246, 1)',
                        ],
                        borderWidth: 1,
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: { position: 'bottom', labels: { color: '#4B5563' } },
                        title: { display: true, text: 'Job Categories', color: '#1F2937', font: { size: 16 } }
                    }
                }
            });
        </script>
        @endpush
    @endif
</div>
@endsection