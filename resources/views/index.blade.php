<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Laravel</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,600&display=swap" rel="stylesheet" />

        <!-- Styles -->
        @vite('resources/css/app.css')
    </head>
    <body class="font-sans antialiased dark:bg-gray-300 dark:text-black">
        <div class="grid grid-cols-12 grid-height max-w-7xl gap-2 mx-auto mt-10">
            <div class="bg-white col-span-2 row-span-6 shadow-lg">
                <nav class="grid p-4 text-center ">
                    <div class="mb-4 mt-4 bg-white py-4 hover:drop-shadow-md cursor-pointer">
                        <a href="#" class="">Home</a>
                    </div>
                    <div class="mb-4 bg-white py-4 hover:drop-shadow-md">
                        <a href="#" class="">Jobs</a>
                    </div>
                    <div class="mb-4 bg-white py-4 hover:drop-shadow-md">
                        <a href="#" class="">About</a>
                    </div>
                    <div class="mb-4 bg-white py-4 hover:drop-shadow-md">
                        <a href="#" class="">Contact</a>
                    </div>

                <nav>
            </div>

            <div class="bg-white col-span-7 row-span-6 shadow-lg">
                <h1 class="text-3xl text-cyan-600 p-4 text-center">Web3Defi</h1>
                <p class="p-4 -tracking-wider">
                    Lorem is simply dummy text of the printing and typesetting industry. 
                    Lorem Ipsum has been the industry's standard dummy text ever 
                    since the 1500s, when an unknown printer took a galley of type
                    and scrambled it to make a type specimen book.
                </p>
                <p class="p-4 -tracking-wider">
                    Lorem is simply dummy text of the printing and typesetting industry. 
                    Lorem Ipsum has been the industry's standard dummy text ever 
                    since the 1500s, when an unknown printer took a galley of type
                    and scrambled it to make a type specimen book.
                </p>
                <p class="p-4 -tracking-wider">
                    Lorem is simply dummy text of the printing and typesetting industry. 
                    Lorem Ipsum has been the industry's standard dummy text ever 
                    since the 1500s, when an unknown printer took a galley of type
                    and scrambled it to make a type specimen book.
                </p>
            </div>
            <div class="bg-white col-span-3 row-span-6 shadow-lg">
                Three
            </div>
            <div class="bg-white grid-search-box shadow-lg mb-2">
                <input type="search" class="grid-search-input">
            </div>
        </div>

        <div class="grid grid-cols-12 grid-height max-w-7xl gap-4 mx-auto mb-6">
            <div class="bg-white col-span-5 row-span-3">
                <div class="grid grid-cols-2 gap-2">
                    <p class=" grid justify-center items-center"> 
                    lorem when an unknown printer took a galley of type
                    and scrambled it to make a type specimen book
                    </p>
                </div>
            </div>
            
            <div class="bg-white col-span-5 row-span-3 p-4 flex flex-col">
                 <div class="flex">
                    <img src="path/to/photo.jpg" class="w-1/4 h-full object-cover" alt="Photo">
                    <div class="ml-4 flex-1">
                        <h2 class="text-xl font-bold">Title Here</h2>
                        <p class="text-gray-700">
                            This is a small paragraph below the title.
                            Lorem is simply dummy text of the printing and typesetting industry. 
                            Lorem Ipsum has been the industry's standard dummy text ever 
                            since the 1500s, when an unknown printer took a galley of type
                            and scrambled it to make a type specimen book
                        </p>
                        <div class="flex justify-between mt-2">
                            <span class="text-gray-600">Salary</span>
                            <span class="text-gray-600">Location</span>
                        </div>
                         <button class="mt-4 bg-blue-500 text-white py-2 px-4 rounded hover:bg-blue-600">Button</button>
                    </div>
                </div>
            </div>

            <div class="bg-white col-span-2 row-span-6"></div>
            <div class="bg-white col-span-5 row-span-3">Card one</div>
            <div class="bg-white col-span-5 row-span-3">Card Two</div>
        </div>

        <div class="grid grid-cols-3 grid-height max-w-7xl gap-4 mx-auto mb-6">
            <div class="bg-white col-span-3"></div>
        </div>
    </body>
</html>
