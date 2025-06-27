@props(['title'])

<header class="px-6 my-6 border-b border-gray-200 dark:border-gray-700 pb-4">
    <h1 class="text-xl font-semibold text-gray-800 dark:text-gray-100">
        {{ $title }}
    </h1>

    @if (isset($slot))
        <div class="mt-2">
            {{ $slot }}
        </div>
    @endif
</header>
