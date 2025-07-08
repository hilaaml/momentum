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
        <h1 class="text-2xl font-bold text-center mb-4 text-white">
            welcome to momentum!
            <span class="inline-flex items-center">
                <x-icon.logo class="w-5 h-5 inline-block align-middle" />
            </span>
        </h1>
        <p class="text-gray-700 dark:text-gray-300 mb-8">
            Organize your tasks, track every minute, generate insightful reports, and see your productivity soar — all in one beautiful dashboard.
        </p>
    </div>

    <div class="flex space-x-4">
        <x-primary-button :href="route('login')">Login</x-primary-button>
        <x-secondary-button :href="route('register')">Register</x-secondary-button>
    </div>

</x-guest-layout>

</html>