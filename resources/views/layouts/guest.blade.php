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

<body class="min-h-screen bg-gray-100 dark:bg-gray-900 text-gray-900 dark:text-gray-100 lg:overflow-hidden md:overflow-auto">

    <div class="flex flex-col md:flex-row min-h-screen">

        <!-- Slot content -->
        <div class="order-1 md:order-2 w-full md:w-2/3 bg-white dark:bg-gray-800 flex justify-center items-center p-6 lg:py-16">
                <div class="w-full max-w-xl bg-white dark:bg-gray-800 text-gray-900 dark:text-white shadow-lg rounded-lg 
                    p-10 transition-all duration-500 opacity-0 transform -translate-x-5 animate-slide-in overflow-auto lg:max-h-[90vh]">
                    <div class="flex flex-col justify-center items-center">{{ $slot }}</div>
                </div>
        </div>

        <!-- Fitur gambar -->
                <div class="order-2 md:order-1 w-full md:w-1/3 h-[50vh] md:h-screen p-10 space-y-6 bg-gray-100 dark:bg-gray-900 flex flex-col justify-center items-center overflow-y-auto">
            @foreach (['fitur1.jpg', 'fitur2.jpg', 'fitur3.jpg'] as $image)
            @for ($i = 0; $i < 2; $i++)
                <div class="shadow-lg rounded-lg overflow-hidden">
                <img src="{{ asset('images/' . $image) }}" alt="Feature {{ $loop->iteration }}" class="w-full">
        </div>
        @endfor
        @endforeach
    </div>

    </div>
</body>

</html>