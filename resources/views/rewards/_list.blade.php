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
