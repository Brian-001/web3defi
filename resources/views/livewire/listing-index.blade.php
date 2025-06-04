<div>
    <div wire:init class="grid grid-cols-12 gap-2 max-w-7xl mx-auto mt-10">
        <!-- Navigation Sidebar -->
        <div class="bg-slate-700 col-span-12 md:col-span-2 row-span-6 shadow-lg relative" x-data="{ showNav: false }" wire:ignore>
            <div class="absolute top-0 right-4 cursor-pointer md:hidden" @click="showNav = !showNav">
                <svg x-show="!showNav" class="h-6 w-6 transition-transform duration-700" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M4 6H20M4 12H20M4 18H20" stroke="#CBD5E0" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                </svg>
                <svg x-show="showNav" class="h-6 w-6 transition-transform duration-700" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M6 6L18 18M6 18L18 6" stroke="#CBD5E0" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                </svg>
            </div>
            <nav class="grid p-4 text-center md:block" :class="{ 'hidden': !showNav && window.innerWidth < 768 }">
                <div class="mb-4 mt-4 bg-slate-600 py-4 hover:drop-shadow-md cursor-pointer nav-link">
                    <a wire:navigate href="{{ route('home') }}" class="text-white hover:text-cyan-300">Home</a>
                </div>
                <div class="mb-4 bg-slate-600 py-4 hover:drop-shadow-md nav-link">
                    <a wire:navigate.prefetch href="{{ route('home') }}#projects" class="text-white hover:text-cyan-300">Jobs</a>
                </div>
                <div class="mb-4 bg-slate-600 py-4 hover:drop-shadow-md nav-link">
                    <a wire:navigate.prefetch href="{{ route('home') }}#about" class="text-white hover:text-cyan-300">About</a>
                </div>
                <div class="mb-4 bg-slate-600 py-4 hover:drop-shadow-md nav-link">
                    <a wire:navigate.prefetch href="{{ route('home') }}#contact" class="text-white hover:text-cyan-300">Contact</a>
                </div>
                @if (Auth::check())
                    <div class="mb-4 bg-slate-600 py-4 hover:drop-shadow-md nav-link">
                        <a href="{{ route('dashboard.index') }}" class="text-white hover:text-cyan-300">Dashboard</a>
                    </div>
                @endif
                <div class="mt-8">
                    @if (Auth::check())
                        <a wire:navigate href="{{ route('logout') }}" 
                           class="text-gray-800 bg-gray-300 hover:text-white px-3 py-2 rounded-md text-sm font-medium"
                           onclick="event.preventDefault(); document.getElementById('logout-form').submit();">Logout</a>
                        <form id="logout-form" action="{{ route('logout') }}" method="POST" class="hidden">
                            @csrf
                        </form>
                    @else
                        <a wire:navigate.prefetch href="{{ route('login') }}" class="text-gray-800 bg-gray-300 hover:text-white px-3 py-2 rounded-md text-sm font-medium">Login</a>
                        <a wire:navigate.prefetch href="{{ route('register') }}" class="text-gray-800 bg-gray-300 hover:text-white px-3 py-2 rounded-md text-sm font-medium">Register</a>
                    @endif
                </div>
            </nav>
        </div>
    
        <!-- Hero Section -->
        <div class="col-span-12 md:col-span-7 row-span-6 shadow-lg rounded-md relative">
            <div class="relative">
                <img src="{{ asset('images/web3v5.webp') }}" class="w-full h-full object-cover rounded-md" alt="Photo">
            </div>
            <div class="absolute inset-0 bg-gradient-to-b from-transparent to-slate-900/90 flex flex-col justify-center">
                <h1 class="text-2xl md:text-3xl text-cyan-300 p-4 text-center font-bold">Web3Defi</h1>
                <p class="text-gray-200 text-sm md:text-base lg:text-xl leading-relaxed text-center mt-2 max-w-2xl mx-auto">
                    Discover opportunities in Web3, DeFi, and beyond. Connect with 
                    innovative projects and top talent in the decentralized world
                </p>
            </div>
        </div>
    
        <!-- Tabs Section -->
        <div class="col-span-12 md:col-span-3 row-span-6 shadow-lg rounded-md relative" x-data="{ tab: 'tab1' }" wire:ignore>
            <div class="flex justify-around p-4 bg-slate-600 text-white">
                <button @click="tab = 'tab1'" :class="{ 'text-cyan-300': tab === 'tab1' }">Web3 Jobs</button>
                <button @click="tab = 'tab2'" :class="{ 'text-cyan-300': tab === 'tab2' }">Trending Jobs</button>
                <button @click="tab = 'tab3'" :class="{ 'text-cyan-300': tab === 'tab3' }">Skills</button>
            </div>
            <div x-show="tab === 'tab1'" class="p-4">
                <p class="text-white">Explore the latest Web3 job opportunities.</p>
            </div>
            <div x-show="tab === 'tab2'" class="p-4">
                <p class="text-white">Discover trending jobs in the industry.</p>
            </div>
            <div x-show="tab === 'tab3'" class="p-4">
                <p class="text-white">Learn about in-demand skills.</p>
            </div>
        </div>
    
        <!-- Listings Section -->
        <div class="col-span-12 mt-10 md:mt-20">
            <!-- Search -->
            <div class="flex flex-col sm:flex-row justify-center items-center mx-4 space-y-4 sm:space-y-0 sm:space-x-4">
                <!-- Search Bar -->
                <input type="text" 
                       wire:model.live.debounce.300ms="search"
                       placeholder="Search jobs by title, type, or location..." 
                       class="search-bar w-full max-w-lg px-4 py-3 bg-slate-800 text-gray-200 rounded-[30px] border border-slate-600 focus:ring-2 focus:ring-cyan-400 focus:border-transparent outline-none transition-all placeholder-gray-400">
            </div>
    
            <section id="projects">
                <h2 class="text-3xl text-center text-cyan-300 mt-10 mb-6">Jobs</h2>
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 p-4">
                    @forelse ($listings as $listing)
                        <div wire:key="listing-{{ $listing->id }}" class="bg-slate-600 hover:bg-slate-700 p-4 rounded-lg hover:shadow-md hover:shadow-cyan-400 max-h-96">
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
                                        {{ \Illuminate\Support\Str::limit($listing->job_description, 100) }}.
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
                                <a wire:navigate href="{{ route('listings.show', $listing->id) }}" class="bg-white text-slate-700 px-2 py-1.5 rounded-md">Learn more</a>
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
                {{ $listings->links('vendor.livewire.tailwind') }}
            </div>
        </div>
    </div>
    {{-- About Section --}}
    <section id="about" class="mt-12 md:mt-24 mb-12 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-10">
            <h2 class="text-3xl md:text-4xl text-cyan-300 font-bold tracking-tight">About Us</h2>
        </div>
        
        <div class="grid grid-cols-1 gap-6">
            <div class="bg-slate-700 p-6">
                {{-- <h3 class="text-xl text-cyan-300 font-semibold mb-4">Responsible AI Principles</h3> --}}
                <p class="text-gray-300 text-base leading-relaxed">
                    We believe in the power of responsible AI to transform organizations. By adhering to ethical AI principles, such as those pioneered by industry leaders like Google, we ensure that every decision—from project inception to deployment—prioritizes fairness, transparency, and accountability. Our approach integrates responsible AI practices to align with your business values and societal impact.
                </p>
            </div>
            <div class="bg-slate-700 p-6">
                {{-- <h3 class="text-xl text-cyan-300 font-semibold mb-4">Tailored AI Solutions</h3> --}}
                <p class="text-gray-300 text-base leading-relaxed">
                    Organizations can design AI to meet their unique needs while upholding ethical standards. We help you identify the need for responsible AI practices and guide you in crafting solutions that reflect your business goals and values. Our expertise ensures that AI not only drives innovation but also fosters trust and reliability across all project stages.
                </p>
            </div>
        </div>
    </section>

        {{-- Contact Section  --}}
    <section id="contact" class="mt-12 md:mt-24 mb-12 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <h2 class="text-3xl md:text-4xl text-center text-cyan-300 mb-8 font-bold tracking-tight">Contact</h2>
        
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <!-- Socials -->
            <div class="p-4 rounded-lg">

                <div class="flex justify-center mx-auto bg-slate-700 h-max w-1/2 rounded shadow-md py-10">
                    <div class="flex flex-col space-y-4">
                        <h3 class="text-cyan-300 font-semibold text-lg space-y-2">Our Socials</h3>
                        <a href="https://www.linkedin.com/company/web3defi/" target="_blank" class="text-white text-base transition-colors duration-200 ease-in-out">LinkedIn</a>
                        <a href="https://twitter.com/web3defi" target="_blank" class="text-white text-base transition-colors duration-200 ease-in-out">Twitter (X)</a>
                        <a href="mailto:contact@karanjabrian.com" class="text-white text-base transition-colors duration-200 ease-in-out">Email</a>
                    </div>
                </div>
                
            </div>
            
            <!-- Contact Form -->
            <div class="bg-slate-700 p-6 rounded-lg shadow-md shadow-cyan-500/30">
                <h3 class="text-cyan-300 font-semibold text-lg mb-2">Get In Touch</h3>
                <p class="text-cyan-300 text-sm mb-4"><span class="underline">And We</span> Will Respond Promptly</p>
                
                <form action="#" method="POST">
                    @csrf
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                        <div>
                            <label for="firstname" class="text-gray-300 block text-sm mb-1">First Name</label>
                            <input type="text" id="firstname" name="firstname" class="w-full text-white bg-slate-800 rounded-md p-2.5 text-sm border border-slate-600 focus:outline-none focus:ring-2 focus:ring-cyan-400 transition-colors duration-200" required autocomplete="new-password" autocorrect="off" spellcheck="false">
                        </div>
                        <div>
                            <label for="lastname" class="text-gray-300 block text-sm mb-1">Last Name</label>
                            <input type="text" id="lastname" name="lastname" class="w-full text-white bg-slate-800 rounded-md p-2.5 text-sm border border-slate-600 focus:outline-none focus:ring-2 focus:ring-cyan-400 transition-colors duration-200" required autocomplete="new-password" autocorrect="off" spellcheck="false">
                        </div>
                    </div>
                    <div class="grid grid-cols-1 gap-4 mb-4">
                        <div>
                            <label for="email" class="text-gray-300 block text-sm mb-1">Email</label>
                            <input type="email" id="email" name="email" class="w-full text-white bg-slate-800 rounded-md p-2.5 text-sm border border-slate-600 focus:outline-none focus:ring-2 focus:ring-cyan-400 transition-colors duration-200" required autocomplete="new-password" autocorrect="off" spellcheck="false" required>
                        </div>
                        <div>
                            <label for="message" class="text-gray-300 block text-sm mb-1">Message</label>
                            <textarea id="message" name="message" rows="4" class="w-full text-white bg-slate-800 rounded-md p-2.5 text-sm border border-slate-600 resize-none focus:outline-none focus:ring-2 focus:ring-cyan-400 transition-colors duration-200" autocomplete="off" required></textarea>
                        </div>
                    </div>
                    <div class="flex justify-center">
                        <button type="submit" class="w-1/2 bg-cyan-400 py-2.5 rounded-md text-white text-sm font-semibold hover:bg-cyan-500 transition-colors duration-200 ease-in-out">Send Message</button>
                    </div>
                </form>
            </div>
        </div>
    </section>

    {{-- Footer Section --}}
    <section>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4 h-max bg-slate-800 rounded-t-lg md:rounded-t-2xl py-4">
            <div class="p-4">
                <h3 class="text-cyan-300 text-xl font-semibold">Web3Defi</h3>
                <p class="text-white">We operate fully remote, should there be any concern, complement feel free to reach out to us via our email address. Thanks!</p>
                
            </div>
            <div class="p-4">
                <h3 class="text-gray-300 font-semibold">Quicklinks</h3>
                <ul class="text-white">
                    <li>Jobs</li>
                    <li>About</li>
                    <li>Contact</li>
                </ul>
            </div>
            <div class="p-4">
                <h3 class="text-gray-300 font-semibold">Socials</h3>
            </div>
        </div>
    </section>
</div>