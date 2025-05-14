@extends('layouts.dashboard')

@section('title', 'Refer Job Listing')

@section('content')
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 py-12">
        <h1 class="text-3xl font-bold mb-6">Refer an Employee for {{ $listing->title }}</h1>
        <livewire:job-referral-form :listing-id="$listing->id" />
    </div>

@endsection