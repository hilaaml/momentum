<x-content-card>
    <a href="{{ route('challenges.available') }}" class="text-xs text-gray-500 hover:underline">
        Challenges \
    </a>
    <h1 class="text-2xl font-bold text-gray-800 dark:text-white">{{ $challenge->title }}</h1>

    <p class="text-xs text-gray-600 mt-1">
        Created by: <span class="font-medium text-gray-800 dark:text-white">{{ $challenge->creator->name }}</span> |
        Type: {{ ucfirst($challenge->type) }} | Target: {{ $challenge->target_days }} days <br>
        {{ $challenge->description }}
    </p>

    <a href="{{ route('challenges.participants', $challenge->id) }}"
        class="text-xs text-blue-600 hover:underline">
        <x-icon.eyes /> See Participants
    </a>
</x-content-card>