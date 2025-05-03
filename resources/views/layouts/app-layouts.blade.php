<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>@yield('title', 'Web3Defi')</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,600&display=swap" rel="stylesheet" />

        <!-- Styles -->
        @notifyCss
        @vite(['resources/css/app.css', 'resources/js/app.js'])
        <style>
            html {
                scroll-behavior: smooth;
            }
        </style>
    </head>
    <body class="font-sans antialiased bg-slate-700">
        @yield('content')

        <x-notify::notify />
        @notifyJs
    </body>
</html>
