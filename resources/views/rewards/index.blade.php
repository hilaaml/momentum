<x-app-layout>
    <div class="max-w-3xl mx-auto mt-8 space-y-6">
        <x-content-card>
            <div class="flex items-center justify-between">
                <h2 class="text-lg font-semibold text-gray-800 dark:text-white">My Rewards
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

        <x-modal name="add-reward-modal" focusable>
            <div class="p-6">
                <h2 class="text-lg font-semibold text-gray-800 dark:text-gray-100">
                    Add New Reward
                </h2>

                <form method="POST" action="{{ route('rewards.store') }}" class="mt-4 space-y-4">
                    @csrf
                    <div>
                        <label class="text-sm block text-gray-700 dark:text-gray-300">Reward Name</label>
                        <input type="text" name="name" required class="w-full px-2 py-1 border rounded dark:bg-gray-800 dark:text-white">
                    </div>

                    <div>
                        <label class="text-sm block text-gray-700 dark:text-gray-300">Price (coins)</label>
                        <input type="number" name="price" min="1" required class="w-full px-2 py-1 border rounded dark:bg-gray-800 dark:text-white">
                    </div>

                    <x-primary-button class="w-full">Add Reward</x-primary-button>
                </form>
            </div>
        </x-modal>


        @if($rewards->count())
        <x-content-card>
            <div class="grid grid-cols-1 gap-4">
                @foreach ($rewards as $reward)
                <div class="flex items-center justify-between border-b pb-2">
                    <div>
                        <p class="font-medium text-gray-800 dark:text-white">{{ $reward->name }}</p>
                        <p class="text-sm text-gray-500 dark:text-gray-300">{{ $reward->price }} coins</p>
                    </div>
                    <form method="POST" action="{{ route('rewards.redeem', $reward) }}">
                        @csrf
                        <x-secondary-button>Redeem</x-secondary-button>
                    </form>

                </div>
                @endforeach
            </div>
        </x-content-card>
        @else
        <x-content-card>
            <p class="text-center text-sm text-gray-500">You don't have any rewards yet.</p>
        </x-content-card>
        @endif
    </div>
</x-app-layout>