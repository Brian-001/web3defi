<div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6 px-4 py-10">
    @foreach ($listings as $listing)
        <div class="bg-gradient-to-br from-slate-700 to-slate-800 p-6 rounded-xl shadow-lg hover:shadow-xl hover:shadow-cyan-500/20 transform hover:-translate-y-1 transition-all duration-300 max-h-96 overflow-hidden">
            <div class="flex flex-col gap-4">
                <!-- Logo (Hidden on Mobile) -->
                <div class="hidden md:flex items-center justify-center mb-4">
                    <img src="{{ asset('storage/' . $listing->listing_logo) }}" 
                         alt="{{ $listing->listing_title }} Logo" 
                         class="w-24 h-24 object-cover rounded-lg border border-slate-600">
                </div>

                <!-- Job Details -->
                <div class="flex flex-col gap-4">
                    <!-- Title -->
                    <h3 class="text-xl font-semibold text-white text-center tracking-tight">
                        {{ $listing->listing_title }}
                    </h3>

                    <!-- Description -->
                    <p class="text-gray-300 text-sm leading-relaxed line-clamp-2">
                        {{ Str::limit($listing->job_description, 100) }}
                    </p>

                    <!-- Tags -->
                    <div class="flex flex-wrap gap-2">
                        @php
                            $tags = is_string($listing->tags) ? explode(',', $listing->tags) : (array) $listing->tags;
                        @endphp
                        @foreach ($tags as $tag)
                            <span class="bg-cyan-100 text-cyan-800 text-xs font-medium px-2.5 py-1 rounded-full shadow-sm">
                                {{ trim($tag) }}
                            </span>
                        @endforeach
                    </div>

                    <!-- Location and Salary -->
                    <div class="flex justify-between items-center">
                        <div class="flex flex-col text-gray-300 text-sm">
                            <p><span class="font-medium text-gray-200">Location:</span> {{ $listing->location }}</p>
                            <p><span class="font-medium text-gray-200">Salary:</span> ${{ $listing->salary }}K</p>
                        </div>
                        <a href="{{ route('listings.show', $listing->id) }}" 
                           class="bg-cyan-400 text-gray-900 font-semibold px-4 py-2 rounded-lg hover:bg-cyan-300 transition-colors duration-200 shadow-md">
                            Learn More
                        </a>
                    </div>
                </div>
            </div>
        </div>
    @endforeach
</div>