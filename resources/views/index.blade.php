<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Laravel</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,600&display=swap" rel="stylesheet" />

        <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
        <script src="https://cdn.jsdelivr.net/gh/alpinejs/alpine@v2.x.x/dist/alpine.min.js" defer></script>

        <!-- Styles -->
        @vite('resources/css/app.css')
    </head>
    <body class="font-sans antialiased dark:bg-slate-700 dark:text-white">
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
                <nav class="grid p-4 text-center" x-show="showNav">
                    <div class="mb-4 mt-4 bg-slate-600 py-4 hover:drop-shadow-md cursor-pointer nav-link" :class="{ 'show': showNav, 'hide': !showNav }">
                        <a href="#" class="hover:text-cyan-300">Home</a>
                    </div>
                    <div class="mb-4 bg-slate-600 py-4 hover:drop-shadow-md nav-link" :class="{ 'show': showNav, 'hide': !showNav }">
                        <a href="#" class="hover:text-cyan-300">Jobs</a>
                    </div>
                    <div class="mb-4 bg-slate-600 py-4 hover:drop-shadow-md nav-link" :class="{ 'show': showNav, 'hide': !showNav }">
                        <a href="#" class="hover:text-cyan-300">About</a>
                    </div>
                    <div class="mb-4 bg-slate-600 py-4 hover:drop-shadow-md nav-link" :class="{ 'show': showNav, 'hide': !showNav }">
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
        
            <div class="relative col-span-12 md:col-span-3 row-span-6 shadow-lg rounded-md">
                <div class="absolute inset-0 bg-gradient-to-b from-transparent to-slate-900/90 rounded-md"></div>
                <img src="{{asset('images/block2.png')}}" class="w-full h-full object-cover rounded-md" alt="Photo">
            </div>
        
            <div class="bg-slate-600 grid-search-box shadow-lg mb-2 col-span-12">
                <input type="search" class="grid-search-input bg-slate-600 w-full">
            </div>
        </div>
        
        <div class="grid grid-cols-12 gap-4 max-w-7xl mx-auto mb-6">
            <div class="bg-slate-600 col-span-12 md:col-span-5 row-span-3 flex flex-col rounded-tl-3xl rounded-bl-3xl rounded-r-md shadow-slate-900 drop-shadow-sm hover:drop-shadow-md">
                <div class="flex h-full">
                    <img src="{{asset('images/logo5.jpg')}}" class="w-1/4 h-full object-cover rounded-tl-3xl rounded-bl-3xl" alt="Photo">
                    <div class="ml-4 flex-1 p-4 md:p-8">
                        <h2 class="text-lg md:text-xl font-bold mb-4 text-cyan-300">Title One</h2>
                        <p class="text-sm md:text-base">
                            This is a small paragraph below the title.
                            Lorem is simply dummy text of the printing and typesetting industry. 
                            Lorem Ipsum has been the industry's standard dummy text ever 
                            since the 1500s.
                        </p>
                        <div class="flex justify-between mt-2">
                            <span class="font-bold">Salary</span>
                            <span class="font-bold">Location</span>
                        </div>
                        <button class="mt-4 bg-slate-800 text-white py-2 px-4 rounded hover:bg-slate-900">Read more</button>
                    </div>
                </div>
            </div>
        
            <div class="bg-slate-600 col-span-12 md:col-span-5 row-span-3 flex flex-col rounded-tl-3xl rounded-bl-3xl rounded-r-md shadow-slate-900 drop-shadow-sm hover:drop-shadow-md">
                <div class="flex h-full">
                    <img src="{{asset('images/logo3.jpg')}}" class="w-1/4 h-full object-cover rounded-tl-3xl rounded-bl-3xl" alt="Photo">
                    <div class="ml-4 flex-1 p-4 md:p-8">
                        <h2 class="text-lg md:text-xl font-bold mb-4 text-cyan-300">Title Two</h2>
                        <p class="text-sm md:text-base">
                            This is a small paragraph below the title.
                            Lorem is simply dummy text of the printing and typesetting industry. 
                            Lorem Ipsum has been the industry's standard dummy text ever 
                        </p>
                        <div class="flex justify-between mt-4">
                            <span class="font-bold">Salary</span>
                            <span class="font-bold">Location</span>
                        </div>
                        <button class="mt-4 bg-slate-800 text-white py-2 px-4 rounded hover:bg-slate-900">Read more</button>
                    </div>
                </div>
            </div>
        
            <aside class="bg-slate-600 col-span-12 md:col-span-2 row-span-6 rounded-md"></aside>
        
            <div class="bg-slate-600 col-span-12 md:col-span-5 row-span-3 flex flex-col rounded-tl-3xl rounded-bl-3xl rounded-r-md shadow-slate-900 drop-shadow-sm hover:drop-shadow-md">
                <div class="flex h-full">
                    <img src="{{asset('images/logo2.png')}}" class="w-1/4 h-full object-cover rounded-tl-3xl rounded-bl-3xl" alt="Photo">
                    <div class="ml-4 flex-1 p-4 md:p-8">
                        <h2 class="text-lg md:text-xl font-bold mb-4 text-cyan-300">Title Three</h2>
                        <p class="text-sm md:text-base">
                            This is a small paragraph below the title.
                            Lorem is simply dummy text of the printing and typesetting industry. 
                            Lorem Ipsum has been the industry's standard dummy text ever 
                        </p>
                        <div class="flex justify-between mt-4">
                            <span class="font-bold">Salary</span>
                            <span class="font-bold">Location</span>
                        </div>
                        <button class="mt-4 bg-slate-800 text-white py-2 px-4 rounded hover:bg-slate-900">Read more</button>
                    </div>
                </div>
            </div>
        
            <div class="bg-slate-600 col-span-12 md:col-span-5 row-span-3 flex flex-col rounded-tl-3xl rounded-bl-3xl rounded-r-md shadow-slate-900 drop-shadow-sm hover:drop-shadow-md">
                <div class="flex h-full">
                    <img src="{{asset('images/logo4.jpg')}}" class="w-1/4 h-full object-cover rounded-tl-3xl rounded-bl-3xl" alt="Photo">
                    <div class="ml-4 flex-1 p-4 md:p-8">
                        <h2 class="text-lg md:text-xl font-bold mb-4 text-cyan-300">Title Four</h2>
                        <p class="text-sm md:text-base">
                            This is a small paragraph below the title.
                            Lorem is simply dummy text of the printing and typesetting industry. 
                            Lorem Ipsum has been the industry's standard dummy text ever 
                        </p>
                        <div class="flex justify-between mt-4">
                            <span class="font-bold">Salary</span>
                            <span class="font-bold">Location</span>
                        </div>
                        <button class="mt-4 bg-slate-800 text-white py-2 px-4 rounded hover:bg-slate-900">Read more</button>
                    </div>
                </div>
            </div>
        </div>
        <div class="grid grid-cols-3 grid-height max-w-7xl gap-4 mx-auto mb-6">
            <div class="bg-slate-600 col-span-3">       
        </div>
        </div>
    </body>
</html>
