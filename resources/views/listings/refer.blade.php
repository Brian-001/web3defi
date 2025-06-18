@extends('layouts.dashboard')

@section('title', 'Refer Job Listing')

@section('content')
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 py-10">
        <livewire:job-referral-form :listing-id="$listing->id" />
    </div>

@endsection