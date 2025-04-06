@extends('layouts.dashboard')

@section('title', 'User Management')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="bg-white p-6 rounded-xl shadow-lg">
        <!-- Header -->
        <div class="flex items-center justify-between mb-4">
            <h2 class="text-2xl md:text-3xl font-bold text-gray-800">User Management</h2>
            <span class="text-sm text-gray-500">Total Users: {{ \App\Models\User::count() }}</span>
        </div>


        {{-- livewire Component --}}
        @livewire('user-management')
    </div>
</div>
@endsection