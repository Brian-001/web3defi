<div>
    <!-- Search Bar -->
    <div class="mb-6">
        <input 
            type="text" 
            wire:model.live.debounce.300ms="search" 
            placeholder="Search by listing title or applicant name" 
            class="w-full sm:w-1/2 px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-cyan-600 focus:border-transparent text-sm"
        >
    </div>

    <!-- Listings List -->
    <div class="space-y-4">
        @forelse ($listings as $listing)
            <div class="bg-white rounded-lg shadow-md border border-gray-200">
                <!-- Listing Header -->
                <div class="flex items-center justify-between p-4 cursor-pointer hover:bg-gray-50 transition-colors duration-150"
                     wire:click="toggleListing({{ $listing->id }})">
                    <div class="flex items-center gap-3">
                        <span class="text-lg font-semibold text-gray-800 truncate max-w-[300px]">
                            {{ $listing->listing_title }}
                        </span>
                        <span class="bg-cyan-100 text-cyan-800 text-xs font-semibold px-2 py-1 rounded-full">
                            {{ $listing->applications_count }} {{ Str::plural('Application', $listing->applications_count) }}
                        </span>
                    </div>
                    <div class="flex items-center gap-2">
                        <span class="text-sm text-gray-500">
                            {{ $listing->listing_status === 'active' ? 'Active' : 'Closed' }}
                        </span>
                        <svg class="w-5 h-5 text-gray-600 transform transition-transform duration-200 {{ in_array($listing->id, $expandedListings) ? 'rotate-180' : '' }}"
                             fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                        </svg>
                    </div>
                </div>

                <!-- Applications (Collapsible) -->
                @if (in_array($listing->id, $expandedListings) && isset($applications[$listing->id]))
                    <div class="border-t border-gray-200">
                        <table class="w-full table-auto border-collapse">
                            <thead>
                                <tr class="bg-gray-100 text-gray-700 text-xs font-semibold uppercase tracking-wide">
                                    <th class="py-2 px-4 text-left">Applicant</th>
                                    <th class="py-2 px-4 text-left">Status</th>
                                    <th class="py-2 px-4 text-left">Applied On</th>
                                    <th class="py-2 px-4 text-left">Resume</th>
                                    <th class="py-2 px-4 text-left">Actions</th>
                                </tr>
                            </thead>
                            <tbody class="text-gray-600">
                                @foreach ($applications[$listing->id] as $applicant)
                                    <tr class="hover:bg-gray-50 transition-colors duration-150 border-b border-gray-200">
                                        <td class="py-2 px-4 text-sm">{{ $applicant->name }}</td>
                                        <td class="py-2 px-4 text-sm">
                                            <select wire:change="updateStatus({{ $applicant->id }}, $event.target.value)"
                                                    class="border border-gray-300 rounded-md text-sm p-1">
                                                <option value="submitted" {{ $applicant->application_status === 'submitted' ? 'selected' : '' }}>Submitted</option>
                                                <option value="under_review" {{ $applicant->application_status === 'under_review' ? 'selected' : '' }}>Under Review</option>
                                                <option value="shortlisted" {{ $applicant->application_status === 'shortlisted' ? 'selected' : '' }}>Shortlisted</option>
                                                <option value="interview_scheduled" {{ $applicant->application_status === 'interview_scheduled' ? 'selected' : '' }}>Interview Scheduled</option>
                                                <option value="rejected" {{ $applicant->application_status === 'rejected' ? 'selected' : '' }}>Rejected</option>
                                            </select>
                                        </td>
                                        <td class="py-2 px-4 text-sm">
                                            {{ $applicant->created_at ? $applicant->created_at->format('d M Y') : 'N/A' }}
                                        </td>
                                        <td class="py-2 px-4 text-sm">
                                            @if ($applicant->resume_path && Storage::disk('public')->exists($applicant->resume_path))
                                                <a href="{{ asset('storage/' . $applicant->resume_path) }}"
                                                   target="_blank"
                                                   class="text-cyan-600 hover:text-cyan-800 hover:underline">
                                                    View
                                                </a>
                                            @else
                                                <span class="text-gray-500">No resume</span>
                                            @endif
                                        </td>
                                        <td class="py-2 px-4 text-sm flex gap-2">
                                            <a href="{{ route('dashboard.single-application', $applicant->id) }}"
                                               class="text-cyan-600 hover:text-cyan-800 hover:underline">
                                                View Details
                                            </a>
                                            <a href="mailto:{{ $applicant->email }}"
                                               class="text-gray-600 hover:text-gray-800">
                                                Email
                                            </a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @endif
            </div>
        @empty
            <div class="text-center text-gray-500 text-sm py-6">
                No listings found.
            </div>
        @endforelse
    </div>

    <!-- Pagination -->
    <div class="mt-6 flex items-center justify-center">
        {{ $listings->links('vendor.livewire.tailwind') }}
    </div>
</div>

@push('scripts')
    <script>
        // Optional: Add smooth scroll or animations if needed
    </script>
@endpush