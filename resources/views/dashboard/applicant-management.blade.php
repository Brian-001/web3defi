@extends('layouts.dashboard')

@section('title', 'Applicant Management')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="bg-white p-6 rounded-xl shadow-lg">
        <!-- Header -->
        <div class="flex items-center justify-between mb-4">
            <h2 class="text-2xl md:text-3xl font-bold text-gray-800">Applicant Management</h2>
            <span class="text-sm text-gray-500">Total Applicants: {{ \App\Models\JobApplication::count() }}</span>
        </div>

        <!-- Livewire Component -->
        @livewire('applicant-management')
    </div>
</div>
@endsection