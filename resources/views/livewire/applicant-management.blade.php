<div>
    <div class="mb-4">
        <input 
            type="text" 
            wire:model.live.debounce.300ms="search" 
            placeholder="Search by applicant name or listing title" 
            class="w-1/2 px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-cyan-600 focus:border-transparent"
        >
    </div>

    <!-- Table -->
    <div class="overflow-x-auto">
        <table class="w-full table-auto border-collapse">
            <thead>
                <tr class="bg-gray-100 text-gray-700 text-xs font-semibold uppercase tracking-wide border-b border-gray-200">
                    <th class="py-2 px-2 text-left">Job Title</th>
                    <th class="py-2 px-2 text-left">Applicant</th>
                    <th class="py-2 px-2 text-left">Github</th>
                    <th class="py-2 px-2 text-left">Linkedin</th>
                    <th class="py-2 px-2 text-left">Applied On</th>
                    <th class="py-2 px-2 text-left">Job</th>
                    <th class="py-2 px-2 text-left">Status</th>
                    <th class="py-2 px-2 text-left">Contact</th>
                    <th class="py-2 px-2 text-left">Resume</th>
                    <th class="py-2 px-2 text-left">Referred by:</th>
                </tr>
            </thead>
            <tbody class="text-gray-600">
                @forelse ($applicants as $applicant)
                    <tr class="hover:bg-gray-50 transition-colors duration-150 border-b border-gray-200">
                        <td class="py-2 px-2 whitespace-nowrap text-sm">{{ $applicant->listing->listing_title }}</td>
                        <td class="py-2 px-2 whitespace-nowrap text-sm">{{ $applicant->name }}</td>
                        <td class="py-2 px-2 text-sm">
                            @if ($applicant->github)
                                <div class="flex items-center gap-2">
                                    <a href="{{ $applicant->github }}" target="_blank" class="text-cyan-600 hover:text-cyan-800 hover:underline transition-colors duration-200 truncate max-w-[150px] md:max-w-[200px]">
                                        <span class="block md:hidden">{{ parse_url($applicant->github, PHP_URL_HOST) }}</span>
                                        <span class="hidden md:block">{{ Str::limit($applicant->github, 30) }}</span>
                                    </a>
                                    <x-icons.clipboard-document :data-url="$applicant->github" />
                                </div>
                            @else
                                <span class="text-gray-500">N/A</span>
                            @endif
                        </td>
                        <td class="py-2 px-2 text-sm">
                            @if ($applicant->linkedin)
                                <div class="flex items-center gap-2">
                                    <a href="{{ $applicant->linkedin }}" target="_blank" class="text-cyan-600 hover:text-cyan-800 hover:underline transition-colors duration-200 truncate max-w-[150px] md:max-w-[200px]">
                                        <span class="block md:hidden">{{ parse_url($applicant->linkedin, PHP_URL_HOST) }}</span>
                                        <span class="hidden md:block">{{ Str::limit($applicant->linkedin, 30) }}</span>
                                    </a>
                                    <x-icons.clipboard-document :data-url="$applicant->linkedin" />
                                </div>
                            @else
                                <span class="text-gray-500">N/A</span>
                            @endif
                        </td>
                        
                        <td class="py-2 px-2 whitespace-nowrap text-sm">
                            {{ $applicant->created_at ? $applicant->created_at->format('d M Y') : 'N/A' }}
                        </td>
                        <td class="py-2 px-2 whitespace-nowrap text-sm">
                            <a href="{{ route('dashboard.single-listing', $applicant->id) }}" 
                               class="text-cyan-600 hover:text-cyan-800 hover:underline transition-colors duration-200">
                                View
                            </a>
                        </td>
                        <td class="py-2 px-2 whitespace-nowrap text-sm">
                            <span class="inline-block px-2 py-1 text-xs font-semibold rounded-full {{ $applicant->status === 'active' ? 'bg-green-100 text-green-800' : 'bg-gray-100 text-gray-800' }}">
                                {{ ucfirst($applicant->status ?? 'active') }}
                            </span>
                        </td>
                        <td class="py-2 px-2 whitespace-nowrap text-sm">
                            <a wire:navigate href="#" 
                               class="email-link bg-gray-200 text-gray-700 px-2 py-1 rounded-md hover:bg-gray-300 hover:text-gray-900 transition-colors duration-200" 
                               data-email="{{ $applicant->email }}">
                                Email
                            </a>
                        </td>
                        <td class="py-2 px-2 whitespace-nowrap text-sm flex items-center gap-2">
                            <x-icons.document class="text-gray-500"/>
                            <a wire:navigate href="{{ asset('storage/' . $applicant->resume_path) }}" 
                               target="_blank" 
                               class="text-cyan-600 hover:text-cyan-800 hover:underline transition-colors duration-200">
                                View
                            </a>
                        </td>
                        <td class="py-2 px-2 whitespace-nowrap text-sm">
                            @if ($applicant->referrer)
                                {{ $applicant->referrer->name }}
                            @else
                                <span class="text-gray-700">Direct</span>
                            @endif

                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="py-2 px-2 text-center text-gray-500 text-sm">No applicants found.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- Pagination -->
    <div class="mt-4 flex items-center justify-center">
        {{ $applicants->links('vendor.livewire.tailwind') }}
    </div>
</div>

@push('scripts')
    <script>
        document.querySelectorAll('.email-link').forEach(link => {
            link.addEventListener('click', (e) => {
                e.preventDefault();
                const email = link.getAttribute('data-email');
                window.location.href = `mailto:${email}`;
            });
        });
    </script>
@endpush