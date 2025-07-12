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

    <!-- Styles -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/cal-heatmap/3.6.2/cal-heatmap.css">

    @stack('scripts')
    <!-- Scripts -->
    @vite([
    'resources/js/app.js',
    'resources/js/heatmap-init.js',
    'resources/js/timers.js',
    'resources/css/app.css',
    'resources/js/reportCharts.js',
    'resources/js/journal-calendar.js',
    'resources/js/form-validation.js'
    ])
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/d3/3.5.17/d3.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/cal-heatmap/3.6.2/cal-heatmap.min.js"></script>

    @stack('scripts')
</head>

<!-- layout utama (app.blade.php / x-app-layout) -->

<body class="font-sans antialiased bg-gray-100 dark:bg-gray-900">
    <div class="min-h-screen flex flex-col" x-data="sidebar()" x-init="init()">

        {{-- Include navigation (mobile top + desktop sidebar) --}}
        @include('layouts.navigation')

        {{-- Konten utama --}}
        <div
            class="flex-1 transition-all duration-500 flex flex-col"
            :class="expanded ? 'md:ml-[150px]' : 'md:ml-[70px]'">

            <main class="min-h-screen flex flex-col pt-0">
                <div class="w-full max-w-[90%] sm:max-w-[80%] lg:max-w-[70%] mx-auto px-4 py-8 pb-[80px] md:pb-8">
                    {{ $slot }}
                </div>
            </main>
        </div>
    </div>
</body>


</html>