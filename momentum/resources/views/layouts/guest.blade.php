<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="min-h-screen bg-white">
    <div class="flex flex-col md:flex-row min-h-screen ">

        <div class="order-1 md:order-2 w-full md:w-2/3 bg-gray-100 flex flex-col p-10 justify-center items-center">
            <div class="w-full max-w-xl flex flex-col p-10 justify-center items-center bg-blue-600 shadow-lg rounded-lg 
                transition-all duration-500 opacity-0 transform -translate-x-10 animate-slide-in">
                {{ $slot }}
            </div>
        </div>

        <!-- Sidebar -->
        <div class="order-2 md:order-1 w-full md:w-1/3 h-[50vh] md:h-screen overflow-y-scroll scrollbar-hidden p-10 space-y-6 bg-white items-center flex flex-col justify-center">

            <div class="shadow-lg rounded-lg overflow-hidden">
                <img src="{{ asset('images/fitur1.jpg') }}" alt="Dashboard Overview" class="w-full">
            </div>

            <div class="shadow-lg rounded-lg overflow-hidden">
                <img src="{{ asset('images/fitur2.jpg') }}" alt="Project Time Tracker" class="w-full">
            </div>

            <div class="shadow-lg rounded-lg overflow-hidden">
                <img src="{{ asset('images/fitur3.jpg') }}" alt="Task Checklist" class="w-full">
            </div>

            <div class="shadow-lg rounded-lg overflow-hidden">
                <img src="{{ asset('images/fitur3.jpg') }}" alt="Streak" class="w-full">
            </div>

            <div class="shadow-lg rounded-lg overflow-hidden">
                <img src="{{ asset('images/fitur3.jpg') }}" alt="Visual Reports & Heatmap" class="w-full">
            </div>

            <div class="shadow-lg rounded-lg overflow-hidden">
                <img src="{{ asset('images/fitur3.jpg') }}" alt="Calendar-based Journal" class="w-full">
            </div>
        </div>

    </div>
</body>




</html>