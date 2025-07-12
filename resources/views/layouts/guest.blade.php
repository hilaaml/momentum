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

<body class="min-h-screen bg-gray-100 dark:bg-gray-900 text-gray-900 dark:text-gray-100 flex items-center justify-center p-6">

    <div class="w-full max-w-xl bg-white dark:bg-gray-800 text-gray-900 dark:text-white shadow-lg rounded-lg 
                p-10 transition-all duration-500 animate-slide-in overflow-auto max-h-[90vh]">
        <div class="flex flex-col justify-center items-center">
            {{ $slot }}
        </div>
    </div>

</body>


</html>