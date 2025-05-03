@extends('layouts.app-layouts')

@section('content')
<div class="grid grid-cols-12 gap-2 max-w-7xl mx-auto mt-10">
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
                <a href="/" class="text-white hover:text-cyan-300">Home</a>
            </div>
            <div class="mb-4 bg-slate-600 py-4 hover:drop-shadow-md nav-link">
                <a wire:navigate href="#projects" class="text-white hover:text-cyan-300">Jobs</a>
            </div>
            <div class="mb-4 bg-slate-600 py-4 hover:drop-shadow-md nav-link">
                <a href="#" class="text-white hover:text-cyan-300">About</a>
            </div>
            <div class="mb-4 bg-slate-600 py-4 hover:drop-shadow-md nav-link">
                <a href="#" class="text-white hover:text-cyan-300">Contact</a>
            </div>
            @if (Auth::check())
                <div class="mb-4 bg-slate-600 py-4 hover:drop-shadow-md nav-link">
                    <a href="{{ route('dashboard.index') }}" class="text-white hover:text-cyan-300">Dashboard</a>
                </div>
            @endif
            <div class="mt-8">
                @if (Auth::check())
                    <a href="{{ route('logout') }}" 
                       class="text-gray-800 bg-gray-300 hover:text-white px-3 py-2 rounded-md text-sm font-medium"
                       onclick="event.preventDefault(); document.getElementById('logout-form').submit();">Logout</a>
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="hidden">
                        @csrf
                    </form>
                @else
                    <a href="{{ route('login') }}" class="text-gray-800 bg-gray-300 hover:text-white px-3 py-2 rounded-md text-sm font-medium">Login</a>
                    <a href="{{ route('register') }}" class="text-gray-800 bg-gray-300 hover:text-white px-3 py-2 rounded-md text-sm font-medium">Register</a>
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

    <!-- Livewire Component -->
    @livewire('listing-index')
</div>
@endsection