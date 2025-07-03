@extends('layouts.dashboard')

@section('title', 'Job Application Details')
@section('content')
<div class="max-w-4xl mx-auto p-4 sm:p-6 lg:p-8 bg-white rounded-xl shadow-lg">
    <!-- Header -->
    <header class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-6 sm:mb-8">
        <h1 class="text-2xl sm:text-3xl font-bold text-gray-900">{{ $jobApplication->listing->listing_title }}</h1>
        <div class="mt-4 sm:mt-0 flex items-center gap-4">
            @php
                $statusClasses = match ($jobApplication->application_status ?? 'submitted') {
                    'submitted' => 'bg-blue-100 text-blue-800',
                    'reviewed' => 'bg-green-100 text-green-800',
                    'rejected' => 'bg-red-100 text-red-800',
                    default => 'bg-gray-100 text-gray-800',
                };
            @endphp
            <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium {{ $statusClasses }}">
                {{ ucfirst(str_replace('_', ' ', $jobApplication->application_status ?? 'submitted')) }}
            </span>
            <button type="button" 
                    class="text-sm text-cyan-600 hover:text-cyan-800 font-medium transition-colors"
                    aria-label="Update application status"
                    wire:click="openStatusModal">
                Update Status
            </button>
        </div>
    </header>

    <!-- Content -->
    <div class="space-y-8">
        <!-- Applicant Details -->
        <section>
            <h2 class="text-lg sm:text-xl font-semibold text-gray-800 mb-4">Applicant Details</h2>
            <dl class="grid grid-cols-1 sm:grid-cols-2 gap-4 sm:gap-6">
                <div>
                    <dt class="text-sm font-medium text-gray-600">Applicant Name</dt>
                    <dd class="mt-1 text-sm text-gray-900">{{ $jobApplication->name ?? 'N/A' }}</dd>
                </div>
                <div>
                    <dt class="text-sm font-medium text-gray-600">Email</dt>
                    <dd class="mt-1 text-sm text-gray-900">
                        <a href="mailto:{{ $jobApplication->email }}" 
                           class="text-cyan-600 hover:underline" 
                           aria-label="Email {{ $jobApplication->name ?? 'applicant' }}">
                            {{ $jobApplication->email ?? 'N/A' }}
                        </a>
                    </dd>
                </div>
                <div>
                    <dt class="text-sm font-medium text-gray-600">Resume</dt>
                    <dd class="mt-1 text-sm">
                        @if ($jobApplication->resume_path && Storage::disk('public')->exists($jobApplication->resume_path))
                            <a href="{{ asset('storage/' . $jobApplication->resume_path) }}" 
                               target="_blank" 
                               class="text-cyan-600 hover:underline flex items-center gap-1"
                               aria-label="View resume for {{ $jobApplication->name ?? 'applicant' }}">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                          d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                </svg>
                                View Resume
                            </a>
                        @else
                            <span class="text-gray-500">No resume uploaded</span>
                        @endif
                    </dd>
                </div>
                <div>
                    <dt class="text-sm font-medium text-gray-600">GitHub</dt>
                    <dd class="mt-1 text-sm">
                        @if ($jobApplication->github)
                            <a href="{{ $jobApplication->github }}" 
                               target="_blank" 
                               class="text-cyan-600 hover:underline truncate block"
                               aria-label="View GitHub profile for {{ $jobApplication->name ?? 'applicant' }}">
                                {{ $jobApplication->github}}
                            </a>
                        @else
                            <span class="text-gray-500">Not provided</span>
                        @endif
                    </dd>
                </div>
                <div>
                    <dt class="text-sm font-medium text-gray-600">LinkedIn</dt>
                    <dd class="mt-1 text-sm">
                        @if ($jobApplication->linkedin)
                            <a href="{{ $jobApplication->linkedin }}" 
                               target="_blank" 
                               class="text-cyan-600 hover:underline truncate block"
                               aria-label="View LinkedIn profile for {{ $jobApplication->name ?? 'applicant' }}">
                                {{ $jobApplication->linkedin }}
                            </a>
                        @else
                            <span class="text-gray-500">Not provided</span>
                        @endif
                    </dd>
                </div>
                <div>
                    <dt class="text-sm font-medium text-gray-600">Referred By</dt>
                    <dd class="mt-1 text-sm text-gray-900">
                        {{ $jobApplication->referrer->name ?? 'Direct' }}
                    </dd>
                </div>
                <div>
                    <dt class="text-sm font-medium text-gray-600">Application Type</dt>
                    <dd class="mt-1 text-sm text-gray-900">
                        {{ ucfirst($jobApplication->application_type ?? 'employee') }}
                    </dd>
                </div>
            </dl>
        </section>

        <!-- Job Questions -->
        @if ($jobApplication->answers && is_array($jobApplication->answers))
            <section>
                <h2 class="text-lg sm:text-xl font-semibold text-gray-800 mb-4">Answers to Job Questions</h2>
                <div class="space-y-4">
                    @foreach ($jobApplication->answers as $questionId => $answer)
                        @php
                            $question = $jobApplication->listing->questions->firstWhere('id', $questionId);
                        @endphp
                        @if ($question)
                            <div class="border-l-4 border-cyan-500 pl-4">
                                <div class="flex items-center gap-2 mb-1">
                                    <span class="text-sm font-medium text-gray-900">
                                        {{ $question->question_text }}
                                    </span>
                                    <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-800">
                                        {{ ucfirst($question->input_type) }}{{ $question->is_required ? ' (Required)' : '' }}
                                    </span>
                                </div>
                                <div class="text-sm text-gray-700">
                                    @if (is_array($answer))
                                        @if (empty($answer))
                                            <span class="text-gray-500 italic">None selected</span>
                                        @else
                                            <ul class="list-disc pl-5 space-y-1">
                                                @foreach ($answer as $option)
                                                    <li>{{ $option }}</li>
                                                @endforeach
                                            </ul>
                                        @endif
                                    @else
                                        {{ $answer ?: 'N/A' }}
                                    @endif
                                </div>
                            </div>
                        @else
                            <div class="text-sm text-gray-500">Question ID {{ $questionId }} not found</div>
                        @endif
                    @endforeach
                </div>
            </section>
        @else
            <section>
                <h2 class="text-lg sm:text-xl font-semibold text-gray-800 mb-4">Answers to Job Questions</h2>
                <p class="text-sm text-gray-500">{{ $jobApplication->answers ? 'Invalid answers format' : 'No answers provided' }}</p>
            </section>
        @endif
    </div>

    <!-- Actions -->
    <footer class="mt-8 flex flex-col sm:flex-row gap-4">
        <a href="{{ route('dashboard.applicant-management') }}" 
           class="inline-flex items-center px-4 py-2 bg-gray-100 text-gray-800 text-sm font-medium rounded-md hover:bg-gray-200 transition-colors"
           aria-label="Return to applicant management">
            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
            </svg>
            Back to Applicants
        </a>
        @if ($jobApplication->resume_path && Storage::disk('public')->exists($jobApplication->resume_path))
            <a href="{{ asset('storage/' . $jobApplication->resume_path) }}" 
               download 
               class="inline-flex items-center px-4 py-2 bg-cyan-600 text-white text-sm font-medium rounded-md hover:bg-cyan-700 transition-colors"
               aria-label="Download resume for {{ $jobApplication->name ?? 'applicant' }}">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                          d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" />
                </svg>
                Download Resume
            </a>
        @endif
    </footer>
</div>
@endsection

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const updateStatusButtons = document.querySelectorAll('[wire\\:click="openStatusModal"]');
            updateStatusButtons.forEach(button => {
                button.addEventListener('click', () => {
                    console.log('Open status update modal');
                });
            });
        });
    </script>
@endpush