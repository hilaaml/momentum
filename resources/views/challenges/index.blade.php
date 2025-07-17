<x-app-layout>
    <div class="space-y-6">

        <x-content-card>
            <div class="flex items-center justify-between">
                <h2 class="text-2xl font-bold">My Challenges</h2>
                <a href="{{ route('challenges.available') }}" class="text-xs text-blue-600 hover:underline">
                    + Join new <br> Challenge
                </a>
            </div>
        </x-content-card>

        <x-content-card>
            @forelse ($joinedChallenges as $challenge)
            <div class="flex items-stretch justify-between mb-2 rounded-lg overflow-hidden border shadow-sm bg-white dark:bg-gray-800 hover:shadow-md transition-all duration-150">

                <div class="flex-1 p-4 hover:bg-gray-50 dark:hover:bg-gray-700 transition-all duration-150">
                    <a href="{{ route('challenges.show', $challenge->id) }}">
                        <div class="font-semibold text-blue-700 hover:underline">
                            {{ $challenge->title }}
                        </div>
                        <div class="text-sm text-gray-600 dark:text-gray-400">
                            {{ ucfirst($challenge->type) }} – {{ $challenge->target_days }} days
                        </div>
                    </a>
                </div>

                <div class="flex items-center bg-gray-50 dark:bg-gray-900 px-4 border-l transition-all duration-150 hover:bg-red-50 dark:hover:bg-red-900">
                    <form action="{{ route('challenge.leave', $challenge->id) }}" method="POST">
                        @csrf
                        <button type="submit" class="text-xs text-red-600 font-medium hover:underline">
                            Leave
                        </button>
                    </form>
                </div>
            </div>
            @empty
            <p class="text-xs text-center text-gray-500">You haven't joined any challenges yet.</p>
            @endforelse
        </x-content-card>

    </div>
</x-app-layout>