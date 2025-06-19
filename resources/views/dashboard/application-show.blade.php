@extends('layouts.dashboard')

@section('content')
<div class="max-w-3xl mx-auto p-6 bg-white rounded-lg shadow-md">
    <h1 class="text-2xl font-semibold text-gray-800 mb-4">{{ $jobApplication->listing->listing_title }}</h1>
    <div class="space-y-4">
        <p><strong>Applicant:</strong> {{ $jobApplication->name ?? 'N/A' }}</p>
        <p><strong>Email:</strong> {{ $jobApplication->email ?? 'N/A' }}</p>
        <p><strong>Status:</strong> {{ ucfirst(str_replace('_', ' ', $jobApplication->application_status ?? 'submitted')) }}</p>
        @if ($jobApplication->resume_path && Storage::disk('public')->exists($jobApplication->resume_path))
            <p><strong>Resume:</strong> <a href="{{ asset('storage/' . $jobApplication->resume_path) }}" target="_blank" class="text-cyan-600 hover:underline">View</a></p>
        @else
            <p><strong>Resume:</strong> <span class="text-gray-500">No resume uploaded</span></p>
        @endif
        @if ($jobApplication->github)
            <p><strong>GitHub:</strong> <a href="{{ $jobApplication->github }}" target="_blank" class="text-cyan-600 hover:underline">{{ Str::limit($jobApplication->github, 50) }}</a></p>
        @endif
        @if ($jobApplication->linkedin)
            <p><strong>LinkedIn:</strong> <a href="{{ $jobApplication->linkedin }}" target="_blank" class="text-cyan-600 hover:underline">{{ Str::limit($jobApplication->linkedin, 50) }}</a></p>
        @endif
        @if ($jobApplication->answers && is_array($jobApplication->answers))
            <div>
                <h2 class="text-lg font-semibold text-gray-700 mt-4">Answers to Job Questions</h2>
                @foreach ($jobApplication->answers as $questionId => $answer)
                    @php
                        $question = $jobApplication->listing->questions->firstWhere('id', $questionId);
                    @endphp
                    @if ($question)
                        <p class="mt-2">
                            <strong class="relative group">
                                {{ $question->question_text }}
                                <span class="absolute hidden group-hover:block bg-gray-800 text-white text-xs rounded p-2 -top-10">
                                    {{ ucfirst($question->input_type) }} {{ $question->is_required ? '(Required)' : '' }}
                                </span>
                            </strong>:
                            @if (is_array($answer))
                                @if (empty($answer))
                                    None selected
                                @else
                                    <ul class="list-disc pl-5">
                                        @foreach ($answer as $option)
                                            <li>{{ $option }}</li>
                                        @endforeach
                                    </ul>
                                @endif
                            @else
                                {{ $answer }}
                            @endif
                        </p>
                    @else
                        <p class="mt-2 text-gray-500">Question ID {{ $questionId }} not found</p>
                    @endif
                @endforeach
            </div>
        @elseif ($jobApplication->answers)
            <p class="text-gray-500">Invalid answers format</p>
        @else
            <p class="text-gray-500">No answers provided</p>
        @endif
        @if ($jobApplication->referrer)
            <p><strong>Referred By:</strong> {{ $jobApplication->referrer->name }}</p>
        @else
            <p><strong>Referred By:</strong> <span class="text-gray-500">Direct</span></p>
        @endif
        <p><strong>Application Type:</strong> {{ ucfirst($jobApplication->application_type ?? 'employee') }}</p>
    </div>
    <div class="mt-6">
        <a href="{{ route('dashboard.applicant-management') }}" class="text-cyan-600 hover:underline">Back to Applicants</a>
    </div>
</div>
@endsection