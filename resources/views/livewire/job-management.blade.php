<div>
    <div class="mb-4">
        <input 
            type="text" 
            wire:model.live.debounce.300ms="search" 
            placeholder="Search by title, job type, status, or user" 
            class="w-1/2 px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-cyan-600 focus:border-transparent"
        >
    </div>

    <!-- Table -->
    <div class="overflow-x-auto">
        <table class="w-full table-auto border-collapse">
            <thead>
                <tr class="bg-gray-100 text-gray-700 text-xs font-semibold uppercase tracking-wide border-b border-gray-200">
                    <th class="py-2 px-2 text-left">Title</th>
                    <th class="py-2 px-2 text-left">Posted By</th>
                    <th class="py-2 px-2 text-left">Type</th>
                    <th class="py-2 px-2 text-left">Posted Date</th>
                    <th class="py-2 px-2 text-left">Status</th>
                    <th class="py-2 px-2 text-left">Actions</th>
                </tr>
            </thead>
            <tbody class="text-gray-600">
                @forelse ($listings as $listing)
                    <tr class="hover:bg-gray-50 transition-colors duration-150 border-b border-gray-200">
                        <td class="py-2 px-2 whitespace-nowrap text-sm">{{ $listing->listing_title }}</td>
                        <td class="py-2 px-2 whitespace-nowrap text-sm">{{ $listing->user->name }}</td>
                        <td class="py-2 px-2 whitespace-nowrap text-sm capitalize">{{ $listing->job_type }}</td>
                        <td class="py-2 px-2 whitespace-nowrap text-sm">{{ $listing->created_at->format('d M Y H:i') }}</td>
                        <td class="py-2 px-2 whitespace-nowrap">
                            <select
                                wire:model="selectedStatus.{{ $listing->id }}"
                                wire:change="updateStatus({{ $listing->id }})"
                                class="bg-transparent text-gray-700 text-sm py-0 px-6 rounded-lg hover:text-cyan-600"
                            >
                                @foreach ($statuses as $status)
                                    <option value="{{ $status }}" {{ $listing->listing_status === $status ? 'selected' : '' }}>
                                        {{ ucfirst($status) }}
                                    </option>
                                @endforeach
                            </select>
                        </td>
                        <td class="py-2 px-2 whitespace-nowrap flex gap-2">
                            <a href="{{ route('listings.edit', $listing->id) }}" 
                               class="bg-emerald-500 text-white text-sm font-medium py-1 px-2 rounded-md hover:bg-emerald-600 transition-colors duration-200">
                                Edit
                            </a>
                            <form action="{{ route('listings.destroy', $listing->id) }}" method="POST" class="inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" 
                                        class="bg-red-500 text-white text-sm font-medium py-1 px-2 rounded-md hover:bg-red-600 transition-colors duration-200" 
                                        onclick="return confirm('Are you sure you want to delete this job?')">
                                    Delete
                                </button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="py-2 px-2 text-center text-gray-500 text-sm">No jobs found.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- Pagination -->
    <div class="mt-4 flex items-center justify-center">
        {{ $listings->links() }}
    </div>
</div>