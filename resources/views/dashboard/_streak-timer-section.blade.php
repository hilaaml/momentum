<x-content-card>
    <div class="flex justify-between items-center">
        <div>
            @include('dashboard._timer-display', ['seconds' => $totalTodayInSeconds])

            <button
                x-data
                x-on:click="$dispatch('open-modal', 'timeline-modal')"
                class="text-indigo-600 dark:text-indigo-400 hover:underline text-sm">
                timeline &rarr;
            </button>

            <x-modal name="timeline-modal" :show="false">
                <div class="p-6 space-y-4">
                    <h2> Today Work Log </h2>
                    <x-timeline-table :logs="$todayLogs" />
                    <div class="flex justify-end">
                        <x-secondary-button x-on:click="$dispatch('close')">Close</x-secondary-button>
                    </div>
                </div>
            </x-modal>
        </div>

        <div class="text-center cursor-pointer"
            x-data
            @click="$dispatch('open-modal', 'streak-setting-modal')">
            <h2 class="text-sm font-semibold text-gray-600 dark:text-gray-300">Streak</h2>
            <p class="text-2xl text-green-500 font-bold">{{ auth()->user()->getStreakDays() }}d</p>
        </div>
    </div>

    <x-modal name="streak-setting-modal" focusable>
        <div class="p-6">
            <h2 class="text-lg font-semibold text-gray-800 dark:text-gray-100">
                {{ __('Set Minimum Productive Time per Day for Streak') }}
            </h2>

            <form method="POST" action="{{ route('dashboard.streak-config') }}" class="mt-4 space-y-4">
                @csrf
                <label for="streak_minute_input" class="block text-sm text-gray-700 dark:text-gray-300">
                    Minimum time per day (in minutes):
                </label>
                <input type="number" name="streak_minute_input" min="1"
                    value="{{ old('streak_minute_input', floor(auth()->user()->streak_minimum_seconds / 60)) }}"
                    class="w-full rounded border border-gray-300 dark:bg-gray-800 dark:text-white px-2 py-1" required>
                <x-primary-button class="w-full">{{ __('Save') }}</x-primary-button>
            </form>
        </div>
    </x-modal>
</x-content-card>