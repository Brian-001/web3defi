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
                <a href="#" class="hover:text-cyan-300">Home</a>
            </div>
            <div class="mb-4 bg-slate-600 py-4 hover:drop-shadow-md nav-link">
                <a href="#" class="hover:text-cyan-300">Jobs</a>
            </div>
            <div class="mb-4 bg-slate-600 py-4 hover:drop-shadow-md nav-link">
                <a href="#" class="hover:text-cyan-300">About</a>
            </div>
            <div class="mb-4 bg-slate-600 py-4 hover:drop-shadow-md nav-link">
                <a href="#" class="hover:text-cyan-300">Contact</a>
            </div>
        </nav>
    </div>

    <div class="col-span-12 md:col-span-7 row-span-6 shadow-lg rounded-md relative">
        <div class="relative">
            <img src="{{asset('images/web3v5.webp')}}" class="w-full h-full object-cover rounded-md" alt="Photo">
        </div>
        <div class="absolute inset-0 bg-gradient-to-b from-transparent to-slate-900/90 flex flex-col justify-center">
            <h1 class="text-2xl md:text-3xl text-cyan-300 p-4 text-center font-bold">Web3Defi</h1>
            <p class="p-4 text-sm md:text-base tracking-wider">
                Lorem is simply dummy text of the printing and typesetting industry. 
                Lorem Ipsum has been the industry's standard dummy text ever 
                since the 1500s, when an unknown printer took a galley of type
                and scrambled it to make a type specimen book.
            </p>
        </div>
    </div>

    <!-- Tab Layout for Cards -->
    <div class="col-span-12 md:col-span-3 row-span-6 shadow-lg rounded-md relative" x-data="{ tab: 'tab1' }">
        <div class="flex justify-around p-4 bg-slate-600">
            <button @click="tab = 'tab1'" :class="{ 'text-cyan-300': tab === 'tab1' }">Tab 1</button>
            <button @click="tab = 'tab2'" :class="{ 'text-cyan-300': tab === 'tab2' }">Tab 2</button>
            <button @click="tab = 'tab3'" :class="{ 'text-cyan-300': tab === 'tab3' }">Tab 3</button>
        </div>
        <div x-show="tab === 'tab1'" class="p-4">
            <!-- Content for Tab 1 -->
            <p>Web3 Jobs</p>
            <a href="{{route('listings.create')}}">Create Listing</a>
        </div>
        <div x-show="tab === 'tab2'" class="p-4">
            <!-- Content for Tab 2 -->
            <p>Trending Jobs</p>
        </div>
        <div x-show="tab === 'tab3'" class="p-4">
            <!-- Content for Tab 3 -->
            <p>Trending skills Set</p>
        </div>
    </div>
</div>


{{-- Body --}}
<div class="col-span-12 mt-10">
    <div class="flex justify-center mb-4">
        <input type="text" placeholder="Search..." class="search-bar font-semibold tracking-wide md:w-1/2 p-2 rounded-lg border border-gray-300 focus:outline-none focus:ring-2 focus:ring-cyan-300 bg-slate-600">
    </div>
    <h2 class="text-3xl text-center text-cyan-300 mb-6">Jobs</h2>
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 p-4">
        <!-- Card 1 -->
        @foreach ($listings as $listing )
            <div class="bg-slate-600 hover:bg-slate-700 p-4 rounded-lg hover:shadow-md hover:shadow-cyan-400 max-h-96">
                <div class="flex items-center">
                    <div class="hidden md:flex items-center justify-center  mr-4">
                        <img src="{{asset('storage/' . $listing->listing_logo )}}" alt="Listing Logo" class="w-16 h-16 rounded-lg">
                    </div>
                    <div>
                        <h2 class="text-lg font-semibold text-center">{{$listing->listing_title}}</h2>
                        <p class="text-sm text-pretty overflow-hidden whitespace-nowrap text-ellipsis">{{Str::limit($listing->job_description, 100)}}.</p>
                        <div class="flex mt-2 space-x-2 overflow-hidden">
                            @foreach (explode(',', $listing->tags) as $tag )
                                <div class="bg-white text-slate-700 text-sm px-2 py-0.5 rounded-full">{{$tag}}</div>
                            @endforeach
                        </div>
                        <div class="flex mt-2 space-x-4">
                            <p class="text-sm ">Salary: {{$listing->salary}}</p>
                            <p class="text-sm">Location: {{$listing->location}}</p>
                        </div>
                    </div>
                </div>
                <div class="flex justify-end mt-4">
                    <button class="bg-cyan-300 text-slate-700 px-2 py-1.5 rounded-md">Learn more</button>
                </div>
            </div>
        @endforeach
        
@endsection
    
        
