<div class="col-span-12 mt-10 md:mt-20">
    <!-- Search Bar -->
    <div class="flex justify-center mx-4">
        <input type="text" 
               wire:model.live.debounce.300ms="search"
               placeholder="Search jobs by title, type, location, or tag..." 
               class="search-bar w-full max-w-lg px-4 py-3 bg-slate-800 text-gray-200 rounded-[30px] border border-slate-600 focus:ring-2 focus:ring-cyan-400 focus:border-transparent outline-none transition-all placeholder-gray-400">
    </div>

    <section id="projects">
        <h2 class="text-3xl text-center text-cyan-300 mt-10 mb-6">Jobs</h2>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 p-4">
            @forelse ($listings as $listing)
                <div class="bg-slate-600 hover:bg-slate-700 p-4 rounded-lg hover:shadow-md hover:shadow-cyan-400 max-h-96">
                    <div class="flex items-end justify-end">
                        <p class="text-sm text-gray-300 opacity-50">
                            {{ $listing->created_at ? $listing->created_at->format('d M Y') : 'N/A' }}
                        </p>
                    </div>
                    <div class="hidden md:flex items-center justify-center mr-4">   
                        <img 
                            src="{{ $listing->listing_logo ? asset('storage/' . $listing->listing_logo) : asset('images/default_logo.jpg') }}" 
                            alt="Listing Logo" 
                            class="w-16 h-16 rounded-full bg-cover object-cover">
                    </div>
                    <div class="flex items-center">
                        <div>
                            <h2 class="text-lg font-semibold text-cyan-300">{{ $listing->listing_title }}</h2>
                            <p class="text-sm text-pretty overflow-hidden whitespace-nowrap text-ellipsis text-gray-100">
                                {{ Str::limit($listing->job_description, 100) }}.
                            </p>
                            <div class="flex mt-2 space-x-2 overflow-hidden">
                                @php
                                    $tagIds = json_decode($listing->tags, true) ?? [];
                                    $tags = \App\Models\Tag::whereIn('id', $tagIds)->pluck('tag_name')->toArray();
                                    $limitedTags = array_slice($tags, 0, 3);
                                    $limitedTagsSm = array_slice($tags, 0, 1);
                                    $remainingTagsCount = count($tags) - count($limitedTagsSm);
                                    $remainingTagsCountMd = count($tags) - count($limitedTags);
                                @endphp

                                <!-- Show 1 tag and "+X more" on small screens -->
                                <div class="sm:hidden flex space-x-2">
                                    @foreach ($limitedTagsSm as $tag)
                                        <div class="bg-white text-slate-700 text-sm px-2 py-0.5 rounded-full">{{ $tag }}</div>
                                    @endforeach
                                    @if ($remainingTagsCount > 0)
                                        <div class="bg-white text-slate-700 text-sm px-2 py-0.5 rounded-full">+{{ $remainingTagsCount }} more</div>
                                    @endif
                                </div>

                                <!-- Show 3 tags and "+X more" on medium screens and above -->
                                <div class="hidden sm:flex space-x-2">
                                    @foreach ($limitedTags as $tag)
                                        <div class="bg-white text-slate-700 text-sm px-2 py-0.5 rounded-full">{{ $tag }}</div>
                                    @endforeach
                                    @if ($remainingTagsCountMd > 0)
                                        <div class="bg-white text-slate-700 text-sm px-2 py-0.5 rounded-full">+{{ $remainingTagsCountMd }} more</div>
                                    @endif
                                </div>
                            </div>
                            <div class="flex mt-2 space-x-4">
                                <div>
                                    <h2 class="text-cyan-300">Estimated Salary</h2>
                                    <p class="text-sm text-white"><span class="font-semibold text-white">$ </span>{{ $listing->salary }} <span class="font-semibold text-white"> K</span></p>
                                </div>
                                <div>
                                    <h2 class="text-cyan-300">Location</h2>
                                    <p class="text-sm text-white">{{ $listing->location }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="flex justify-end mt-4">
                        <a href="{{ route('listings.show', $listing->id) }}" class="bg-white text-slate-700 px-2 py-1.5 rounded-md">Learn more</a>
                    </div>
                </div>
            @empty
                <div class="col-span-full text-center text-gray-300">
                    No jobs found.
                </div>
            @endforelse
        </div>
    </section>

    <!-- Pagination -->
    <div class="mt-6 flex justify-center">
        {{ $listings->links() }}
    </div>
</div>