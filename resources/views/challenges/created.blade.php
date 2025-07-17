<x-app-layout>
    <div class="space-y-6">

        <x-content-card>
            <a href="{{ route('challenges.available') }}" class="text-xs text-gray-500 hover:underline">
                Available Challenges \
            </a>
            <div class="flex items-center justify-between">
                <h1 class="text-2xl font-bold text-gray-800 dark:text-white">Created Challenge</h1>
                <a x-data x-on:click="$dispatch('open-modal', 'create-challenge-modal')""
                    class=" text-xs text-blue-600 hover:underline">
                    + Challenge
                </a>
            </div>
        </x-content-card>

        <x-content-card>
            @foreach ($myChallenges as $challenge)
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

                <div class="flex items-center px-4 bg-gray-50 dark:bg-gray-900 border-l hover:bg-red-50 dark:hover:bg-red-900 transition">
                    <button
                        x-data
                        x-on:click="$dispatch('open-modal', 'confirm-delete-{{ $challenge->id }}')"
                        class="text-xs text-red-600 hover:underline font-medium">
                        Delete
                    </button>
                </div>
            </div>

            <x-modal name="confirm-delete-{{ $challenge->id }}" focusable>
                <form method="POST" action="{{ route('challenges.destroy', $challenge->id) }}" class="p-6">
                    @csrf
                    @method('DELETE')
                    <h2 class="mb-2 pb-2 border-b text-sm font-semibold text-gray-600 dark:text-gray-300">Are you sure you want to delete this challenge?</h2>
                    <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">This action cannot be undone.</p>
                    <div class="mt-6 flex justify-end gap-2">
                        <x-secondary-button type="button" x-on:click="$dispatch('close')">Cancel</x-secondary-button>
                        <x-danger-button type="submit">Delete</x-danger-button>
                    </div>
                </form>
            </x-modal>
            @endforeach

            @include('challenges._form_modal')
        </x-content-card>

    </div>
</x-app-layout>