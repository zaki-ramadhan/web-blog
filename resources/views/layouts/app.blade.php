<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <meta name="description"
            content="OneBlog adalah platform blogging modern yang mudah digunakan dan aman.">
        <meta name="keywords" content="blog, blogging, oneblog, platform blog">
        <meta name="author" content="Zaki R">

        <!-- Untuk SEO tambahan -->
        <meta property="og:title" content="OneBlog - #1 Platform Blogging">
        <meta property="og:description"
            content="OneBlog adalah platform blogging modern yang mudah digunakan dan aman.">
        <meta property="og:type" content="website">
        <meta property="og:url" content="https://oneblog.my.id">
        {{-- <meta property="og:image" content="{{ asset('images/preview.png') }}"> --}}

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])

        {{-- css stack --}}
        @stack('style')
    </head>

    <body class="font-sans antialiased">
        <div class="min-h-screen bg-gray-100">
            @include('layouts.navigation')

            <!-- Page Heading -->
            @isset($header)
                <header class="bg-white shadow-sm">
                    <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                        {{ $header }}
                    </div>
                </header>
            @endisset

            <!-- Page Content -->
            <main>
                {{ $slot }}
            </main>
        </div>

        {{-- javascript stack  --}}
        {{-- menyediakan slot untuk script js yang akan digunakan di halaman child view nya --}}
        @stack('script')
    </body>

</html>
