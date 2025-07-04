<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Welcome</title>
    @vite('resources/css/app.css')
</head>

<x-guest-layout>

    <div class="text-center w-full">
        <h1 class="text-3xl font-bold mb-4 text-white">
            welcome to momentum!
            <span class="inline-flex items-center">
                <x-icon.logo class="w-5 h-5 inline-block align-middle" />
            </span>
        </h1>
        <p class="text-white text-1xl mb-6">
            ready to take control of your time and actually feel productive? register now
        </p>
    </div>

    <div class="flex justify-center space-x-4 w-full">
        <a href="{{ route('login') }}" class="bg-blue-800 text-white px-5 py-2 rounded hover:bg-blue-900">login</a>
        <a href="{{ route('register') }}" class="bg-gray-300 text-gray-800 px-5 py-2 rounded hover:bg-gray-400">register</a>
    </div>

</x-guest-layout>

</html>