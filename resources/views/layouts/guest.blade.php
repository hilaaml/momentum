<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="overflow-hidden">

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

    <style>
        @keyframes gradientMove {
            0% { background-position: 0% 50%; }
            50% { background-position: 100% 50%; }
            100% { background-position: 0% 50%; }
        }
        .animate-gradient {
            background-size: 400% 400%;
            animation: gradientMove 60s ease-in-out infinite;
        }
        .mesh-gradient {
            background: radial-gradient(at 15% 20%, #1e1b4b 0%, transparent 80%),
                        radial-gradient(at 75% 20%, #172554 0%, transparent 75%),
                        radial-gradient(at 25% 80%, #312e81 0%, transparent 75%),
                        radial-gradient(at 80% 90%, #0f172a 0%, transparent 85%);
            background-blend-mode: screen;
            background-size: 200% 200%;
            animation: gradientMove 80s ease-in-out infinite;
        }
        .dark .mesh-gradient {
            background: radial-gradient(at 15% 20%, #0b1120 0%, transparent 80%),
                        radial-gradient(at 75% 20%, #0f172a 0%, transparent 75%),
                        radial-gradient(at 25% 80%, #1e1b4b 0%, transparent 75%),
                        radial-gradient(at 80% 90%, #111827 0%, transparent 85%);
        }
    </style>
</head>

<body class="relative min-h-screen bg-white overflow-hidden">
    <div class="flex justify-center items-center min-h-screen p-6">
        <!-- Left side - Form -->
        <div class="w-full max-w-md bg-gray-100 dark:bg-gray-900 rounded-xl shadow-lg p-8 md:p-12 text-center">
            <div class="w-full max-w-md text-center">
                {{ $slot }}
            </div>
        </div>

        <!-- Right side - Gradient background -->
        <div class="absolute inset-0 mesh-gradient -z-10">
            <!-- Decorative elements could be added here -->
        </div>
    </div>
</body>

</html>