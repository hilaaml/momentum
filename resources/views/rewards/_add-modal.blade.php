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
