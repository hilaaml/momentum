<x-app-layout>
    <div class="space-y-6">

        <x-content-card>
            <a class="text-xs text-gray-500 hover:underline" href="{{ route('challenges.index') }}">
                Challenges \
            </a>
            <div class="flex items-center justify-between">
                <h1 class="text-2xl font-bold text-gray-800 dark:text-white">Join Challenge</h1>
                <a href="{{ route('challenges.created') }}"
                    class="text-xs text-blue-600 hover:underline">
                    + Challenges
                </a>
            </div>
        </x-content-card>

        <x-content-card>
            @forelse ($availableChallenges as $challenge)
            <div class="flex items-stretch justify-between mb-2 rounded-lg overflow-hidden border shadow-sm bg-white dark:bg-gray-800 hover:shadow-md transition-all duration-150">

                <div class="flex-1 p-4 hover:bg-gray-50 dark:hover:bg-gray-700 transition-all duration-150">
                    <a href="{{ route('challenges.show', $challenge->id) }}">
                        <div class="font-semibold text-blue-700 hover:underline">
                            {{ $challenge->title }}
                        </div>
                        <p class="text-sm text-gray-600 dark:text-gray-400 mt-1">
                            {{ $challenge->description }}
                        </p>
                        <div class="text-sm text-gray-600 dark:text-gray-400">
                            {{ ucfirst($challenge->type) }} – {{ $challenge->target_days }} days
                        </div>
                    </a>
                </div>

                <div class="flex items-center px-4 bg-gray-50 dark:bg-gray-900 border-l hover:bg-blue-50 dark:hover:bg-blue-900 transition-all duration-150">
                    <form action="{{ route('challenge.join', $challenge->id) }}" method="POST">
                        @csrf
                        <button class="text-xs text-black font-medium hover:underline">
                            Join
                        </button>
                    </form>
                </div>
            </div>
            @empty
            <p class="text-sm text-gray-500">No available challenges for now.</p>
            @endforelse
        </x-content-card>
    </div>
</x-app-layout>