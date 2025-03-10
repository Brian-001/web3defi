@extends('layouts.dashboard')

@section('title', 'Home')

@section('content')
    <div class="bg-white p-6 rounded-lg shadow">
        <h2 class="text-2xl font-bold mb-4">Welcome to Dashboard</h2>
        <p>This is the home page of your dashboard.</p>
    </div>
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4 mt-6">
        <div class="bg-white p-6 rounded-lg shadow">
            <h3 class="text-lg font-bold mb-2">Jobs</h3>
            <div class="flex items-center justify-between">
                <div class="flex flex-col">
                    <p class="text-base">Posted</p>
                    <p class="text-base">122</p>
                </div>
                <div class="flex flex-col">
                    <p class="text-base">Active</p>
                    <p class="text-base">122</p>
                </div>
            </div>
        </div>
        <div class="bg-white p-6 rounded-lg shadow">
            <h3 class="text-lg font-bold mb-2">Applicants</h3>
            <div class="flex items-center justify-between">
                <div class="flex flex-col">
                    <p class="text-base">Total</p>
                    <p class="text-base">122</p>
                </div>
                <div class="flex flex-col">
                    <p class="text-base">New</p>
                    <p class="text-base">10</p>
                </div>
                <div class="flex flex-col">
                    <p class="text-base">Hired</p>
                    <p class="text-base">13</p>
                </div>
            </div>
        </div>
        <div class="bg-white p-6 rounded-lg shadow">
            <h3 class="text-lg font-bold mb-2">Users</h3>
            <div class="flex items-center justify-between">
                <div class="flex flex-col">
                    <p class="text-base">Admin</p>
                    <p class="text-base">1</p>
                </div>
                <div class="flex flex-col">
                    <p class="text-base">Employers</p>
                    <p class="text-base">10</p>
                </div>
                <div class="flex flex-col">
                    <p class="text-base">Employees</p>
                    <p class="text-base">13</p>
                </div>
            </div>
        </div>
        <div class="bg-white p-6 rounded-lg shadow">
            <h3 class="text-lg font-bold mb-2">Recents</h3>
            <div class="flex items-center justify-between">
                <div class="flex flex-col"> 
                    <p class="text-base">Jobs</p>
                    <p class="text-base">1</p>
                </div>
                <div class="flex flex-col">
                    <p class="text-base">Applicants</p>
                    <p class="text-base">10</p>
                </div>
                <div class="flex flex-col">
                    <p class="text-base">Users</p>
                    <p class="text-base">13</p>
                </div>
            </div>
        </div>
    </div>
    <!-- charts -->
    <!-- charts -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4 mt-6">
        <div class="bg-white p-6 rounded-lg shadow">
            <h3 class="text-lg font-bold mb-2">User's Bar Chart</h3>
            <div class="chart-container grid-height">
                <canvas id="usersChart"></canvas>
            </div>
        </div>
        <div class="bg-white p-6 rounded-lg shadow">
            <h3 class="text-lg font-bold mb-2">Jobs Line Chart</h3>
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
    <script>
        const userStats = @json($userStats);

        const ctx = document.getElementById('usersChart').getContext('2d');
        const usersChart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: Object.keys(userStats), // ['admin', 'employers', 'employees']
                datasets: [{
                    label: 'Number of Users',
                    data: Object.values(userStats),
                    backgroundColor: [
                        'rgba(255, 99, 132, 0.2)',
                        'rgba(54, 162, 235, 0.2)',
                        'rgba(255, 206, 86, 0.2)',
                    ],
                    borderColor: [
                        'rgba(255, 99, 132, 1)',
                        'rgba(54, 162, 235, 1)',
                        'rgba(255, 206, 86, 1)',
                    ],
                    borderWidth: 1
                }]
            },
            options: {
                scales: {
                    y: {
                        beginAtZero: true,
                        title: {
                            display: true,
                            padding: 20,
                            text: 'User Count'
                        }
                    },
                    x: {
                        title: {
                            display: true,
                            text: 'User Roles'
                        }
                    }
                },
                plugins: {
                    legend: {
                        display: false // Hide legend
                    },
                    title: {
                        display: true,
                        text: 'Distribution of Users'
                    }
                }
            }
        });

    </script>
    <script>
        const listingsPerDay = @json($listingsPerDay);
        const listingsPerWeek = @json($listingsPerWeek);
    
        const ctxListings = document.getElementById('listingsChart').getContext('2d');
        const listingsChart = new Chart(ctxListings, {
            type: 'line',
            data: {
                labels: Object.keys(listingsPerDay), // Daily dates
                datasets: [
                    {
                        label: 'Listings Per Day',
                        data: Object.values(listingsPerDay),
                        borderColor: 'rgba(75, 192, 192, 1)',
                        backgroundColor: 'rgba(75, 192, 192, 0.2)',
                        fill: false,
                        tension: 0.1
                    },
                    {
                        label: 'Listings Per Week',
                        data: Object.values(listingsPerWeek), // Weekly counts
                        borderColor: 'rgba(153, 102, 255, 1)',
                        backgroundColor: 'rgba(153, 102, 255, 0.2)',
                        fill: false,
                        tension: 0.1
                    }
                ]
            },
            options: {
                scales: {
                    y: { beginAtZero: true, title: { display: true, text: 'Number of Listings' } },
                    x: { title: { display: true, text: 'Time (Days)'} }
                },
                plugins: { 
                    legend: { 
                        display: true 
                    },
                    title: {
                        display: true,
                        text: 'Distribution of Job Types'
                    }
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
                labels: Object.keys(listingsByJobType), // e.g., ['Full-time', 'Part-time', 'Contract']
                datasets: [{
                    label: 'Job Type Distribution',
                    data: Object.values(listingsByJobType), // e.g., [10, 5, 3]
                    backgroundColor: [
                        'rgba(255, 206, 86, 0.6)',  // Yellow
                        'rgba(75, 192, 192, 0.6)',  // Teal
                        'rgba(255, 159, 64, 0.6)'   // Orange
                    ],
                    borderColor: [
                        
                        'rgba(255, 206, 86, 1)',
                        'rgba(75, 192, 192, 1)',
                        'rgba(255, 159, 64, 1)'
                    ],
                    borderWidth: 1
                }]
            },
            options: {
                plugins: {
                    legend: {
                        position: 'bottom', // Place legend at the top
                    },
                    title: {
                        display: true,
                        text: 'Distribution of Job Types'
                    }
                }
            }
        });
    </script>
    @endpush
@endsection