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

    <!-- Scripts -->
    @vite([
    'resources/js/app.js',
    'resources/js/heatmap-init.js',
    'resources/js/timers.js',
    'resources/css/app.css',
    'resources/js/reportCharts.js'
    ])
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/d3/3.5.17/d3.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/cal-heatmap/3.6.2/cal-heatmap.min.js"></script>

    @stack('scripts')
</head>

<body class="font-sans antialiased">
    <div class="h-screen flex overflow-hidden bg-gray-100 dark:bg-gray-900">

        @include('layouts.navigation')

        <div class="flex-1 flex flex-col overflow-hidden blurIn">

            <header class="px-3 my-3 border-b border-gray-200 dark:border-gray-700 pb-3">
                @isset($header)
                <h1 class="text-xl font-semibold text-gray-800 dark:text-gray-100">
                    {{ is_string($header) ? $header : '' }}
                </h1>

                @if (!is_string($header))
                <div class="mt-2">
                    {{ $header }}
                </div>
                @endif
                @endisset
            </header>


            <main class="flex-1 overflow-y-auto">
                <div class="max-w-screen-xl mx-auto px-4 sm:px-8 lg:px-20">
                    {{ $slot }}
                </div>
            </main>

        </div>
    </div>
</body>


</html>