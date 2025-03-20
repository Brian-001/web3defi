@extends('layouts.dashboard')

@section('title', 'Home')

@section('content')
    <div class="bg-white p-6 rounded-lg shadow">
        <h2 class="text-2xl font-bold mb-4 text-gray-800">Welcome to web3Defi, {{ auth()->user()->name }} 😊!</h2>
        <p class="text-gray-600 mb-4">
            Your gateway to cutting-edge Web3 and developer opportunities awaits. Whether you're building decentralized apps, 
            coding smart contracts, or shaping the future of tech, this is your hub to connect with top-tier jobs and talent.
        </p>
        <div class="flex items-center gap-4">
            <a href="/" 
            class="inline-block bg-gray-600 text-white px-4 py-2 rounded-md hover:bg-gray-700 transition duration-200">
                Explore Jobs
            </a>
            <a href="{{ route('dashboard.profile') }}" 
            class="inline-block text-gray-600 hover:text-gray-800 font-semibold">
                Complete Your Profile
            </a>
        </div>
    </div>

    @if (Auth::user()->hasRole('Admin'))
                <!-- Static Stats (Update these dynamically if needed) -->
        <div class="grid grid-cols-1 md:grid-cols-3  gap-4 mt-6">
            <div class="bg-white p-6 rounded-lg shadow">
                <h3 class="text-lg font-bold mb-2">Jobs</h3>
                <div class="flex items-center justify-between">
                    <div class="flex flex-col">
                        <p class="text-base">Posted</p>
                        <p class="text-base">{{ \App\Models\Listing::count() }}</p>
                    </div>
                    <div class="flex flex-col">
                        <p class="text-base">Active</p>
                        <p class="text-base">{{ \App\Models\Listing::where('listing_status', 'active')->count() }}</p>
                    </div>
                </div>
            </div>
            
            <div class="bg-white p-6 rounded-lg shadow">
                <h3 class="text-lg font-bold mb-2">Users</h3>
                <div class="flex items-center justify-between">
                    <div class="flex flex-col">
                        <p class="text-base">Admin</p>
                        <p class="text-base">{{ $userStats['Admin'] ?? 0 }}</p>
                    </div>
                    <div class="flex flex-col">
                        <p class="text-base">Employers</p>
                        <p class="text-base">{{ $userStats['Employer'] ?? 0 }}</p>
                    </div>
                    <div class="flex flex-col">
                        <p class="text-base">Employees</p>
                        <p class="text-base">{{ $userStats['Employee'] ?? 0 }}</p>
                    </div>
                </div>
            </div>
            <div class="bg-white p-6 rounded-lg shadow">
                <h3 class="text-lg font-bold mb-2">Recents</h3>
                <div class="flex items-center justify-between">
                    <div class="flex flex-col"> 
                        <p class="text-base">Jobs</p>
                        <p class="text-base">{{ \App\Models\Listing::count() }}</p>
                    </div>
                    <div class="flex flex-col">
                        <p class="text-base">Applicants</p>
                        <p class="text-base">{{ \App\Models\JobApplication::count() }}</p>
                    </div>
                    <div class="flex flex-col">
                        <p class="text-base">Users</p>
                        <p class="text-base">{{\App\Models\User::count()}}</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Charts -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4 mt-6">
            <div class="bg-white p-6 rounded-lg shadow">
                <h3 class="text-lg font-bold mb-2">User's Bar Chart</h3>
                <div class="chart-container grid-height">
                    <canvas id="usersChart"></canvas>
                </div>
            </div>
            <div class="bg-white p-6 rounded-lg shadow">
                <h3 class="text-lg font-bold mb-2">Jobs Line Chart (Daily)</h3>
                <div class="chart-container grid-height">
                    <canvas id="listingsChart" class="grid-height"></canvas>
                </div>
            </div>
            <div class="bg-white p-6 rounded-lg shadow">
                <h3 class="text-lg font-bold mb-2">Job Categories Pie Chart</h3>
                <div class="chart-container">
                    <canvas id="jobTypeChart"></canvas>
                </div>
            </div>
        </div>

        @push('scripts')
        <!-- Include Chart.js (Ensure this is loaded) -->
        <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

        <!-- Users Bar Chart -->
        <script>
            const userStats = @json($userStats);
            const ctxUsers = document.getElementById('usersChart').getContext('2d');
            const usersChart = new Chart(ctxUsers, {
                type: 'bar',
                data: {
                    labels: Object.keys(userStats),
                    datasets: [{
                        label: 'Number of Users',
                        data: Object.values(userStats),
                        backgroundColor: ['rgba(255, 99, 132, 0.2)', 'rgba(54, 162, 235, 0.2)', 'rgba(255, 206, 86, 0.2)'],
                        borderColor: ['rgba(255, 99, 132, 1)', 'rgba(54, 162, 235, 1)', 'rgba(255, 206, 86, 1)'],
                        borderWidth: 1
                    }]
                },
                options: {
                    scales: {
                        y: { beginAtZero: true, title: { display: true, padding: 20, text: 'User Count' } },
                        x: { title: { display: true, text: 'User Roles' } }
                    },
                    plugins: {
                        legend: { display: false },
                        title: { display: true, text: 'Distribution of Users' }
                    }
                }
            });
        </script>

        <!-- Listings Line Chart (Daily) -->
        <script>
            const listingsPerDay = @json($listingsPerDay);
            const ctxListings = document.getElementById('listingsChart').getContext('2d');
            const listingsChart = new Chart(ctxListings, {
                type: 'line',
                data: {
                    labels: Object.keys(listingsPerDay), // e.g., ["2025-03-12", "2025-03-13", ...]
                    datasets: [{
                        label: 'Listings Per Day',
                        data: Object.values(listingsPerDay), // e.g., [5, 3, ...]
                        borderColor: 'rgba(75, 192, 192, 1)',
                        backgroundColor: 'rgba(75, 192, 192, 0.2)',
                        fill: false,
                        tension: 0.1
                    }]
                },
                options: {
                    scales: {
                        y: { beginAtZero: true, title: { display: true, text: 'Number of Listings' } },
                        x: { title: { display: true, text: 'Date (Last 7 Days)' } }
                    },
                    plugins: {
                        legend: { display: true },
                        title: { display: true, text: 'Job Listings Over Time' }
                    }
                }
            });
        </script>

        <!-- Job Type Pie Chart -->
        <script>
            const listingsByJobType = @json($listingsByJobType);
            const ctxJobType = document.getElementById('jobTypeChart').getContext('2d');
            const jobTypeChart = new Chart(ctxJobType, {
                type: 'pie',
                data: {
                    labels: Object.keys(listingsByJobType),
                    datasets: [{
                        label: 'Job Type Distribution',
                        data: Object.values(listingsByJobType),
                        backgroundColor: ['rgba(255, 206, 86, 0.6)', 'rgba(75, 192, 192, 0.6)', 'rgba(255, 159, 64, 0.6)'],
                        borderColor: ['rgba(255, 206, 86, 1)', 'rgba(75, 192, 192, 1)', 'rgba(255, 159, 64, 1)'],
                        borderWidth: 1
                    }]
                },
                options: {
                    plugins: {
                        legend: { position: 'bottom' },
                        title: { display: true, text: 'Distribution of Job Types' }
                    }
                }
            });
        </script>
        @endpush
    @endif

@endsection