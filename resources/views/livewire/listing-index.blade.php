<div>
    <div wire:init class="grid grid-cols-12 gap-4 max-w-7xl mx-auto mt-10 px-4">
    
        <!-- Sidebar Navigation -->
        <aside class="bg-slate-700 col-span-12 md:col-span-2 shadow-lg rounded-lg p-4 relative" x-data="{ showNav: false }" wire:ignore>
            <!-- Mobile Toggle -->
            <button class="absolute top-4 right-4 md:hidden text-slate-200" @click="showNav = !showNav" aria-label="Toggle Navigation">
                <svg x-show="!showNav" class="h-6 w-6" fill="none" viewBox="0 0 24 24">
                    <path stroke="#CBD5E0" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h16M4 18h16" />
                </svg>
                <svg x-show="showNav" class="h-6 w-6" fill="none" viewBox="0 0 24 24">
                    <path stroke="#CBD5E0" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" d="M6 6l12 12M6 18L18 6" />
                </svg>
            </button>

            <!-- Links -->
            <nav :class="{ 'hidden': !showNav && window.innerWidth < 768 }" class="space-y-4 mt-10 md:mt-0">
                @php
                    $links = [
                        ['label' => 'Home', 'href' => route('home')],
                        ['label' => 'Jobs', 'href' => route('home') . '#projects'],
                        ['label' => 'About', 'href' => route('home') . '#about'],
                        ['label' => 'Contact', 'href' => route('home') . '#contact'],
                    ];
                @endphp

                @foreach ($links as $link)
                    <a wire:navigate.prefetch href="{{ $link['href'] }}"
                    class="block bg-slate-600 text-white text-center py-3 rounded-md hover:bg-slate-500 transition">
                    {{ $link['label'] }}
                    </a>
                @endforeach

                @auth
                    <a href="{{ route('dashboard.index') }}"
                    class="block bg-slate-600 text-white text-center py-3 rounded-md hover:bg-slate-500 transition">
                        Dashboard
                    </a>
                @endauth

                <div class="pt-6 space-y-2">
                    @auth
                        <form id="logout-form" action="{{ route('logout') }}" method="POST" class="hidden">@csrf</form>
                        <a href="{{ route('logout') }}"
                        class="block bg-gray-300 text-gray-900 text-center py-2 rounded-md hover:bg-gray-400 transition"
                        onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                            Logout
                        </a>
                    @else
                        <a wire:navigate href="{{ route('login') }}"
                        class="block bg-gray-300 text-gray-900 text-center py-2 rounded-md hover:bg-gray-400 transition">
                            Login
                        </a>
                        <a wire:navigate href="{{ route('register') }}"
                        class="block bg-gray-300 text-gray-900 text-center py-2 rounded-md hover:bg-gray-400 transition">
                            Register
                        </a>
                    @endauth
                </div>
            </nav>
        </aside>

        <!-- Hero Section -->
        <section class="col-span-12 md:col-span-7 relative shadow-lg rounded-lg overflow-hidden">
            <img src="{{ asset('images/web3v5.webp') }}" alt="Web3 Background" class="w-full h-full object-cover">
            <div class="absolute inset-0 bg-gradient-to-b from-transparent to-slate-900/90 flex flex-col justify-center text-center px-4">
                <h1 class="text-cyan-300 text-2xl md:text-4xl font-bold mb-4">Web3Defi</h1>
                <p class="text-gray-200 text-sm md:text-lg max-w-2xl mx-auto leading-relaxed">
                    Discover opportunities in Web3, DeFi, and beyond. Connect with innovative projects and top talent in the decentralized world.
                </p>
            </div>
        </section>

        <!-- Tabs Section -->
        <aside class="col-span-12 md:col-span-3 shadow-lg rounded-lg bg-slate-700 text-white" x-data="{ tab: 'tab1' }" wire:ignore>
            <div class="flex justify-between md:justify-around bg-slate-600 px-4 py-2 rounded-t-md">
                <button @click="tab = 'tab1'" :class="{ 'text-cyan-300 font-semibold': tab === 'tab1' }">Web3 Jobs</button>
                <button @click="tab = 'tab2'" :class="{ 'text-cyan-300 font-semibold': tab === 'tab2' }">Trending</button>
                <button @click="tab = 'tab3'" :class="{ 'text-cyan-300 font-semibold': tab === 'tab3' }">Skills</button>
            </div>
            <div class="p-4">
                <template x-if="tab === 'tab1'">
                    <p>Explore the latest Web3 job opportunities.</p>
                </template>
                <template x-if="tab === 'tab2'">
                    <p>Discover trending jobs in the industry.</p>
                </template>
                <template x-if="tab === 'tab3'">
                    <p>Learn about in-demand skills for the future of work.</p>
                </template>
            </div>
        </aside>
    
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
    <section class="bg-slate-800 text-white py-8 rounded-t-2xl">
        <div class="container mx-auto px-4 grid grid-cols-1 md:grid-cols-3 gap-8">
            
            <!-- Brand + Message -->
            <div>
                <h3 class="text-cyan-300 text-2xl font-bold mb-2">Web3Defi</h3>
                <p class="text-gray-300 text-sm leading-relaxed">
                    We operate fully remote. Should you have any concerns or compliments, feel free to reach out via our email. Thanks!
                </p>
            </div>

            <!-- Quick Links -->
            <div>
                <h3 class="text-gray-200 text-lg font-semibold mb-3">Quick Links</h3>
                <ul class="space-y-2 text-sm">
                    <li>
                        <a href="#" class="hover:text-cyan-400 transition">Jobs</a>
                    </li>
                    <li>
                        <a href="#" class="hover:text-cyan-400 transition">About</a>
                    </li>
                    <li>
                        <a href="#" class="hover:text-cyan-400 transition">Contact</a>
                    </li>
                </ul>
            </div>

            <!-- Newsletter -->
            <div>
                <h3 class="text-gray-200 text-lg font-semibold mb-3">Subscribe to Our Weekly Newsletter</h3>
                <form class="flex flex-col sm:flex-row items-center gap-2">
                    <input
                        type="email"
                        placeholder="Your email"
                        class="w-full px-4 py-2 text-sm text-gray-900 rounded-lg focus:ring-2 focus:ring-cyan-500 focus:outline-none"
                        required
                    >
                    <button
                        type="submit"
                        class="px-4 py-2 text-sm font-medium bg-cyan-600 text-white rounded-lg hover:bg-cyan-700 transition"
                    >
                        Subscribe
                    </button>
                </form>
            </div>
        </div>
        
        <!-- Bottom Note -->
        <div class=" flex items-center justify-center text-center space-x-4 text-gray-500 text-xs mt-6">
            <div class="flex items-center justify-start"><p>Built with ❤️by Brian Karanja.</p></div>
            <div class="flex items-center justify-end">
                &copy; {{ date('Y') }} Web3Defi. All rights reserved.
            </div>
        </div>
    </section>

</div>