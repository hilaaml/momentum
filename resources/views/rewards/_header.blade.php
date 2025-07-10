<x-content-card>
    <div class="flex items-center justify-between">
        <h2 class="text-lg font-semibold text-gray-800 dark:text-white">
            My Rewards
            <span class="text-xs text-indigo-600 dark:text-indigo-400">
                (My Coins: {{ $coins }})
            </span>
        </h2>

        <x-secondary-button
            x-data
            @click="$dispatch('open-modal', 'add-reward-modal')"
            class="text-xs text-indigo-600 hover:underline">
            + add new
        </x-secondary-button>
    </div>
</x-content-card>
