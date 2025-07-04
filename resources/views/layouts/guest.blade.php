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
        <div class="order-2 md:order-1 w-full md:w-1/3 h-[50vh] md:h-screen p-10 space-y-4 bg-white items-center flex flex-col justify-center">

            <div class="flex items-center p-3 rounded-lg bg-white w-full max-w-xs border border-gray-100">
                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" class="w-6 h-6 text-blue-600 mr-2">
                    <path d="M4 4h16v16H4z" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                    <path d="M8 4v16" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                </svg>
                <span class="text-gray-800 text-sm">Dashboard Overview</span>
            </div>

            <div class="flex items-center p-3 rounded-lg bg-white w-full max-w-xs border border-gray-100">
                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" class="w-6 h-6 text-blue-600 mr-2">
                    <path d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                </svg>
                <span class="text-gray-800 text-sm">Project Time Tracker</span>
            </div>

            <div class="flex items-center p-3 rounded-lg bg-white w-full max-w-xs border border-gray-100">
                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" class="w-6 h-6 text-blue-600 mr-2">
                    <path d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                </svg>
                <span class="text-gray-800 text-sm">Task Checklist</span>
            </div>

            <div class="flex items-center p-3 rounded-lg bg-white w-full max-w-xs border border-gray-100">
                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" class="w-6 h-6 text-blue-600 mr-2">
                    <path d="M13 10V3L4 14h7v7l9-11h-7z" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                </svg>
                <span class="text-gray-800 text-sm">Streak</span>
            </div>

            <div class="flex items-center p-3 rounded-lg bg-white w-full max-w-xs border border-gray-100">
                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" class="w-6 h-6 text-blue-600 mr-2">
                    <path d="M4 19h16M8 13v6M12 10v9M16 6v13" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                </svg>
                <span class="text-gray-800 text-sm">Visual Reports & Heatmap</span>
            </div>

            <div class="flex items-center p-3 rounded-lg bg-white w-full max-w-xs border border-gray-100">
                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" class="w-6 h-6 text-blue-600 mr-2">
                    <path d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                </svg>
                <span class="text-gray-800 text-sm">Calendar-based Journal</span>
            </div>
        </div>

    </div>
</body>

</html>