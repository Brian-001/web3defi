@extends('layouts.app-layouts')
@section('content')
<div class="grid grid-cols-12 gap-2 max-w-7xl mx-auto mt-10">
    <div class="bg-slate-700 col-span-12 md:col-span-2 row-span-6 shadow-lg relative" x-data="{ showNav: false }">
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
                <a href="#" class="text-white hover:text-cyan-300">Home</a>
            </div>
            <div class="mb-4 bg-slate-600 py-4 hover:drop-shadow-md nav-link">
                <a href="#" class="text-white hover:text-cyan-300">Jobs</a>
            </div>
            <div class="mb-4 bg-slate-600 py-4 hover:drop-shadow-md nav-link">
                <a href="#" class="text-white hover:text-cyan-300">About</a>
            </div>
            <div class="mb-4 bg-slate-600 py-4 hover:drop-shadow-md nav-link">
                <a href="#" class="text-white hover:text-cyan-300">Contact</a>
            </div>
            @if (Auth::check())
            <div class="mb-4 bg-slate-600 py-4 hover:drop-shadow-md nav-link">
                <a href="{{route('dashboard.index')}}" class="text-white hover:text-cyan-300">Dashboard</a>
            </div>
            @endif
            <div class="mt-8">
                @if (Auth::check())
                    <a href="{{route('logout')}}" 
                    class="text-gray-800 bg-gray-300  hover:text-white px-3 py-2 rounded-md text-sm font-medium"
                    onclick="event.preventDefault(); document.getElementById('logout-form').submit();">Logout</a>

                    <form id="logout-form" action = "{{route('logout')}}" method="POST" class="d-none">
                        @csrf
                    </form>
                @else
                    <a href="{{route('login')}}" class="text-gray-800 bg-gray-300  hover:text-white px-3 py-2 rounded-md text-sm font-medium">Login</a>
                    <a href="{{route('register')}}" class="text-gray-800 bg-gray-300 hover:text-white px-3 py-2 rounded-md text-sm font-medium">Register</a>
                @endif
            </div>
        </nav>
    </div>

    <div class="col-span-12 md:col-span-7 row-span-6 shadow-lg rounded-md relative">
        <div class="relative">
            <img src="{{asset('images/web3v5.webp')}}" class="w-full h-full object-cover rounded-md" alt="Photo">
        </div>
        <div class="absolute inset-0 bg-gradient-to-b from-transparent to-slate-900/90 flex flex-col justify-center">
            <h1 class="text-2xl md:text-3xl text-cyan-300 p-4 text-center font-bold">Web3Defi</h1>
            <p class="text-gray-200 text-sm md:text-base lg:text-xl leading-relaxed text-center mt-2 max-w-2xl mx-auto">
                Discover opportunities in Web3, DeFi, and beyond. Connect with 
                innovative projects and top talent in the decentralized world
            </p>
        </div>
    </div>

    <!-- Tab Layout for Cards -->
    <div class="col-span-12 md:col-span-3 row-span-6 shadow-lg rounded-md relative" x-data="{ tab: 'tab1' }">
        <div class="flex justify-around p-4 bg-slate-600 text-white">
            <button @click="tab = 'tab1'" :class="{ 'text-cyan-300': tab === 'tab1' }">Tab 1</button>
            <button @click="tab = 'tab2'" :class="{ 'text-cyan-300': tab === 'tab2' }">Tab 2</button>
            <button @click="tab = 'tab3'" :class="{ 'text-cyan-300': tab === 'tab3' }">Tab 3</button>
        </div>
        <div x-show="tab === 'tab1'" class="p-4">
            <!-- Content for Tab 1 -->
            <p class="text-white">Web3 Jobs</p>
            
            
        </div>
        <div x-show="tab === 'tab2'" class="p-4">
            <!-- Content for Tab 2 -->
            <p class="text-white">Trending Jobs</p>
            
        </div>
        <div x-show="tab === 'tab3'" class="p-4">
            <!-- Content for Tab 3 -->
            <p class="text-white">Trending skills Set</p>
        </div>
    </div>
</div>


{{-- Body --}}
<div class="col-span-12 mt-10 md:mt-20">
    <!-- Search Bar -->
    <div class="flex justify-center mx-4">
        <input type="text" 
               placeholder="Search jobs..." 
               class="search-bar w-full max-w-lg px-4 py-3 bg-slate-800 text-gray-200 rounded-[30px] border border-slate-600 focus:ring-2 focus:ring-cyan-400 focus:border-transparent outline-none transition-all placeholder-gray-400">
    </div>

    <section id="projects">
        <h2 class="text-3xl text-center text-cyan-300 mt-10 mb-6">Jobs</h2>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 p-4">
         <!-- Card 1 -->
            @foreach ($listings as $listing )
                <div class="bg-slate-600 hover:bg-slate-700 p-4 rounded-lg hover:shadow-md hover:shadow-cyan-400 max-h-96">
                    <div class="flex items-end justify-end">
                        <p class="text-sm text-gray-300 opacity-50">{{ $listing->created_at_formatted }}</p>
                    </div>
                    <div class="hidden md:flex items-center justify-center mr-4">   
                        <img 
                            src="{{$listing->listing_logo ? asset('storage/' . $listing->listing_logo) : asset('images/default_logo.jpg') }}" 
                            alt="Listing Logo" 
                            class="w-16 h-16 rounded-full bg-cover object-cover">
                    </div>
                    <div class="flex items-center">
                        <div>
                            <h2 class="text-lg font-semibold text-cyan-300">{{$listing->listing_title}}</h2>
                            <p class="text-sm text-pretty overflow-hidden whitespace-nowrap text-ellipsis text-gray-100">{{Str::limit($listing->job_description, 100)}}.</p>
                            <div class="flex mt-2 space-x-2 overflow-hidden">
                                @php
                                    // Decode the JSON string into an array of tag IDs
                                    $tagIds = json_decode($listing->tags, true) ?? [];
                                    // Fetch the tags from the database
                                    $tags = App\Models\Tag::whereIn('id', $tagIds)->pluck('tag_name')->toArray();
                                    // Limit the number of tags to 3 for medium screens and above
                                    $limitedTags = array_slice($tags, 0, 3);
                                    // Limit the number of tags to 1 for small screens
                                    $limitedTagsSm = array_slice($tags, 0, 1);
                                    // Calculate the number of remaining tags
                                    $remainingTagsCount = count($tags) - count($limitedTagsSm); // For small screens
                                    $remainingTagsCountMd = count($tags) - count($limitedTags); // For medium screens and above
                                @endphp
                            
                                <!-- Show 1 tag and "+X more" on small screens -->
                                <div class="sm:hidden flex space-x-2">
                                    @foreach ($limitedTagsSm as $tag)
                                        <div class="bg-white text-slate-700 text-sm px-2 py-0.5 rounded-full">{{ $tag }}</div>
                                    @endforeach
                            
                                    <!-- Show "+X more" if there are more than 1 tag -->
                                    @if ($remainingTagsCount > 0)
                                        <div class="bg-white text-slate-700 text-sm px-2 py-0.5 rounded-full">+{{ $remainingTagsCount }} more</div>
                                    @endif
                                </div>
                            
                                <!-- Show 3 tags and "+X more" on medium screens and above -->
                                <div class="hidden sm:flex space-x-2">
                                    @foreach ($limitedTags as $tag)
                                        <div class="bg-white text-slate-700 text-sm px-2 py-0.5 rounded-full">{{ $tag }}</div>
                                    @endforeach
                            
                                    <!-- Show "+X more" if there are more than 3 tags -->
                                    @if ($remainingTagsCountMd > 0)
                                        <div class="bg-white text-slate-700 text-sm px-2 py-0.5 rounded-full">+{{ $remainingTagsCountMd }} more</div>
                                    @endif
                                </div>
                            </div>
                            <div class="flex mt-2 space-x-4">
                                <div>
                                    <h2 class="text-cyan-300">Estimated Salary</h2>
                                    <p class="text-sm text-white"><span class="font-semibold text-white">$ </span>{{$listing->salary}} <span class="font-semibold text-white"> K</p>
                                </div>
                                <div>
                                    <h2 class="text-cyan-300">Location</h2>
                                    <p class="text-sm text-white">{{$listing->location}}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="flex justify-end mt-4">
                        <a href="{{ route('listings.show', $listing->id)}}" class="bg-white text-slate-700 px-2 py-1.5 rounded-md">Learn more</a>
                    </div>
                </div>
            @endforeach
        </div>
    </section>    
@endsection
    
        