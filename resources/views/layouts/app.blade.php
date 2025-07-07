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

<body class="font-sans antialiased">
    <div class="min-h-screen flex bg-gray-100 dark:bg-gray-900">
        <!-- Sidebar -->
        <div class="fixed inset-y-0 left-0">
            @include('layouts.navigation')
        </div>

        <!-- Main Content -->
        <div class="flex-1 ml-[88px]"> <!-- Default width when sidebar is collapsed -->
            <main class="min-h-screen flex flex-col {{ Request::is('dashboard') || Request::is('journal*') ? 'justify-center' : '' }}">
                <div class="w-full max-w-screen-xl px-5 sm:px-10 lg:px-20 mx-auto py-8">
                    {{ $slot }}
                </div>
            </main>
        </div>
    </div>
</body>

</html>