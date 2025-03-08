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
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-4 mt-6">
        <div class="bg-white p-6 rounded-lg shadow">
            <h3 class="text-lg font-bold mb-2">User's Bar Chart</h3>
            <canvas id="jobsChart"></canvas>
        </div>
        <div class="bg-white p-6 rounded-lg shadow">
            <h3 class="text-lg font-bold mb-2">Jobs Line Chart</h3>
            <canvas id="applicantsChart"></canvas>  
        </div>
        <div class="bg-white p-6 rounded-lg shadow">
            <h3 class="text-lg font-bold mb-2">Job Categories Pie Chart</h3>
            <canvas id="usersChart"></canvas>
        </div>
    </div>
@endsection