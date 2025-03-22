<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Dashboard - @yield('title')</title>
    @notifyCss
    @vite(['resources/css/app.css', 'resources/js/app.js']) <!-- Vite for CSS/JS assets -->
</head>
<body class="bg-gray-100 font-sans antialiased">
    <!-- Root container: Full height, flex layout for sidebar and main content -->
    <div class="min-h-screen flex">
        <!-- Sidebar Wrapper: Manages sidebar visibility and mobile toggle -->
        <div x-data="{ open: false }" class="relative z-50">
            <!-- Sidebar: Fixed position, responsive width, slides in/out on mobile -->
            <div class="fixed inset-y-0 left-0 w-40 md:w-64 bg-gray-900 text-white transform transition-transform duration-300 ease-in-out shadow-lg"
                 :class="{ '-translate-x-full': !open, 'translate-x-0': open }" 
                 @click.away="open = false">
                <!-- Sidebar Header: Branding or title area -->
                <div class="p-4 border-b border-gray-700">
                    <h2 class="text-2xl font-semibold tracking-tight">Dashboard</h2>
                </div>
                <!-- Sidebar Navigation: Menu items with hover/active states -->
                <nav class="mt-4 space-y-1">
                    <a href="/" 
                       class="block py-2.5 px-4 text-sm hover:bg-gray-700 {{ Route::is('dashboard.profile') ? 'bg-gray-700 font-medium' : '' }} transition-colors duration-150">
                       Back to home
                    </a>
                    <a href="{{ route('dashboard.index') }}" 
                       class="block py-2.5 px-4 text-sm hover:bg-gray-700 {{ Route::is('dashboard.index') ? 'bg-gray-700 font-medium' : '' }} transition-colors duration-150">
                       Dashboard
                    </a>
                    <a href="{{ route('dashboard.profile') }}" 
                       class="block py-2.5 px-4 text-sm hover:bg-gray-700 {{ Route::is('dashboard.profile') ? 'bg-gray-700 font-medium' : '' }} transition-colors duration-150">
                       Profile
                    </a>
                    @if (Auth::user()->hasRole('Admin'))
                        <a href="{{ route('dashboard.user-management') }}" 
                        class="block py-2.5 px-4 text-sm hover:bg-gray-700 {{ Route::is('dashboard.user-management') ? 'bg-gray-700 font-medium' : '' }} transition-colors duration-150">
                        User Management
                        </a>
                    @endif
                    @if (Auth::user()->hasRole('Admin') ||Auth::user()->hasRole('Employer'))
                        <a href="{{ route('dashboard.job-management') }}" 
                            class="block py-2.5 px-4 text-sm hover:bg-gray-700 {{ Route::is('dashboard.job-management') ? 'bg-gray-700 font-medium' : '' }} transition-colors duration-150">
                            Job Management
                        </a>
                        <a href="{{ route('dashboard.applicant-management') }}" 
                            class="block py-2.5 px-4 text-sm hover:bg-gray-700 {{ Route::is('dashboard.applicant-management') ? 'bg-gray-700 font-medium' : '' }} transition-colors duration-150">
                            Applicant Management
                        </a>
                    @endif
                </nav>
            </div>

            <!-- Mobile Overlay: Darkens background when sidebar is open on mobile -->
            <div x-show="open" class="fixed inset-0 bg-black opacity-50 md:hidden" @click="open = false"></div>
        </div>

        <!-- Main Content Wrapper: Takes remaining space, offsets sidebar width -->
        <div class="flex-1 flex flex-col md:ml-64"> <!-- md:ml-64 offsets sidebar width on desktop -->
            <!-- Header: Fixed top bar with title and mobile menu toggle -->
            <header class="bg-white shadow-md p-4 flex items-center justify-between sticky top-0 z-40">
                <!-- Header Title: Dynamic page title -->
                <h1 class="text-xl font-semibold text-gray-800">@yield('title')</h1>
                <!-- Hamburger Button: Toggles sidebar on mobile, hidden on desktop -->
                <button x-data="{ open: false }" @click="open = !open" class="md:hidden focus:outline-none text-gray-600 hover:text-gray-800">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16m-7 6h7"></path>
                    </svg>
                </button>
            </header>

            <!-- Main Content Area: Scrollable, padded, responsive -->
            <main class="flex-1 p-4 md:p-6 lg:p-8 overflow-y-auto bg-gray-50">
                <!-- Content Section: Where page-specific content is injected -->
                @yield('content')
            </main>
        </div>
    </div>
    
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    @stack('scripts')
    
</body>
</html>