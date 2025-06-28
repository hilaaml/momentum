<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Welcome</title>
    @vite('resources/css/app.css')
</head>

<x-guest-layout>

    <div>
        <h1 class="text-3xl font-bold text-center mb-4 text-white">
            welcome to momentum!
            <span class="inline-flex items-center">
                <x-icon.logo class="w-5 h-5 inline-block align-middle" />
            </span>
        </h1>
        <p class="text-gray-600 text-1xl font-bold mb-6 text-left">
            ready to take control of your time and actually feel productive? register now
        </p>
    </div>

    <div class="flex space-x-4">
        <a href="{{ route('login') }}" class="bg-blue-600 text-white px-5 py-2 rounded hover:bg-blue-700">login</a>
        <a href="{{ route('register') }}" class="bg-gray-300 text-gray-800 px-5 py-2 rounded hover:bg-gray-400">register</a>
    </div>

</x-guest-layout>

</html>